<x-app-layout>
    <div class="py-10 mx-auto w-3/4">
        <div class="pl-10 [&>table]:border-2 [&>table]:border-gray-300 [&_th]:border-b-2 [&_th]:border-gray-300">
            {!! $calender->render() !!}
        </div>
    </div>
</x-app-layout>
