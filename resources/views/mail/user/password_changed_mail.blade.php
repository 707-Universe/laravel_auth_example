<x-mail::message>
# パスワードが変更されました

<x-mail::button :url="''">
身に覚えが無い場合
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
