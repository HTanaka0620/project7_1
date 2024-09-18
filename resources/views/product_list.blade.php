@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('商品画面一覧') }}</div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('product_list') }}" class="d-flex align-items-center">
                            @csrf
                            <div class="form-group mx-2 flex-grow-1">
                                <input id="keyword" type="text" name="keyword" class="form-control" placeholder="検索キーワード">
                            </div>
                            <div class="form-group mx-2 flex-grow-1">
                                <select name="company_id" class="form-control search cp_sl01">
                                    <option value="" hidden>メーカー名</option>
                                    @foreach($companies as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mx-2">
                                <button type="submit" class="btn btn-search">
                                    {{ __('検索') }}
                                </button>
                            </div>
                        </form>
                        <div class="mt-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>商品画像</th>
                                        <th>商品名</th>
                                        <th>価格</th>
                                        <th>在庫数</th>
                                        <th>メーカー名</th>
                                        <th>
                                            <a class="btn btn-primary" href="{{ route('show_Registration') }}">
                                                {{ __('新規登録') }}
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $item)
                                    <tr class="{{ $loop->odd  ? 'even-row' : 'odd-row' }}">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
