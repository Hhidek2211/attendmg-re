<x-app-layout>
    <div class="gap-y-4 w-4/5 md:w-2/3 mx-auto">
        <div class ="text-2xl text-center mx-auto py-10">{{ $manager->name }}さんのチームの勤怠記録</div>
        <div id="memberdatas" class="mx-auto w-full">
            <table class="border border-2 mx-auto">
                <thead>
                    <tr>
                    <th class="px-1 py-1 w-24 text-center text-lg font-medium text-gray-500 border">名前</th>
                    <th class="px-1 py-1 w-48 text-center text-lg font-medium text-gray-500 border">打刻時間</th>
                    <th class="px-1 py-1 w-24 text-center text-lg font-medium text-gray-500 border">状態</th>
                    <th class="px-1 py-1 w-24 text-center text-lg font-medium text-gray-500 border">当月残業時間</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($memberdatas as $member)
                    <tr>
                    <td class="px-1 py-1 whitespace-nowrap text-base text-center font-medium text-black border"><a href="/manager/member/{{ $member['id'] }}">{{ $member['name'] }}</a></td>
                        @if($member['now_type'] != '退勤中') 
                        <td class="px-1 py-1 whitespace-nowrap text-base text-center font-medium text-black border">{{ $member['now_time'] }}</td>
                        <td class="px-1 py-1 whitespace-nowrap text-base text-center font-medium text-black border">{{ $member['now_type'] }}</td>
                        @else
                        <td colspan="2" class="px-1 py-1 whitespace-nowrap text-base text-center font-medium text-black border">{{ $member['now_type'] }}</td>
                        @endif
                    <td class="px-1 py-1 whitespace-nowrap text-base text-center font-medium text-black border">{{ $member['over_hour'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center text-gray-500">メンバーの名前をクリックすると詳細データを表示できます</div>
            
            <div class="container w-4/5 md:w-1/3 h-full mx-auto pt-8">
                <div class="relative border-3 border-gray-300 rounded-lg w-1/4 h-12 mx-3 mx-auto">
                    <a href="{{ route('mg.membersetting') }}" class="absolute top-0 left-0 w-full h-full cursor-pointer mx-auto"></a>
                    <div class="mx-auto text-center text-lg text-gray-700 pt-1.5 font-bold">メンバー設定</div>
                </div>
                <div class="relative w-full h-12 mx-3 mx-auto pt-4">
                    <a href="{{ route('dashboard') }}" class="absolute top-0 left-0 w-full h-full cursor-pointer mx-auto"></a>
                    <div class="mx-auto text-center text-lg text-gray-700 pt-1.5 font-bold">戻る</div>
                </div>
            </div>   
        </div>
    </div>
</x-app-layout>