$(document).ready(function() {
    // CSRFトークンを含める設定
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 検索フォームの非同期処理
    $('#search-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'GET',
            data: $(this).serialize(),
            success: function(response) {
                // 検索結果を更新
                $('#search-results').html(response);

                // イベントを再設定
                attachDeleteEvent();
                attachSortEvent();
            },
            error: function(xhr) {
                console.error('検索に失敗しました:', xhr);
                alert('検索に失敗しました');
            }
        });
    });

    // 削除ボタンのクリックイベントを監視
    function attachDeleteEvent() {
        $('.btn-delete').off('click').on('click', function() {
            var productId = $(this).data('id');  // 削除する商品のIDを取得
            var row = $('#product-row-' + productId);  // 削除する行を特定

            // 確認ダイアログを表示
            if (confirm('本当に削除しますか？')) {
                $.ajax({
                    url: deleteUrlTemplate.replace(':id', productId),
                    type: 'POST',
                    data: {
                        _method: 'DELETE'  // DELETEメソッドを使用するために追加
                    },
                    success: function(response) {
                        if (response.success) {
                            // 成功した場合、該当行を非表示にする
                            row.fadeOut(600, function() {
                                $(this).remove();  // 行を削除
                            });
                        } else {
                            alert('削除に失敗しました');
                        }
                    },
                    error: function(xhr) {
                        console.error('削除に失敗しました:', xhr);
                        alert('削除に失敗しました');
                    }
                });
            }
        });
    }

    // ソートリンクのクリックイベントを監視
    function attachSortEvent() {
        $('.sortable').off('click').on('click', function(e) {
            e.preventDefault();

            var column = $(this).data('column');
            var order = $(this).data('order');

            // ソート条件をhiddenフィールドに設定してフォームを再送信
            $('input[name="sort_by"]').val(column);
            $('input[name="sort_order"]').val(order);

            $('#search-form').submit();
        });
    }

    // 初期設定：イベントリスナーを設定
    attachDeleteEvent();
    attachSortEvent();
});
