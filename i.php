<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NO MUSIC NO LIFE</title>
<?php echo Asset::css('main.css'); ?>
<?php echo Asset::css('i.css');?>
<?php echo Asset::css('colorbox.css'); ?>
<?php echo Asset::js('jquery.min.js'); ?>
<?php echo Asset::js('jquery.masonry.min.js'); ?>
<?php echo Asset::js('jquery.colorbox.js'); ?>
<?php echo Asset::js('i.js'); ?>
<?php echo html_tag('link',
 array(
  'rel' => 'icon',
  'type' => 'image/jpg',
  'href' => Asset::get_file('favicon.ico', 'img'),
 )
); ?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic' rel='stylesheet' type='text/css'>
<style>
        #contents{opacity:0;}
</style>
<script>
        $(document).ready(function(){
                <?php if(!strcmp($person,"me")){?>
                var month = <?php echo $month;?>;
                  $(".month").each(function(){
                    $(this).append("<a class='ajax' href='/ajax/index/<?php echo $year;?>/" + month + "' title='YouTubeで検索'><img src = '<?php echo Asset::get_file('search.png', 'img');?>'></a>").append("<a href = '/sync/index/<?php echo $year;?>/"+month+"' title='YouTube再生履歴から取得'><img src = '<?php echo Asset::get_file('load.png','img');?>'></a>");
                    month--;
                  });
                <?php } ?>
                //Examples of how to assign the Colorbox event to elements
                $(".ajax").colorbox({width:"80%", height:"90%",fixed:true});
                $('.ajax').colorbox({ onComplete:function(){ $('#frmSearch input:first').focus(); }});
        });
</script>
</head>
<body>
<div id="header">
        <div class = "header_menu" style="margin-left:10%; margin-top:0px">
                <img src = "<?php echo $_SESSION['facebook']['auth']['info']['image'];?>" height = "40px">
        </div>
	<div class = "header_menu" style="margin-top:7px; width:160px"><?php echo $_SESSION['facebook']['auth']['info']['name'];?></div>
	<div class = "header_menu">
		<a href="/"><?php echo Asset::img('home.png',array('width' => '30px'));?></a>
	</div>
	<div class = "header_menu">
		<a href="/i"><?php echo Asset::img('music.png',array('width' => '30px'));?></a>
	</div>
	<div class = "header_menu">
		<a href="/friends"><?php echo Asset::img('friends.png',array('width' => '30px'));?></a>
	</div>
	<div class = "header_logo">
		<?php echo Asset::img('no2.png');?>
	</div>
</div>
<div id="contents">
        <div id = "profile">
                <?php if(!strcmp($person,"me")){?>
                        <div style="float:left;">
                                <img src = "https://graph.facebook.com/<?php echo $_SESSION['facebook']['auth']['uid']; ?>/picture?width=180&height=180">
                        </div>
                        <div class = "col">
                                <p><?php echo $_SESSION['facebook']['auth']['info']['name']; ?></p>
                        </div>
                <?php }else{ ?>
                        <div style="float:left;">
                                <img src = "https://graph.facebook.com/<?php echo $user->id; ?>/picture?width=180&height=180">
                        </div>
                        <div class = "col">
                                <p><?php echo $user->name; ?></p>
                        </div>
                <?php } ?>
                        <div class = "col" style="margin-top:50px;">
                                <p style="font-size:18px">
                                        <?php if(!strcmp($person,"me")){?>
                                                <?php $url = "/i"; ?>
                                        <?php }else{?>
                                                <?php $url = strcmp($user->username,'') ? "/user/$user->username" : "/user/$user->id";?>
                                        <?php } ?>
                                        <?php for( $_y = $_year; $_y > 2006; $_y--):?>
                                                <?php if($_y == $year): ?>
                                                        <span style="font-size:27px">
                                                                <a href = "<?php echo $url.'/'.$_y; ?>" style="text-decoration:none;"><?php echo $_y; ?></a>
                                                        </span>
                                                <?php else: ?>
                                                        <a href = "<?php echo $url.'/'.$_y; ?>" style="text-decoration:none;"><?php echo $_y; ?></a>
                                                <?php endif; echo " / "; ?>
                                        <?php endfor; ?>
                                </p>
                        </div>
        </div>

        <?php if(!strcmp($person,"me")){?>
                <?php for($i = $month; $i > 0; $i--){?>
                        <?php $_month = convert_month($i);?>
                        <div class="month">
                                <span class = "month_name"><?php echo Asset::img($_month.'.png');?></span>
                        </div>
                        <div id="<?php echo $_month;?>"></div>
                <?php }?>
        <?php }else{?>
                <?php for($i = $month; $i > 0; $i--){?>
                        <?php $_month = convert_month($i);?>
                        <div class="month">
                                <?php echo Asset::img($_month.'.png');?>
                        </div>
                        <div id="<?php echo $_month;?>"></div>
                <?php }?>
        <?php }?>

	<?php foreach($musics as $music):?>
	<?php $month = convert_month($music->month); ?>
	<script type="text/javascript">
	$(function(){
		var line = "<HR size='1' color='f2f2f2'>"; 
		var month = "<?php echo $month; ?>"
		var video = $("<div class = 'player' style = 'height:270px;overflow:hidden;'>").append("<img src = 'http://i.ytimg.com/vi/<?php echo $music->video;?>/0.jpg' class = 'play_video' width = '480' style='margin-top:-45px'>").append("<img src='/assets/img/play2.png' class='play_button' width='120px' style='opacity:0.4'>"); 	
		//var like = $("<div style = 'text-align:right; padding-right:20px;'>").append("<img src = '/assets/img/likemini_2.png' align = 'center' style = 'margin:0 2px; cursor:auto;'>").append("<span class = 'num'><?php echo count($music->likes); ?></span>");
		var my_comment = $("<div class = 'row'>").append("<div class = 'col' style = 'min-height:50px; margin-left:15px;'><?php echo str_replace("\r\n",'',nl2br($music->comment)); ?></div>");
		var comments = $("<div class = 'comments'></div>");
		
		//create the form-------------------------
		var form = $("<form action='/music' class='the-form' accept-charset='utf-8' method='post'></form>");
		form.append("<input name='user_id' value='<?php echo $_SESSION['facebook']['auth']['uid'];?>' type='hidden' id='form_user_id'>").append("<input name='music_id' value='<?php echo $music->id;?>' type='hidden' id='form_music_id'>").append("<textarea placeholder='コメントする...' rows='2' class='form-comment' name='comment' id='form_comment'></textarea>");
		var col = $("<div class = 'col' style = 'margin-left:15px'></div>"); 
		col.append(form);
		var textarea = $("<div class = 'row'></div>");
		textarea.append(col);
		//---------------------------------------
		//create like ---------------------------
                <?php $flag = false;?>
                <?php foreach($music->likes as $like): ?>
                        <?php if(!strcmp($like->user_id,$_SESSION['facebook']['auth']['uid'])):?>
                                <?php $flag = true; break; ?>
                        <?php endif;?>
                <?php endforeach; ?>

		<?php if($flag){ ?>
			var like = $("<div style = 'text-align:right; padding-right:20px;'>").append("<img src = '/assets/img/likemini_2.png' align = 'center' style = 'margin:0 2px; cursor:auto;'>").append("<span class = 'num'><?php echo count($music->likes); ?></span>");
                <?php }else{ ?>
			var like = $("<div style = 'text-align:right; padding-right:20px;'></div>");
			var like_form = $("<form action='/like' class='the-like' style='display:inline;' accept-charset='utf-8' method='post'></form>");
			like_form.append("<input name='user_id' value='<?php echo $_SESSION['facebook']['auth']['uid'];?>' type='hidden' id='form_user_id'>").append("<input name='music_id' value='<?php echo $music->id;?>' type='hidden' id='form_music_id'>").append("<input type='image' src='/assets/img/likemini.png' class='form-like' align='center' style='margin:0 2px;' name='like' value='' id='form_like'>").append("<span class = 'num'><?php echo count($music->likes);?></span>");
			like.append(like_form);
                <?php } ?>
		//--------------------------------------	
		
		<?php foreach($music->comments as $comment): ?>
			var href = $("<a href = '/user/<?php echo strcmp($comment->users->username,'') ? $comment->users->username : $comment->users->id; ?>/' style = 'text-decoration:none;'>");
			var img = $("<div class = 'col' style = 'float:left; margin-left:15px;'>").append("<img src = 'https://graph.facebook.com/<?php echo $comment->user_id;?>/picture' align='top'>");
			var text = $("<div class='col' style='min-height:50px;'>").append("<span style='font-size:13px; font-weight:bold;'><?php echo $comment->users->name; ?></span>").append("<div><?php echo str_replace("\r\n",'',nl2br($comment->comment)); ?></div>");
			var row = $("<div class = 'row'>").append(img).append(text);
			var new_row = href.append(row);
			comments.append(new_row).append(line);
		<?php endforeach;?>
		<?php if(strcmp($music->comment,'')){?>
			var item = $("<div class = 'item'>").append(video).append("<p><?php echo $music->video_title;?></p>").append(like).append(line).append(my_comment).append(line).append(comments).append(line).append(textarea);	
		<?php }else{ ?>
			var item = $("<div class = 'item'>").append(video).append("<p><?php echo $music->video_title;?></p>").append(like).append(line).append(comments).append(line).append(textarea);
		<?php } ?>
			
		$("#"+month).append(item);
		//console.log(item);
	});
	</script>
	<?php endforeach; ?>
	<script>
	$(function(){
		$("#jan,#feb,#mar,#apr,#may,#jun,#jul,#aug,#sep,#oct,#nov,#dec").masonry('reload');
		play();
	});
	</script>

</div>
<div id = "footer">
	&copy; JEJEJE. All Rights Reserved.
</div>
</body>
</html>

<?php
function convert_month($arg)
{
	switch($arg){
	case 1:
	  $month = "jan";
	  break;
	case 2:
	  $month = "feb";
	  break;
	case 3:
	  $month = "mar";
	  break;
	case 4:
	  $month = "apr";
	  break;
	case 5:
	  $month = "may";
	  break;
	case 6:
	  $month = "jun";
	  break;
	case 7:
	  $month = "jul";
	  break;
	case 8:
	  $month = "aug";
	  break;
	case 9:
	  $month = "sep";
	  break;
	case 10:
	  $month = "oct";
	  break;
	case 11:
	  $month = "nov";
	  break;
	case 12:
	  $month = "dec";
	  break;
	default:
	  $month = "error";
	  break;
	}
	return $month;
}
?>
