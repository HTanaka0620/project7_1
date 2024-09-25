$(document).ready(function() {
    // フォームの送信をAjaxで処理
    $('#search-form').on('submit', function(e) {
        e.preventDefault(); // ページのリロードを防ぐ

        $.ajax({
            url: "/product/search",  // Laravelのルートに送信
            method: "GET",  // GETメソッドで検索データを送信
            data: {
                keyword: $('#keyword').val(),  // キーワードを送信
                company_id: $('#company_id').val()  // メーカーIDを送信
            },
            success: function(response) {
                // 検索結果を表示エリアにセットする
                $('#search-results').html(response);
            },
            error: function(xhr) {
                // エラーメッセージを表示
                alert('検索に失敗しました');
            }
        });
    });
});
