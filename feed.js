$(window).load(function () {
    $container = $("#textarea");
    $.when($container.masonry({
        itemSelector: ".textinner",
        isFitWidth: true,
        isAnimated: false,
        isResizable: true
    })).then(function () {
        $(this).fadeTo("normal", 1);
    });

    $container.infinitescroll({
            navSelector: '#page-nav', // ナビゲーション
            nextSelector: '#page-nav a', // 次ページへのリンク
            itemSelector: '.textinner', // 次ページ内で探す要素
            loading: {
                finishedMsg: 'もう無いよ',
                img: '/assets/img/ajax-loader.gif' //ローディング画像
            }
        },
        // コールバック
        function (newElements) {
            var $newElems = $(newElements);
            // ボックスを配列させる前に画像をロードしとく
            $newElems.imagesLoaded(function () {
                $container.masonry('appended', $newElems, true);
            });
        });
});

$(document).on("mouseover", ".player", function () {
    $(this).find(".play_button").attr("src", "./assets/img/play.png");
});

$(document).on("mouseout", ".player", function () {
    $(this).find(".play_button").attr("src", "./assets/img/play2.png");
});

$(document).on("click", ".player", function () {
    var url = $(this).find(".play_video").attr("src");
    var params = url.split("/");
    $(this).replaceWith("<iframe width='320' height='180' src='http://www.youtube.com/embed/" + params[4] + "?rel=0&autoplay=1&wmode=transparent' style='z-index:2'frameborder='0' allowfullscreen wmode='Opaque'></iframe>");
});

$(document).on("submit", ".the-form", function (event) {
    // HTMLでの送信をキャンセル
    event.preventDefault();
    // 操作対象のフォーム要素を取得
    var $form = $(this);
    // 送信ボタンを取得
    // （後で使う: 二重送信を防止する。）
    //var $button = $form.find('button');

    // 送信
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: $form.serialize(),
        timeout: 10000, // 単位はミリ秒

        // 送信前
        beforeSend: function (xhr, settings) {
            // ボタンを無効化し、二重送信を防止
            //$button.attr('disabled', true);
        },
        // 応答後
        complete: function (xhr, textStatus) {
            // ボタンを有効化し、再送信を許可
            //$button.attr('disabled', false);
        },

        // 通信成功時の処理
        success: function (result, textStatus, xhr) {
            //$(this).parent(".comments").append("aa");	
            //$form.parents(".textinner").find(".comments").append("as");
            var $img = $("<div class='col' style='float:left; margin-left:15px;'>").append("<img src= 'https://graph.facebook.com/<?php echo $_SESSION['facebook']['auth']['uid']; ?>/picture' aligin='top'>");
            var $name = $("<span style='font-size:13px; font-weight:bold;'>").append("<?php echo $_SESSION['facebook']['auth']['info']['name'];?>");
            var $com = $("<div>").append($form.serializeArray()[2]['value']);
            var $namecom = $("<div class='col' style='min-height:50px;'>").append($name).append($com);
            var $new_row = $("<div class='row'>").append($img).append($namecom);
            var $new_href = $("<a href = '/user/<?php echo isset($_SESSION['facebook']['auth']['raw']['username']) ? $_SESSION['facebook']['auth']['raw']['username'] : $_SESSION['facebook']['auth']['uid']; ?>/' style='text-decoration: none;'>").append($new_row);
            $form.parents(".textinner").find(".comments").append($new_href).append("<HR size='1' color='f2f2f2'>");
            $("#textarea").masonry("reload");
            // 入力値を初期化
            $form[0].reset();
        },

        // 通信失敗時の処理
        error: function (xhr, textStatus, error) {}
    });
});


$(document).on("submit", ".the-like", function (event) {
    // HTMLでの送信をキャンセル
    event.preventDefault();
    // 操作対象のフォーム要素を取得
    var $form = $(this);
    //すでにlikeが押されていたら
    // 送信ボタンを取得
    // （後で使う: 二重送信を防止する。）
    //var $button = $form.find('button');

    // 送信
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: $form.serialize(),
        timeout: 10000, // 単位はミリ秒

        // 送信前
        beforeSend: function (xhr, settings) {
            // ボタンを無効化し、二重送信を防止
            //$button.attr('disabled', true);
        },
        // 応答後
        complete: function (xhr, textStatus) {
            // ボタンを有効化し、再送信を許可
            //$button.attr('disabled', false);
        },

        // 通信成功時の処理
        success: function (result, textStatus, xhr) {
            //$(this).parent(".comments").append("aa");
            //$form.parents(".textinner").find(".comments").append("as");
            $form.find(".form-like").replaceWith("<img src='<?php echo Asset::find_file('likemini_2.png','img');?>' style='margin:0 2px' align=center>");
            //$form.find(".num").replaceWith("01");
            var num_plus = Number($form.find('.num').html()) + 1;
            $form.find(".num").replaceWith(String(num_plus));
            //console.log($form.find(".num").val());
        },

        // 通信失敗時の処理
        error: function (xhr, textStatus, error) {}
    });
});

$(document).on("keypress", ".form-comment", function (e) {
    if (e.keyCode == 13) { // Enterが押された
        if (e.shiftKey) { // Shiftキーも押された
            　　　　
            $.noop();
        } else if ($(this).val().replace(/\s/g, "").length > 0) {
            e.preventDefault();
            $(this).parent("form").submit();
        }
    } else {
        $.noop();
    }
});