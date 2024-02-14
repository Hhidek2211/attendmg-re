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
            <div class="text-center w-full h-1/2">
                <p class="text-lg text-gray-700">今日の出勤記録</p>
                <div class="[$>table]:border-2 [&>table]:border-gray-300 [&_thead]:border-2 [&_thead]:border-gray-300 [&_th]:border [&_th]:border-gray-300 [&_td]:border">
                    {!! $today !!}
                </div>
            </div>
            <div id="attendbutton" class="text-center w-full h-1/3">
                <div class="h-48 [&>div]:border-3 [&>div]:rounded-lg [&>div]:border-gray-300">
                    {!! $attend->render() !!}
                </div>
            </div>
            <div class="flex container w-3/4 h-1/6 mx-auto">
                <div class="relative border-3 border-gray-300 rounded-lg w-full h-1/3 mx-3">
                    <a href="{{ route('bsSet.show') }}" class="absolute top-0 left-0 w-full h-full cursor-pointer mx-auto"></a>
                    <div class="mx-auto text-center text-lg text-gray-700 pt-1.5 font-bold">デフォルト設定</div>
                </div>
                <div class="relative border-3 border-gray-300 rounded-lg w-full h-1/3 mx-3">
                    <a href="{{ route('profile.edit') }}" class="absolute top-0 left-0 w-full h-full cursor-pointer mx-auto"></a>
                    <div class="mx-auto text-center text-lg text-gray-700 pt-1.5 font-bold">アカウント設定</div>
                </div>
            </div>
        </div>
</x-app-layout>
