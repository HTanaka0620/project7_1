@if($products->isEmpty())
    <p>検索結果が見つかりませんでした。</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td><img src="{{ asset('product_docs/' . $item->img_path) }}" alt="商品画像" class="img-thumbnail product-image"></td>
                <td>{{ $item->product_name }}</td>
                <td>¥{{ number_format($item->price) }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ $item->company_name }}</td>
                <td>
                    <!-- 詳細ボタン -->
                    <a class="btn btn-details" href="{{ route('product_details', ['id' => $item->id]) }}">
                        {{ __('詳細') }}
                    </a>
                    
                    <!-- 削除フォーム -->
                    <form action="{{ route('product_destroy', ['id' => $item->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">
                            {{ __('削除') }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- 新規登録ボタン -->
    <a class="btn btn-primary mt-3" href="{{ route('show_Registration') }}">
        {{ __('新規登録') }}
    </a>
@endif
