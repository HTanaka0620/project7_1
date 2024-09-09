@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('商品情報編集画面') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('product_update', ['id' => $product->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="product-id" class="col-md-4 col-form-label text-md-right mb-0">{{ __('ID') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="product-id" value="{{ $product->id }}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="product-name" class="col-md-4 col-form-label text-md-right mb-0">{{ __('商品名') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="product-name" type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{ $product->product_name }}" required>
                                @error('product_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="company-id" class="col-md-4 col-form-label text-md-right mb-0">{{ __('メーカー') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select class="form-control" name="company_id" required>
                                    <option value="{{ $product->company_id }}" hidden>{{ $product->company_name }}</option>
                                    @foreach($companies as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="price" class="col-md-4 col-form-label text-md-right mb-0">{{ __('価格') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $product->price }}" required>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="stock" class="col-md-4 col-form-label text-md-right mb-0">{{ __('在庫数') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ $product->stock }}" required>
                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="comment" class="col-md-4 col-form-label text-md-right mb-0">{{ __('コメント') }}</label>
                            <div class="col-md-6">
                                <input id="comment" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" value="{{ $product->comment }}">
                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="img_path" class="col-md-4 col-form-label text-md-right mb-0">{{ __('商品画像') }}</label>
                            <div class="col-md-6">
                                <input id="img_path" type="file" class="form-control @error('img_path') is-invalid @enderror" name="img_path">
                                @error('img_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if($product->img_path)
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-right mb-0">{{ __('現在の画像') }}</label>
                                <div class="col-md-6">
                                    <img src="{{ asset('product_docs/' . $product->img_path) }}" alt="画像なし" class="product-image">
                                </div>
                            </div>
                        @endif
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary button_margin button_orenge">
                                    {{ __('更新') }}
                                </button>
                                <a class="btn-details btn-new btn btn-primary" href="{{ route('product_details', ['id' => $product->id]) }}">
                                    {{ __('戻る') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
