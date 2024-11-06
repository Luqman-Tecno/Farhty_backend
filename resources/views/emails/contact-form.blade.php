@component('mail::message')
# رسالة جديدة من نموذج الاتصال

**الاسم:** {{ $data['name'] }}  
**البريد الإلكتروني:** {{ $data['email'] }}  
**رقم الهاتف:** {{ $data['phone'] }}  
**تاريخ الزفاف:** {{ $data['wedding_date'] }}  

**الرسالة:**  
{{ $data['message'] }}

شكراً،  
{{ config('app.name') }}
@endcomponent 