<x-mail::message>
Hi {{ $contactMessage->name }},

{{ $replyText }}

---

*Your original message:*

{{ $contactMessage->message }}

Best regards,<br>
Onyx Haven Team

---

<small>If future replies from us end up in your spam or junk folder, marking this email as "Not Spam" will help make sure you don't miss anything.</small>
</x-mail::message>