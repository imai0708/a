<form method="GET" action="{{ route('posts.index') }}">
    <input type="search" placeholder="ジャンルを入力" name="genres" value="@if (isset($search)) {{ $search }} @endif">
    <div>
        <button type="submit">検索</button>
        <button>
            <a href="{{ route('posts.index') }}" class="text-white">
                クリア
            </a>
        </button>
    </div>
</form>

{{-- @foreach($users as $user)
    <a href="{{ route('posts.show', ['user_id' => $user->id]) }}">
        {{ $user->name }}
    </a>
@endforeach --}}


<div>
{{-- 　// 下記のようにページネーターを記述するとページネートで次ページに遷移しても、検索結果を保持する
    {{ $institutions->appends(request()->input())->links() }} --}}
</div>
