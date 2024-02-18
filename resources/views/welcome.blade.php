<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div id="title" class="my-20 text-center">
            <div class="text-4xl text-bold">勤怠管理アプリ</div>
        </div>
        <div id="login" class="mx-auto w-11/12 md:w-1/2 flex flex-wrap justify-around space-y-2 md:space-y-0 text-center">
            <a class="w-full h-12 md:w-2/5 py-2 rounded-lg text-blue-500 text-xl bg-blue-200 border border-3 border-blue-500 font-bold" href="{{ route('login') }}">ログイン</a>
            <a class="w-full h-12 md:w-2/5 py-2 rounded-lg text-violet-500 text-xl bg-violet-200 border border-3 border-violet-500 font-bold" href="{{ route('register') }}">新規登録</a>
        </div>

        <div class="mx-auto text-center pt-10">
            <p>テスト用アカウント</p>
            <p>Email:test@test.com</p>
            <p>Pass:test1234</p>
    </body>
</html>
