const mix = require('laravel-mix');  // Laravel Mixを読み込む

// search.jsをビルドして、public/js/search.jsに出力する設定
mix.js('resources/js/search.js', 'public/js');
