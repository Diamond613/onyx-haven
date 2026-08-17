<x-mail::message>
# New Message from Your Website

**From:** {{ $contactMessage->name }} ({{ $contactMessage->email }})

**Subject:** {{ $contactMessage->subject }}

---

{{ $contactMessage->message }}

---

<x-mail::button :url="url('/admin/messages')">
View & Reply in Dashboard
</x-mail::button>

You can also just hit **Reply** on this email — it will go directly to {{ $contactMessage->name }}.

Thanks,<br>
Onyx Haven Website
</x-mail::message>