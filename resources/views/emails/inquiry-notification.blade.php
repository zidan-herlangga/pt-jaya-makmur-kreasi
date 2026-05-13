<x-mail::message>
# Pertanyaan Baru dari {{ $inquiry->sender_name }}

{{ $inquiry->sender_name }} mengirimkan pertanyaan melalui form kontak website.

<x-mail::panel>
**Nama:** {{ $inquiry->sender_name }}
**Email:** {{ $inquiry->sender_email }}
@if($inquiry->sender_phone)
**Telepon:** {{ $inquiry->sender_phone }}
@endif
@if($inquiry->company_name)
**Perusahaan:** {{ $inquiry->company_name }}
@endif
@if($inquiry->product)
**Produk:** {{ $inquiry->product->title }}
@endif
</x-mail::panel>

**Pesan:**

> {{ $inquiry->message }}

<x-mail::button :url="route('admin.inquiries.index')" color="success">
Lihat di Dashboard
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
