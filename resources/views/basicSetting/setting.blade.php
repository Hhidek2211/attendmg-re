<x-app-layout>
    <div class="pt-8 mx-auto w-1/4">
        <div class="pb-3 text-2xl mx-auto text-center">デフォルト設定</div>
        <form action="{{ route('bsSet.store') }}" method="POST">
        @csrf
            <table class="mx-auto">
                <thead class="text-center tb-1 border-b-2 border-gray-300">
                    <tr class="[&>th]:text-gray-500">
                        <th>曜日</th>
                        <th>開始時間</th>
                        <th>終了時間</th>
                        <th>休憩時間数</th>
                        <th>休日</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                @php $weekday = ['日', '月', '火', '水', '木', '金', '土'] @endphp
                @for($i=0; $i < 7; $i++)
                    <input type="hidden" name="weekofday[{{$i}}]" value="{{$i}}">
                    <tr class="[&>td]:px-1 [&>td]:py-1">
                        <td>{{ $weekday[$i] }}</td>
                        <td><input type="time" name="start[{{$i}}]" value="08:00"></td>
                        <td><input type="time" name="stop[{{$i}}]" value="17:00"></td>
                        <td><input type="time" name="break[{{$i}}]" value="01:00"></td>
                        <td>
                            <input type="hidden" name="isleave[{{$i}}]" value="0">
                            <input type="checkbox" name="isleave[{{$i}}]" value="1">
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
            <div class="flex justify-center pt-3"><input type="submit" value="適用"></div>
        </form>
    </div>
</x-app-layout>