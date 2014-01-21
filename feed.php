<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NO MUSIC NO LIFE</title>
<?php echo Asset::js('jquery.min.js'); ?>
<?php echo Asset::js('jquery.masonry.min.js'); ?>
<?php echo Asset::js('jquery.infinitescroll.min.js'); ?>
<?php echo Asset::js('feed.js'); ?>
<?php echo Asset::css('main.css'); ?>
<?php echo Asset::css('feed.css'); ?>
<?php echo html_tag('link',
 array(
  'rel' => 'icon',
  'type' => 'image/jpg',
  'href' => Asset::get_file('favicon.ico', 'img'),
 )
); ?>

<style>
	#textarea{opacity:0;}
</style>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic' rel='stylesheet' type='text/css'>
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
        <div id = "textarea" style="margin-top:8px">
        <?php
                foreach($feeds as $feed){
        ?>
                                <div class = "textinner">
                                        <div class = "player" style = "height:180px; overflow:hidden;">
                                                <img src = 'http://i.ytimg.com/vi/<?php echo $feed->video;?>/0.jpg' class = 'play_video' width = '320' style='margin-top:-30px'>
                                                <?php echo Asset::img('play2.png',array('class'=>'play_button','width'=>'90px','style'=>'opacity:0.4'));?>
                                        </div>
					<?php $flag = false;?>
					<?php foreach($feed->likes as $like): ?> 
						<?php if(!strcmp($like->user_id,$_SESSION['facebook']['auth']['uid'])):?>
							<?php $flag = true; break; ?>
						<?php endif;?>
					<?php endforeach; ?>
                                        <p><?php echo $feed->video_title;?></p>
                                        <span style="padding-left:10px;">
                                                        <?php if($flag){ ?>
								<?php echo Asset::img('likemini_2.png',array('align' => 'center','style' => 'margin:0 2px'));?>
								<?php echo "<span class='num'>".count($feed->likes)."</span>";?> 
							<?php }else{ ?>
								<?php echo Form::open(array('action' => 'like', 'class' => 'the-like','style'=>'display:inline;'), array('user_id' => $_SESSION['facebook']['auth']['uid'], 'music_id' => $feed->id));?>
								<?php echo Form::input('like','',array('type' => 'image','src' => Asset::find_file('likemini.png','img'), 'class' => 'form-like', 'align' => 'center','style'=>'margin:0 2px;')); 
								echo "<span class='num'>".count($feed->likes)."</span>";
								echo Form::close(); ?>
                                                        <?php } ?>
					</span>
					<span style = "float:right; font-size:18px;margin-right:10px;"><?php echo $feed->year." / ".$feed->month;?></span>
                                        <HR size="1" color="f2f2f2" style="margin-top:5px">
					<a href = "/user/<?php echo isset($feed->users->username) ? $feed->users->username : $feed->users->id ; ?>/" style="text-decoration: none;">
					<div class="row">
                                        	<div class="col" style="float:left;margin-left:15px;">
                                                	<img src = "https://graph.facebook.com/<?php echo $feed->users->id; ?>/picture?width=50&height=50" align="top">
                                        	</div>
                                        	<div class="col" style="min-height:50px;">
                                                	<span style="font-size:13px; font-weight:bold;"><?php echo $feed->users->name;?></span>
							<div><?php echo $feed->comment;?></div>
                                        	</div>
					</div>
                                        </a>
					<HR size="1" color="f2f2f2">
					<div class="comments">
					<?php foreach($feed->comments as $comment):?>
						<a href = "/user/<?php echo isset($comment->users->username) ? $comment->users->username : $comment->users->id; ?>/" style="text-decoration: none;">
                                                	<div class="row">
                                                        	<div class="col" style="float:left; margin-left:15px;">
                                                                	<img src="https://graph.facebook.com/<?php echo $comment->user_id;?>/picture" align="top">
                                                        	</div>
                                                        	<div class="col" style="min-height:50px;">
                                                                	<span style="font-size:13px; font-weight:bold;"><?php echo $comment->users->name;?></span>
									<div><?php echo $comment->comment;?></div>
                                                        	</div>
                                                	</div>
						</a>
						<HR size="1" color="f2f2f2">
					<?php endforeach; ?>
					</div>
					<div class="row">
						<div class="col" style="margin-left:15px">
							<?php echo Form::open(array('action' => 'music', 'class' => 'the-form'), array('user_id' => $_SESSION['facebook']['auth']['uid'], 'music_id' => $feed->id));
							echo Form::textarea('comment','',array('placeholder' => 'コメントする...','rows' => 2, 'class' => 'form-comment')); 
							echo Form::close();
							?>
						</div>
					</div>
                		</div>
        <?php
                }
        ?>
        </div>
        <nav id="page-nav">
                <?php echo Pagination::instance('mypagination')->next();?>
        </nav>
</div>
<div id = "footer">
        &copy; JEJEJE. All Rights Reserved.
</div>
</body>
</html>
