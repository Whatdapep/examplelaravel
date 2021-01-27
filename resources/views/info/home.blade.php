<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
     Header
        </h2>
    </x-slot>
    {{-- Body --}}
    <main>
            <h1 class="text-center text-red-600">
                this is Body
            </h1>
            <ul class="list-disc">
                @foreach ($data_news as $key => $item)
                    <li>
                        <img src={{$item->nphoto}} class="w-40 h40 " />
                        {{ $item->Question }}
                    </li>
                @endforeach
            </ul>
    </main>

</x-app-layout>
