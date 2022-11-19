<x-app-layout>
    <div class="container mx-auto w-3/5 my-8 px-4 py-4">
        <div class="flex justify-end items-center mb-3">
            <h4 class="text-gray-400 text-sm">並び替え</h4>
            <ul class="flex">
                @foreach (App\Models\Post::SORT_LIST as $value => $name)
                    <li class="ml-4">
                        <a href="" class="hover:text-blue-500">
                            {{ $name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="flex justify-between">
            <div class="w-2/5">
                <h3 class="mb-3 text-gray-400 text-sm">検索条件</h3>
                <ul>
                    <li class="mb-2">
                        <a href="/" class="hover:text-blue-500">
                            全て
                        </a>
                    </li>
                    @foreach ($genres as $o)
                        <li class="mb-2">
                            <a href="/?occupation_id={{ $o->id }}" class="hover:text-blue-500">
                                {{ $o->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="w-full">
             
                <div class="block mt-3">
                    {{-- {{ $posts->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
