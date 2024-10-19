@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('商品画面一覧') }}</div>
                    <div class="card-body">
                        <!-- 検索フォーム -->
                        <form id="search-form" method="GET" action="{{ route('product.search') }}">
                            @csrf
                            <!-- 1段目: 検索キーワードとメーカー名 -->
                            <div class="form-row d-flex mb-3">
                                <div class="form-group flex-grow-1 mx-2">
                                    <input id="keyword" type="text" name="keyword" class="form-control" placeholder="検索キーワード" value="{{ request('keyword') }}">
                                </div>
                                <div class="form-group flex-grow-1 mx-2">
                                    <select id="company_id" name="company_id" class="form-control search cp_sl01">
                                        <option value="">メーカー名</option>
                                        @foreach($companies as $id => $name)
                                            <option value="{{ $id }}" {{ request('company_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        
                            <!-- 2段目: 価格の下限、上限、在庫数の下限、上限、検索ボタン -->
                            <div class="form-row d-flex mb-3">
                                <div class="form-group flex-grow-1 mx-2">
                                    <input type="number" name="price_min" class="form-control" placeholder="価格の下限" value="{{ request('price_min') }}">
                                </div>
                                <div class="form-group flex-grow-1 mx-2">
                                    <input type="number" name="price_max" class="form-control" placeholder="価格の上限" value="{{ request('price_max') }}">
                                </div>
                                <div class="form-group flex-grow-1 mx-2">
                                    <input type="number" name="stock_min" class="form-control" placeholder="在庫数の下限" value="{{ request('stock_min') }}">
                                </div>
                                <div class="form-group flex-grow-1 mx-2">
                                    <input type="number" name="stock_max" class="form-control" placeholder="在庫数の上限" value="{{ request('stock_max') }}">
                                </div>
                                <div class="form-group mx-2">
                                    <button type="submit" class="btn btn-search">{{ __('検索') }}</button>
                                </div>
                            </div>
                        
                            <!-- ソート条件を保持するためのhiddenフィールド -->
                            <input type="hidden" name="sort_by" value="{{ request('sort_by', 'id') }}">
                            <input type="hidden" name="sort_order" value="{{ request('sort_order', 'desc') }}">
                        </form>
                                                                        
                        <!-- 検索結果の表示部分 -->
                        <div class="mt-3" id="search-results">
                            @include('partials.product_table', ['products' => $products])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // JavaScript用の削除URLテンプレートを設定
        const deleteUrlTemplate = "{{ url('/product') }}/:id";
    </script>
    <script src="{{ asset('js/search.js') }}"></script>
@endpush
