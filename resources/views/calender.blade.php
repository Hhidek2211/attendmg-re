<x-app-layout>
    <div class="flex w-2/3 py-10 mx-auto">
        <div class="mx-auto w-full" id="calender">
            <div class="text-lg text-gray-700">
            {{ $calender->gettitle() }}
            </div>
            <div class="[&>table]:border-2 [&>table]:border-gray-300 [&_th]:border-b-2 [&_th]:border-gray-300">
            {!! $calender->render() !!}
            </div>
        </div>
        <div id="attend&setting" class="mx-auto w-full grid-cols-1">
            <div class="text-center w-full">
                <p class="text-lg text-gray-700">今日の出勤記録</p>
                <div class="[$>table]:border-2 [&>table]:border-gray-300 [&_thead]:border-2 [&_thead]:border-gray-300 [&_th]:border [&_th]:border-gray-300 [&_td]:border">
                    {!! $today !!}
                </div>
            </div>
            <a href="/basicsetting">設定</a>
        </div>
</x-app-layout>
