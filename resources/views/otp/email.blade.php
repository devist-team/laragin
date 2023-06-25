<x-mail::message>
# Hello!
As a security measure, we require you to enter a one-time password (OTP) to access your account. Your OTP is:
<x-mail::panel>
**{{$otp}}**
</x-mail::panel>
Please enter this code on the login page to gain access to your account. Please note that this code is only valid
for a limited time and can only be used once.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
