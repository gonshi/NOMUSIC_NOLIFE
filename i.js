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
                        // HTML�ł̑��M���L�����Z��
                        event.preventDefault();
                        // ����Ώۂ̃t�H�[���v�f���擾
                        var $form = $(this);
                        // ���M�{�^�����擾
                        // �i��Ŏg��: ��d���M��h�~����B�j
                        //var $button = $form.find('button');

                        // ���M
                        $.ajax({
                                url: $form.attr('action'),
                                type: $form.attr('method'),
                                data: $form.serialize(),
                                timeout: 10000,  // �P�ʂ̓~���b

                        // ���M�O
                                beforeSend: function(xhr, settings) {
                                // �{�^���𖳌������A��d���M��h�~
                                //$button.attr('disabled', true);
                                },
                                // ������
                                complete: function(xhr, textStatus) {
                                // �{�^����L�������A�đ��M������
                                //$button.attr('disabled', false);
                        },

                        // �ʐM�������̏���
                        success: function(result, textStatus, xhr) {
                                var $img = $("<div class='col' style='float:left; margin-left:15px;'>").append("<img src= 'https://graph.facebook.com/<?php echo $_SESSION['facebook']['auth']['uid']; ?>/picture' aligin='top'>");
                                var $name = $("<span style='font-size:13px; font-weight:bold;'>").append("<?php echo $_SESSION['facebook']['auth']['info']['name'];?>");
                                var $com = $("<div>").append($form.serializeArray()[2]['value']);
                                var $namecom = $("<div class='col' style='min-height:50px;'>").append($name).append($com);
                                var $new_row = $("<div class='row'>").append($img).append($namecom);
                                var $new_href = $("<a href = '/user/<?php echo isset($_SESSION['facebook']['auth']['raw']['username']) ? $_SESSION['facebook']['auth']['raw']['username'] : $_SESSION['facebook']['auth']['uid']; ?>/' style='text-decoration: none;'>").append($new_row);
                                $form.parents(".item").find(".comments").append($new_href).append("<HR size='1' color='f2f2f2'>");
                                $("#jan,#feb,#mar,#apr,#may,#jun,#jul,#aug,#sep,#oct,#nov,#dec").masonry("reload");
                                // ���͒l��������
                                $form[0].reset();
                        },

                        // �ʐM���s���̏���
                        error: function(xhr, textStatus, error) {}
                        });
                });

                $(document).on("submit",".the-like",function(event) {
                        // HTML�ł̑��M���L�����Z��
                        event.preventDefault();
                        // ����Ώۂ̃t�H�[���v�f���擾
                        var $form = $(this);
                        //���ł�like��������Ă�����
                        // ���M�{�^�����擾
                        // �i��Ŏg��: ��d���M��h�~����B�j
                        //var $button = $form.find('button');

                        // ���M
                        $.ajax({
                                url: $form.attr('action'),
                                type: $form.attr('method'),
                                data: $form.serialize(),
                                timeout: 10000,  // �P�ʂ̓~���b

                        // ���M�O
                                beforeSend: function(xhr, settings) {
                                // �{�^���𖳌������A��d���M��h�~
                                //$button.attr('disabled', true);
                                },
                                // ������
                                complete: function(xhr, textStatus) {
                                // �{�^����L�������A�đ��M������
                                //$button.attr('disabled', false);
                        },

                        // �ʐM�������̏���
                        success: function(result, textStatus, xhr) {
                                $form.find(".form-like").replaceWith("<img src='/assets/img/likemini_2.png' style='margin:0 2px' align=center>");
                                var num_plus = Number($form.find('.num').html())+1;
                                $form.find(".num").replaceWith(String(num_plus));
                        },

                        // �ʐM���s���̏���
                        error: function(xhr, textStatus, error) {}
                        });
                });

        $(document).on("keypress", ".form-comment", function(e) {
                if (e.keyCode == 13) { // Enter�������ꂽ
                        if (e.shiftKey) { // Shift�L�[�������ꂽ
�@�@�@�@                        $.noop();
                        } else if ($(this).val().replace(/\s/g, "").length > 0) {
                                e.preventDefault();
                                $(this).parent("form").submit();
                        }
                } else {
                        $.noop();
                }
        });
}