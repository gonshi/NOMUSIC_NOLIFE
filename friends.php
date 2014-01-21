<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NO MUSIC NO LIFE</title>
<?php echo Asset::css('bootstrap.min.css');?>
<?php echo Asset::css('jumbotron-narrow.css');?>
<?php echo Asset::css('main.css'); ?>
<?php echo Asset::js('jquery.min.js'); ?>
<?php echo html_tag('link',
 array(
  'rel' => 'icon',
  'type' => 'image/jpg',
  'href' => Asset::get_file('favicon.ico', 'img'),
 )
); ?>
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
<div id = "contents">
</div>
<div class = "container" style = "margin-top:50px">
   <div class = "list-group">
   <?php
        foreach($json->data as $value){
                if(isset($value->installed) && isset($value->username)){
   ?>
         	<a href = "/user/<?php echo isset($value->username)? $value->username : $value->id; ?>/" class="list-group-item">
		<div class = "list-group-item-text"><img src = "<?php echo $value->picture->data->url;?>"></div>
		<p class="list-group-item-text"><?php echo $value->name;?></p>
		</a>                        
   <?php
                   }
           }
   ?>
   </div>
</div>
<HR size="4" color="010101">
<div id = "footer">
	&copy; JEJEJE. All Rights Reserved.
</div>
</body>
</html>
