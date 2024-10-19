<table class="table">
    <thead>
        <tr>
            <th>
                <a href="#" class="sortable" data-column="id" data-order="{{ $sort_by == 'id' && $sort_order == 'asc' ? 'desc' : 'asc' }}">ID</a>
            </th>
            <th>商品画像</th>
            <th>
                <a href="#" class="sortable" data-column="product_name" data-order="{{ $sort_by == 'product_name' && $sort_order == 'asc' ? 'desc' : 'asc' }}">商品名</a>
            </th>
            <th>
                <a href="#" class="sortable" data-column="price" data-order="{{ $sort_by == 'price' && $sort_order == 'asc' ? 'desc' : 'asc' }}">価格</a>
            </th>
            <th>
                <a href="#" class="sortable" data-column="stock" data-order="{{ $sort_by == 'stock' && $sort_order == 'asc' ? 'desc' : 'asc' }}">在庫数</a>
            </th>
            <th>
                <a href="#" class="sortable" data-column="company_name" data-order="{{ $sort_by == 'company_name' && $sort_order == 'asc' ? 'desc' : 'asc' }}">メーカー名</a>
            </th>
            <th>
                <a class="btn btn-primary" href="{{ route('show_Registration') }}">
                    {{ __('新規登録') }}
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $item)
            <tr class="{{ $loop->odd ? 'even-row' : 'odd-row' }}" id="product-row-{{ $item->id }}">
                <td>{{ $item->id }}</td>
                <td><img src="{{ asset('product_docs/' . $item->img_path) }}" alt="商品画像" class="img-thumbnail product-image"></td>
                <td>{{ $item->product_name }}</td>
                <td>¥{{ number_format($item->price) }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ $item->company_name }}</td>
                <td>
                    <a class="btn btn-details" href="{{ route('product_details', ['id' => $item->id]) }}">
                        {{ __('詳細') }}
                    </a>
                    <button class="btn btn-delete" data-id="{{ $item->id }}">
                        {{ __('削除') }}
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
