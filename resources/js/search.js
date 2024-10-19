$(document).ready(function() {
    // CSRFトークンを含める設定
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 検索フォームの送信イベントをAjaxで処理
    $('#search-form').on('submit', function(e) {
        e.preventDefault(); // ページのリロードを防ぐ

        // デバッグ用ログ
        console.log('検索リクエストを送信中...');

        $.ajax({
            url: $(this).attr('action'),  // フォームのアクションURLを取得
            method: "GET",  // GETメソッドで検索データを送信
            data: {
                keyword: $('#keyword').val(),  // 検索キーワードを送信
                company_id: $('#company_id').val()  // メーカーIDを送信
            },
            success: function(response) {
                // 検索結果エリアを更新する
                console.log('検索リクエスト成功:', response);
                $('#search-results').html(response);
            },
            error: function(xhr) {
                // エラーが発生した場合の処理
                console.error('検索リクエスト失敗:', xhr);
                alert('検索に失敗しました。');
            }
        });
    });
});
