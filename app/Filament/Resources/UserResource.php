<?php

namespace App\Filament\Resources;

use App\Enum\UserTypeEnum;
use App\Models\User;
use App\Models\UserResource\Pages;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static ?string $navigationLabel = 'ادارة المستخدمين';
    protected static ?string $modelLabel = 'مستخدم';
    protected static ?string $pluralModelLabel = 'المستخدمين';
    protected static ?string $navigationGroup = 'العمليات';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('الاسم')
                    ->required(),
                TextInput::make('email')->label('البريد الالكتروني')
                    ->required(),
                TextInput::make('password')->label("كلمة المرور")
                    ->password()
                    ->rule(Password::default())
                    ->dehydrateStateUsing(fn($state) => \Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context): bool => $context === 'create')
                    ->revealable()
                    ->maxLength(100),
                
                TextInput::make('phone_number')->label("رقم الهاتف")
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Select::make('type')->label("النوع")
                    ->options(UserTypeEnum::class)
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')->label('الايميل')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')->label('الدور')
                    ->formatStateUsing(fn (string $state): string => UserTypeEnum::from($state)->getLabel())
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\UserResource\Pages\ListUsers::route('/'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}
