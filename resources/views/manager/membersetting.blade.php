<x-app-layout>
    <div class ="text-2xl text-center mx-auto py-10">管理対象者設定</div>
    <form action="{{ route('mg.regester') }}" method="POST">
        @csrf
            <table class="mx-auto">
                <thead class="text-center tb-1 border-b-2 border-gray-300">
                    <tr class="[&>th]:text-gray-500">
                        <th>名前</th>
                        <th>管理対象</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                @php $i=0 @endphp
                @foreach($users as $user)
                    <input type="hidden" name="id[{{$i}}]" value="{{ $i }}">
                    <input type="hidden" name="user_id[{{$i}}]" value="{{ $user->id }}">
                    <tr class="[&>td]:px-1 [&>td]:py-1">
                        <td>{{ $user->name }}</td>
                        @if($user->manager_id == $manager->id)
                        <td>
                            <input type="hidden" name="member[{{$i}}]" value="0">
                            <input type="checkbox" name="member[{{$i}}]" value="1" checked>
                        </td>
                        @else
                        <td>
                            <input type="hidden" name="member[{{$i}}]" value="0">
                            <input type="checkbox" name="member[{{$i}}]" value="1">
                        </td>
                        @endif
                    </tr>
                    @php $i++ @endphp
                @endforeach
                </tbody>
            </table>
            <div class="flex justify-center pt-3"><input type="submit" value="適用"></div>
        </form>
</x-app-layout>