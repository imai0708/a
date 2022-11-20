<x-app-layout>
    <div class="container mx-auto w-3/5 my-8 px-4 py-4">
        @if (isset($requests))
            <hr>
            <h2 class="flex justify-center font-bold text-lg my-4">エントリー一覧</h2>
            <div class="">
                <form method="post">
                    @csrf
                    @method('PATCH')
                    <table class="min-w-full table-fixed text-center">
                        <thead>
                            <tr class="text-gray-700 ">
                                <th class="w-1/5 px-4 py-2">氏名</th>
                                <th class="w-1/5 px-4 py-2">依頼日</th>
                                <th class="w-1/5 px-4 py-2">ステータス</th>
                                <th class="w-2/5 px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $e)
                                <tr>
                                    <td>{{ $e->user->name }}</td>
                                    <td>{{ $e->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $e->status_value }}</td>
                                    <td>
                                        <div class="flex flex-col sm:flex-row items-center sm:justify-end text-center">
                                            @if (App\Models\Request::STATUS_ENTRY == $e->status)
                                                <input type="submit" value="承認"
                                                    formaction="{{ route('posts.requests.approval', $e->id) }}"
                                                    onclick="if(!confirm('承認しますか？')){return false};"
                                                    class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                                                <input type="submit" value="却下"
                                                    formaction="{{ route('posts.request.reject', $e) }}"
                                                    onclick="if(!confirm('却下しますか？')){return false};"
                                                    class="bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 ml-2">
                                            @elseif (App\Models\Request::STATUS_APPROVAL == $e->status)
                                                @if (Route::has('requests.messages.index'))
                                                    <a href="{{ route('entries.messages.index', $e) }}"
                                                        class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">メッセージ</a>
                                                @endif
                                                <input type="submit" value="承認済み"
                                                    formaction="{{ route('posts.request.reject', $e->id) }}"
                                                    onclick="if(!confirm('承認を取り消しますか？')){return false};"
                                                    class="bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                                            @else
                                                <input type="submit" value="再承認"
                                                    formaction="{{ route('posts.requests.approval', $e) }}"
                                                    onclick="if(!confirm('再承認しますか？')){return false};"
                                                    class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        @endif
        <div>

            <div class="block mt-3">
                {{-- {{ $posts->links() }} --}}
            </div>
        </div>
    </div>
</x-app-layout>
