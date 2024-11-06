@component('mail::message')
# طلب جديد لإضافة قاعة أفراح

**معلومات المالك:**  
الاسم: {{ $data['owner_name'] }}  
البريد الإلكتروني: {{ $data['email'] }}  
رقم الهاتف: {{ $data['phone'] }}  

**معلومات القاعة:**  
اسم القاعة: {{ $data['hall_name'] }}  
الموقع: {{ $data['location'] }}  
السعة: {{ $data['capacity'] }} شخص  

**الخدمات المتوفرة:**  
{{ $data['services'] }}

**الوصف التفصيلي:**  
{{ $data['description'] }}

شكراً،  
{{ config('app.name') }}
@endcomponent 