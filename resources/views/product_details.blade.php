@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('商品情報詳細画面') }}</div>

                <div class="card-body">
                    @csrf                       
                    <div class="row mb-3">
                        <label for="product-id" class="col-md-4 col-form-label text-md-right mb-0">{{ __('ID') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="product-id" value="{{ $product->id }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="product-image" class="col-md-4 col-form-label text-md-right mb-0">{{ __('商品画像') }}</label>
                        <div class="col-md-6">
                            <img src="{{ asset('product_docs/' . $product->img_path) }}" alt="商品画像" class="product-image">
                        </div>
                    </div>                        

                    <div class="row mb-3">
                        <label for="product-name" class="col-md-4 col-form-label text-md-right mb-0">{{ __('商品名') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="product-name" value="{{ $product->product_name }}" disabled>
                        </div>
                    </div> 

                    <div class="row mb-3">
                        <label for="company-name" class="col-md-4 col-form-label text-md-right mb-0">{{ __('メーカー名') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="company-name" value="{{ $product->company_name }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="product-price" class="col-md-4 col-form-label text-md-right mb-0">{{ __('価格') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="product-price" value="¥{{ number_format($product->price) }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="product-stock" class="col-md-4 col-form-label text-md-right mb-0">{{ __('在庫数') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="product-stock" value="{{ $product->stock }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="product-comment" class="col-md-4 col-form-label text-md-right mb-0">{{ __('コメント') }}</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="product-comment" disabled>{{ $product->comment }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a class="btn btn-primary button_margin button_orenge" href="{{ route('product_edit', ['id' => $product->id]) }}">
                                {{ __('編集') }}
                            </a>
                            <a class="btn btn-primary" href="{{ route('product_list')}}">
                                {{ __('戻る') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
