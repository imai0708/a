<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">
        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">{{ $post->title }}
            </h2>
            <h3>{{ $post->advisor->user->name }}</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span
                    class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $post->created_at ? 'NEW' : '' }}</span>
                {{ $post->created_at }}
            </p>

            <h3>{{ $post->item->name }}</h3>


            <h3>{{ $post->situation->name }}</h3>



            <h3>{{ $post->genres->pluck('name')->join(' ') }}</h3>




            <img src="{{ Storage::url('images/posts/' . $post->image) }}" alt="" class="mb-4">
            <p class="text-gray-700 text-base">{!! nl2br(e($post->description)) !!}</p>
        </article>
        <div class="flex flex-row text-center my-4">

            @can('user')
                @if (empty($entry))
                    <form action="{{ route('posts.entries.store', $post) }}" method="post">
                        @csrf
                        <input type="submit" value="依頼" onclick="if(!confirm('依頼しますか？')){return false};"
                            class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                    </form>
                @else
                    @if (App\Models\Request::STATUS_APPROVAL == $entry->status)
                        @if (Route::has('entries.messages.index'))
                            <a href="{{ route('entries.messages.index', $entry) }}"
                                class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">メッセージ</a>
                        @endif
                    @endif
                    <form action="{{ route('posts.entries.destroy', [$post, $entry]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="依頼取消" onclick="if(!confirm('依頼をを取り消しますか？')){return false};"
                            class="bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                    </form>
                @endif
            @endcan
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}"
                    class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">編集</a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="post" class="w-full sm:w-32">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                </form>
            @endcan
        </div>
    </div>
</x-app-layout>
