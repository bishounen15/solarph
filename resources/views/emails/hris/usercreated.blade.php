@component('mail::message')
# Your account has been created. 

Welcome {{$data['first_name']}}!

You now have access to Solar Philippines' Web Portal.

Please login using the creadentials below:

User ID : {{$data['email_work']}}
Password: {{$data['password']}}

@component('mail::button', ['url' => 'http://192.168.128.9:8000/login'])
Click Here to Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
