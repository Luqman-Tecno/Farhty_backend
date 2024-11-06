<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة حجز #{{ $booking->id }}</title>
    <style>
        body {
            font-family: tajawal;
            direction: rtl;
            padding: 20px;
            color: #1a1a1a;
            margin: 0;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4338ca;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #4338ca;
        }
        .header p {
            margin: 5px 0;
        }
        .section {
            margin-bottom: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
            color: #4338ca;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        td {
            padding: 4px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 11px;
        }
        .amount {
            text-align: left;
            font-family: Arial, sans-serif;
        }
        .total-row {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #4338ca;
            color: #6b7280;
            font-size: 11px;
        }
        .status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            background-color: #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>فاتورة حجز</h1>
        <p>رقم الفاتورة: #{{ $booking->id }} | تاريخ الإصدار: {{ now()->format('Y-m-d') }}</p>
    </div>

    <div class="section">
        <div class="section-title">معلومات العميل والقاعة</div>
        <table>
            <tr>
                <td width="35%">اسم العميل:</td>
                <td>{{ $booking->user->name }}</td>
            </tr>
            <tr>
                <td>ر��م الهاتف:</td>
                <td>{{ $booking->user->phone_number }}</td>
            </tr>
            <tr>
                <td>اسم القاعة:</td>
                <td>{{ $booking->weddingHall->hall_name }}</td>
            </tr>
            <tr>
                <td>المدينة/المنطقة:</td>
                <td>{{ $booking->weddingHall->city->name_ar }} - {{ $booking->weddingHall->region }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">تفاصيل الحجز</div>
        <table>
            <tr>
                <td width="35%">تاريخ المناسبة:</td>
                <td>{{ Carbon\Carbon::parse($booking->booking_date)->locale('ar')->translatedFormat('l j F Y') }}</td>
            </tr>
            <tr>
                <td>الفترة:</td>
                <td>{{ \App\Enum\BookingShiftEnum::fromValue($booking->shift)->getLabel() }}</td>
            </tr>
            <tr>
                <td>الوقت:</td>
                <td>{{ Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
            </tr>
            <tr>
                <td>عدد الأطفال:</td>
                <td>{{ $booking->children_count }}</td>
            </tr>
            <tr>
                <td>حالة الحجز:</td>
                <td><span class="status">{{ \App\Enum\BookingStatusEnum::fromValue($booking->status)->getLabel() }}</span></td>
            </tr>
        </table>
    </div>


    <div class="section">
        <div class="section-title">تفاصيل الدفع</div>
        <table>
            <tr>
                <td width="60%">التكلفة الأساسية</td>
                <td class="amount">{{ number_format($booking->total_cost - ($booking->children_count * $booking->weddingHall->price_per_child), 2) }} د.ل</td>
            </tr>
            @if($booking->children_count > 0)
            <tr>
                <td>تكلفة الأطفال ({{ $booking->children_count }} × {{ number_format($booking->weddingHall->price_per_child, 2) }})</td>
                <td class="amount">{{ number_format($booking->children_count * $booking->weddingHall->price_per_child, 2) }} د.ل</td>
            </tr>
            @endif
            @if($booking->services && count($booking->services) > 0)
                @foreach($booking->services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td class="amount">{{ number_format($service->price, 2) }} د.ل</td>
                </tr>
                @endforeach
            @endif
            <tr class="total-row">
                <td>الإجمالي</td>
                <td class="amount">{{ number_format($booking->total_cost, 2) }} د.ل</td>
            </tr>
            <tr>
                <td>العربون ({{ $booking->weddingHall->deposit_percentage }}%)</td>
                <td class="amount">{{ number_format($booking->deposit_cost, 2) }} د.ل</td>
            </tr>
            <tr class="total-row">
                <td>المبلغ المتبقي</td>
                <td class="amount">{{ number_format($booking->total_cost - $booking->deposit_cost, 2) }} د.ل</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">تنبيه هام</div>
        <p style="margin: 0; padding: 5px;">يرجى إحضار هذه الفاتورة  يوم الموعد</p>
    </div>

    @if($booking->notes)
    <div class="section">
        <div class="section-title">ملاحظات</div>
        <p style="margin: 0; padding: 5px;">{{ $booking->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p style="margin: 0;">شكراً لاختياركم خدماتنا</p>
        <p style="margin: 5px 0;">للاستفسارات يرجى التواصل على: {{ config('app.phone', '+218-XX-XXXXXXX') }}</p>

    </div>
</body>
</html>
