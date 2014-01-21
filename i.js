$(function(){
	$('#dec, #nov, #oct, #sep, #aug, #jul, #jun, #may, #apr, #mar, #feb, #jan').imagesLoaded(function(){
                $.when($(this).masonry({
                        itemSelector : '.item',
                        isFitWidth: true,
                        isAnimated: false,
                        isResizable: true
                })).then(function(){
                        $("#contents").fadeTo("normal",1);
                });
        });
});


function play(){
        $(function(){
                $(".player").hover(
                        function(){
                                $(this).find(".play_button").attr("src", "/assets/img/play.png");
                        },
                        function(){
                                $(this).find(".play_button").attr("src", "/assets/img/play2.png");
                        }
                );
                $(".player").click(function(){
                        var url = $(this).find(".play_video").attr("src");
                        params    = url.split("/");
                        $(this).replaceWith("<iframe width='480' height='270' src='http://www.youtube.com/embed/"+params[4]+"?rel=0&autoplay=1&wmode=transparent' style='z-index:2'frameborder='0' allowfullscreen wmode='Opaque'></iframe>");
                });
        });

                $(document).on("submit",".the-form",function(event) {
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
                                timeout: 10000,  // 単位はミリ秒

                        // 送信前
                                beforeSend: function(xhr, settings) {
                                // ボタンを無効化し、二重送信を防止
                                //$button.attr('disabled', true);
                                },
                                // 応答後
                                complete: function(xhr, textStatus) {
                                // ボタンを有効化し、再送信を許可
                                //$button.attr('disabled', false);
                        },

                        // 通信成功時の処理
                        success: function(result, textStatus, xhr) {
                                var $img = $("<div class='col' style='float:left; margin-left:15px;'>").append("<img src= 'https://graph.facebook.com/<?php echo $_SESSION['facebook']['auth']['uid']; ?>/picture' aligin='top'>");
                                var $name = $("<span style='font-size:13px; font-weight:bold;'>").append("<?php echo $_SESSION['facebook']['auth']['info']['name'];?>");
                                var $com = $("<div>").append($form.serializeArray()[2]['value']);
                                var $namecom = $("<div class='col' style='min-height:50px;'>").append($name).append($com);
                                var $new_row = $("<div class='row'>").append($img).append($namecom);
                                var $new_href = $("<a href = '/user/<?php echo isset($_SESSION['facebook']['auth']['raw']['username']) ? $_SESSION['facebook']['auth']['raw']['username'] : $_SESSION['facebook']['auth']['uid']; ?>/' style='text-decoration: none;'>").append($new_row);
                                $form.parents(".item").find(".comments").append($new_href).append("<HR size='1' color='f2f2f2'>");
                                $("#jan,#feb,#mar,#apr,#may,#jun,#jul,#aug,#sep,#oct,#nov,#dec").masonry("reload");
                                // 入力値を初期化
                                $form[0].reset();
                        },

                        // 通信失敗時の処理
                        error: function(xhr, textStatus, error) {}
                        });
                });

                $(document).on("submit",".the-like",function(event) {
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
                                timeout: 10000,  // 単位はミリ秒

                        // 送信前
                                beforeSend: function(xhr, settings) {
                                // ボタンを無効化し、二重送信を防止
                                //$button.attr('disabled', true);
                                },
                                // 応答後
                                complete: function(xhr, textStatus) {
                                // ボタンを有効化し、再送信を許可
                                //$button.attr('disabled', false);
                        },

                        // 通信成功時の処理
                        success: function(result, textStatus, xhr) {
                                $form.find(".form-like").replaceWith("<img src='/assets/img/likemini_2.png' style='margin:0 2px' align=center>");
                                var num_plus = Number($form.find('.num').html())+1;
                                $form.find(".num").replaceWith(String(num_plus));
                        },

                        // 通信失敗時の処理
                        error: function(xhr, textStatus, error) {}
                        });
                });

        $(document).on("keypress", ".form-comment", function(e) {
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
}