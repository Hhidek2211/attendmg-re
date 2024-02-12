<x-app-layout>
    <div class="py-10 mx-auto w-3/4">
        <div class="text-lg text-gray-700">
            {{ $calender->gettitle() }}
        </div>
        <div class="[&>table]:border-2 [&>table]:border-gray-300 [&_th]:border-b-2 [&_th]:border-gray-300">
            {!! $calender->render() !!}
        </div>
    </div>
</x-app-layout>
