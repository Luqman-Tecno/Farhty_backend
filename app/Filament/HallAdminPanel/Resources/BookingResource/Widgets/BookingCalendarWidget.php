<?php

namespace App\Filament\HallAdminPanel\Resources\BookingResource\Widgets;

use App\Enum\BookingStatusEnum;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Session;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use Filament\Forms\Components\Steps\Step;
use Filament\Forms\Components\Wizard\Step as WizardStep;
use App\Enum\BookingShiftEnum;
use App\Models\Services;
use Filament\Notifications\Notification;
use App\Service\BookingService;

class BookingCalendarWidget extends FullCalendarWidget
{
    protected BookingService $bookingService;
    protected $weddingHall;
    public Model|string|null $model = Booking::class;

    public function boot(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
        $this->weddingHall = auth()->user()->weddingHall;
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Booking::with('weddingHall')->where('status' , BookingStatusEnum::Booked->value)
            ->get()
            ->map(function (Booking $task) {
                return [
                    'id' => $task->id,
                    'title' => $task->weddingHall->hall_name,
                    'start' => $task->booking_date,
                    'end' => $task->end_time,
                ];
            })
            ->toArray();
    }

    public static function canView(): bool
    {
        return false;
    }

    public function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    TextInput::make('title')
                        ->label('العنوان')
                        ->required()
                        ->maxLength(255),
                ])
        ];
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make()
                ->label('إضافة حجز جديد')
                ->model(Booking::class)
                ->steps([
                    WizardStep::make('معلومات الحجز')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    DatePicker::make('booking_date')
                                        ->required()
                                        ->label('تاريخ الحجز'),

                                    Select::make('shift')
                                        ->options([
                                            BookingShiftEnum::DAY->value => 'فترة صباحية (8 ص - 5 م)',
                                            BookingShiftEnum::NIGHT->value => 'فترة مسائية (6 م - 12 م)',
                                            BookingShiftEnum::FULL_DAY->value => 'يوم كامل (8 ص - 12 م)'
                                        ])
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($set) {
                                            // إعادة حساب التكلفة الإجمالية عند تغيير الفترة
                                            $set('total_cost', null);
                                            $set('deposit_cost', null);
                                        })
                                        ->reactive()
                                        ->label('الفترة'),
                                    TextInput::make('children_count')
                                        ->numeric()
                                        ->required()
                                        ->live()
                                        ->reactive()
                                        ->afterStateUpdated(function ($set) {
                                            // إعادة حساب التكلفة الإجمالية عند تغيير عدد الأطفال
                                            $set('total_cost', null);
                                            $set('deposit_cost', null);
                                        })
                                        ->label('عدد الأطفال'),
                                    Select::make('additional_services')
                                        ->multiple()
                                        ->options(Services::where('wedding_hall_id', auth()->user()->weddingHall->id)->pluck('name', 'id'))
                                        ->live()
                                        ->reactive()
                                        ->afterStateUpdated(function ($set) {
                                            // إعادة حساب التكلفة الإجمالية عند تغيير الخدمات
                                            $set('total_cost', null);
                                            $set('deposit_cost', null);
                                        })
                                        ->label('الخدمات الإضافية')
                                ]),
                        ]),
                    WizardStep::make('تفاصيل التكلفة')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('total_cost')
                                        ->numeric()
                                        ->disabled()
                                        ->live()
                                        ->reactive()
                                        ->afterStateUpdated(function ($set, $get) {
                                            $this->calculateAndSetPrices($set, $get);
                                        })
                                        ->afterStateHydrated(function ($set, $get) {
                                            $this->calculateAndSetPrices($set, $get);
                                        })
                                        ->label('التكلفة الإجمالية'),
                                        
                                    TextInput::make('deposit_cost')
                                        ->numeric()
                                        ->disabled()
                                        ->live()
                                        ->reactive()
                                        ->afterStateHydrated(function ($get) {
                                            if (!$this->weddingHall) {
                                                return 0;
                                            }
                                            
                                            return $this->weddingHall->deposit_price;
                                        })
                                        ->label('قيمة العربون'),
                                        
                                    TextInput::make('services_cost')
                                        ->numeric()
                                        ->disabled()
                                        ->reactive()
                                        ->afterStateHydrated(function ($get) {
                                            if (!$this->weddingHall) {
                                                return 0;
                                            }

                                            $selectedServices = $get('additional_services') ?? [];
                                            if (empty($selectedServices)) {
                                                return 0;
                                            }

                                            return Services::whereIn('id', $selectedServices)
                                                ->where('wedding_hall_id', $this->weddingHall->id)
                                                ->sum('price');
                                        })
                                        ->label('تكلفة الخدمات الإضافية'),
                                        
                                    TextInput::make('children_cost')
                                        ->numeric()
                                        ->disabled()
                                        ->reactive()
                                        ->afterStateHydrated(function ($get) {
                                            if (!$this->weddingHall) {
                                                return 0;
                                            }
                                            
                                            $childrenCount = (int) $get('children_count') ?: 0;
                                            $pricePerChild = $this->weddingHall->price_per_child ?: 0;
                                            
                                            return $childrenCount * $pricePerChild;
                                        })
                                        ->label('تكلفة الأطفال')
                                ]),
                        ]),
                    WizardStep::make('معلومات الدفع')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Select::make('payment_method')
                                        ->options([
                                            'credit_card' => 'بطاقة ائتمان',
                                            'debit_card' => 'بطاقة مدين',
                                            'paypal' => 'باي بال'
                                        ])
                                        ->required()
                                        ->reactive()
                                        ->label('طريقة الدفع'),

                                    TextInput::make('amount')
                                        ->label('المبلغ')
                                        ->disabled()
                                        ->reactive()    
                                        ->dehydrated(false)
                                        ->default(function ($get) {
                                            // حساب المبلغ المطلوب بناءً على العربون
                                            return $this->calculateRequiredDeposit($get('total_cost'));
                                        }),

                                    // حقول بطاقة الائتمان - تظهر فقط عند اختيار الدفع بالبطاقة
                                    TextInput::make('full_name')
                                        ->label('الاسم على البطاقة')
                                        ->required()
                                        ->visible(fn ($get) => in_array($get('payment_method'), ['credit_card', 'debit_card'])),

                                    TextInput::make('card_number')
                                        ->label('رقم البطاقة')
                                        ->required()
                                        ->mask('9999 9999 9999 9999')
                                        ->visible(fn ($get) => in_array($get('payment_method'), ['credit_card', 'debit_card'])),

                                    TextInput::make('card_expiration')
                                        ->label('تاريخ الانتهء')
                                        ->required()
                                        ->mask('99/99')
                                        ->placeholder('MM/YY')
                                        ->visible(fn ($get) => in_array($get('payment_method'), ['credit_card', 'debit_card'])),

                                    TextInput::make('cvv')
                                        ->label('رمز الأمان')
                                        ->required()
                                        ->length(3)
                                        ->mask('999')
                                        ->visible(fn ($get) => in_array($get('payment_method'), ['credit_card', 'debit_card'])),
                                ]),
                        ]),
                ])
                ->using(function (array $data) {
                    try {
                        DB::beginTransaction();

                        // إنشاء الحجز
                        $data['start_time'] = $this->getShiftStartTime($data['shift']);
                        $data['end_time'] = $this->getShiftEndTime($data['shift']);
                        $data['notes'] = '';
                  
                        $booking = $this->bookingService->processBooking(
                            auth()->user(),
                            auth()->user()->weddingHall,
                            $data
                        );
                        if ($booking['status'] === 'error') {
                            throw new \Exception($booking['message']);
                        }

                        // إنشاء عملية الدفع
                        $payment = Payment::create([
                            'booking_id' => $booking['booking']->id,
                            'payment_date' => now(),
                            'amount' => $data['amount'] ?? 0,
                            'payment_method' => $data['payment_method'],
                            'wedding_hall_id' => $this->weddingHall->id,
                            'payment_type' => 'deposit',
                            'status' => 'completed'
                        ]);
                     
                  
                        // تحديث حالة الحجز بعد الدفع
                       $datas = $this->bookingService->payDeposit($booking['booking']);

                        DB::commit();
                        
                        Notification::make()
                            ->success()
                            ->title('تم إنشاء الحجز والدفع بنجاح')
                            ->send();

                        return $booking['booking'];

                    } catch (\Exception $e) {
                        DB::rollBack();
                        Notification::make()
                            ->danger()
                            ->title('حدث طأ')
                            ->body($e->getMessage())
                            ->send();
                        
                        throw $e;
                    }
                })
        ];
    }

    // يمكنك نقل هذه الدوال المساعدة إلى BookingService
    private function getShiftStartTime(string $shift): string
    {
        return match ($shift) {
            BookingShiftEnum::DAY->value => '08:00:00',
            BookingShiftEnum::NIGHT->value => '18:00:00',
            BookingShiftEnum::FULL_DAY->value => '08:00:01',
            default => throw new \InvalidArgumentException('Invalid shift'),
        };
    }

    private function getShiftEndTime(string $shift): string
    {
        return match ($shift) {
            BookingShiftEnum::DAY->value => '17:00:00',
            BookingShiftEnum::NIGHT->value => '23:59:59',
            BookingShiftEnum::FULL_DAY->value => '23:59:58',
            default => throw new \InvalidArgumentException('Invalid shift'),
        };
    }

    private function calculateRequiredDeposit($totalCost): float
    {
        return ($totalCost * ($this->weddingHall->deposit_percentage ?? 30)) / 100;
    }

    private function calculateAndSetPrices($set, $get): void
    {
        if (!$this->weddingHall) {
            return;
        }

        $shift = $get('shift');
        $childrenCount = (int) $get('children_count') ?: 0;
        $selectedServices = $get('additional_services') ?? [];

        $shiftPrices = $this->weddingHall->shift_prices;
        $shiftPrice = $shiftPrices[$shift] ?? 0;
        $pricePerChild = $this->weddingHall->price_per_child ?: 0;
        $childrenCost = $childrenCount * $pricePerChild;
        
        $servicesCost = 0;
        if (!empty($selectedServices)) {
            $servicesCost = Services::whereIn('id', $selectedServices)
                ->where('wedding_hall_id', $this->weddingHall->id)
                ->sum('price');
        }

        $totalCost = $shiftPrice + $childrenCost + $servicesCost;
        
        $set('total_cost', $totalCost);
        $set('deposit_cost', ($totalCost * ($this->weddingHall->deposit_percentage ?: 30)) / 100);
        $set('children_cost', $childrenCost);
        $set('services_cost', $servicesCost);
    }
}
