<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\WeddingHall;
use App\Models\OfferSale;
use App\Service\BookingService;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentForm extends Component
{
    public $booking;
    public $weddingHall;
    public $amount;
    public $paymentMethod;
    public $fullName;
    public $cardNumber;
    public $cardExpiration;
    public $cvv;
    public $salePrice = 0;
    public $finalAmount = 0;
    public $depositRequired = 0;
    public $loading = false;

    protected $rules = [
        'amount' => 'required|numeric|min:0',
        'paymentMethod' => 'required|in:credit_card,debit_card,paypal',
        'fullName' => 'required_if:paymentMethod,credit_card,debit_card|string|max:255',
        'cardNumber' => 'string',
        'cardExpiration' => 'required_if:paymentMethod,credit_card,debit_card|date_format:m/y',
        'cvv' => 'required_if:paymentMethod,credit_card,debit_card|numeric|digits:4',
    ];

    protected $messages = [
        'amount.required' => 'يرجى إدخال قيمة المبلغ',
        'amount.numeric' => 'يجب أن يكون المبلغ رقماً',
        'amount.min' => 'يجب أن يكون المبلغ أكبر من صفر',

        'paymentMethod.required' => 'يرجى اختيار طريقة الدفع',
        'paymentMethod.in' => 'طريقة الدفع المختارة غير صالحة',

        'fullName.required_if' => 'يرجى إدخال اسم حامل البطاقة',
        'fullName.string' => 'يجب أن يكون الاسم نصاً',
        'fullName.max' => 'يجب ألا يتجاوز الاسم 255 حرفاً',

        'cardNumber.required_if' => 'يرجى إدخال رقم البطاقة',
        'cardNumber.string' => 'يجب أن يكون رقم البطاقة نصاً',

        'cardExpiration.required_if' => 'يرجى إدخال تاريخ انتهاء البطاقة',
        'cardExpiration.date_format' => 'صيغة تاريخ الانتهاء غير صحيحة (الصيغة الصحيحة: شهر/سنة)',

        'cvv.required_if' => 'يرجى إدخال رمز الأمان CVV',
        'cvv.numeric' => 'يجب أن يكون رمز الأمان أرقاماً فقط',
        'cvv.digits' => 'يجب أن يتكون رمز الأمان من 4 أرقام'
    ];

    public function mount(Booking $booking)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->booking = $booking->load('weddingHall');
        $this->weddingHall = $booking->weddingHall;
        
        try {
            // حساب السعر النهائي مع مراعاة العروض
            $activeSale = OfferSale::where('wedding_hall_id', $booking->wedding_hall_id)
                                 ->where('status', true)
                                 ->where('start_date', '<=', now())
                                 ->where('end_date', '>=', now())
                                 ->first();
            
            $this->finalAmount = $booking->total_cost;
            if ($activeSale) {
                $this->salePrice = $activeSale->sale_price;
                $this->finalAmount = $activeSale->sale_price;
            }

            // حساب قيمة العربون من قاعة الأفراح
         
            $this->depositRequired = $this->weddingHall->deposit_price;
            $this->amount = $this->depositRequired;

        } catch (\Exception $e) {
            Log::error('Payment Form Mount Error: ' . $e->getMessage());
            session()->flash('error', 'حدث خطأ في تحميل بيانات الدفع');
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submitPayment()
    {
        $this->loading = true;
        $this->validate();

        try {
            DB::beginTransaction();

            // التحقق من المبلغ
            if (abs($this->amount - $this->depositRequired) > 0.01) {
                throw new \Exception('المبلغ المدخل يجب أن يساوي قيمة التأمين المطلوب');
            }

            // التحقق من حالة الحجز
            if ($this->booking->status !== 'Pending') {
                throw new \Exception('لا يمكن إتمام الدفع لهذا الحجز');
            }

            // إنشاء عملية الدفع
            $payment = Payment::create([
                'booking_id' => $this->booking->id,
                'payment_date' => now(),
                'amount' => $this->amount,
                'payment_method' => $this->paymentMethod,
                'wedding_hall_id' => $this->booking->wedding_hall_id,
                'payment_type' => 'deposit',
                'status' => 'completed',
                'transaction_id' => uniqid('PAY-'),
                'payment_details' => [
                    'card_holder' => $this->fullName,
                    'card_last_digits' => substr($this->cardNumber, -4),
                    'payment_date' => now()->format('Y-m-d H:i:s')
                ]
            ]);

            // تحديث حالة الحجز
            $bookingService = new BookingService();
            $result = $bookingService->payDeposit($this->booking);

            if ($result['status'] === 'error') {
                throw new \Exception($result['message']);
            }

            DB::commit();
            
            session()->flash('message', 'تم إتمام عملية الدفع بنجاح!');
            return redirect()->route('bookings.show', $this->booking->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Error: ' . $e->getMessage());
            session()->flash('error', $e->getMessage());
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.payment-form')->layout('layouts.app');
    }
}
