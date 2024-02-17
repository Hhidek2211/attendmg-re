<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            ログアウト
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            アカウントからログアウトします
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-6 space-y-6">
        @csrf

        <div class="flex items-center gap-4">
            <x-primary-button>ログアウト</x-primary-button>
        </div>
    </form>
</section>