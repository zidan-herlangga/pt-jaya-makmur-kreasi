<x-mail::message>
# {{ $post->title }}

{{ $post->excerpt ? strip_tags($post->excerpt) : 'Baca artikel terbaru dari kami.' }}

<x-mail::button :url="route('posts.show', $post)" color="success">
Baca Selengkapnya
</x-mail::button>

Terima kasih telah berlangganan,<br>
{{ config('app.name') }}

<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 24px 0;">

<small style="color: #6b7280;">
    Jika Anda tidak ingin menerima email ini lagi,
    <a href="{{ route('newsletter.unsubscribe', $subscriber->token) }}" style="color: #16a34a; text-decoration: underline;">
        klik di sini untuk berhenti berlangganan
    </a>.
</small>
</x-mail::message>
