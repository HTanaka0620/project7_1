@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('商品新規登録画面') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('Registration') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mb-3">
                            <label for="product_name" class="col-md-4 col-form-label text-md-right">{{ __('商品名') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="product_name" type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" placeholder="商品名" required>
                                @error('product_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="company_id" class="col-md-4 col-form-label text-md-right">{{ __('メーカー名') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select class="form-control @error('company_id') is-invalid @enderror" name="company_id" required>
                                    <option value="" hidden>メーカー名</option>
                                    @foreach($companies as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('価格') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" placeholder="価格" required>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="stock" class="col-md-4 col-form-label text-md-right">{{ __('在庫数') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" placeholder="在庫数" required>
                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('コメント') }}</label>
                            <div class="col-md-6">
                                <input id="comment" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" placeholder="コメント">
                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="img_path" class="col-md-4 col-form-label text-md-right">{{ __('商品画像') }}</label>
                            <div class="col-md-6">
                                <input id="img_path" type="file" class="form-control @error('img_path') is-invalid @enderror" name="img_path">
                                @error('img_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary button_margin button_orenge">
                                    {{ __('新規登録') }}
                                </button>
                                <a class="btn btn-primary button_margin" href="{{ route('product_list') }}">
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
