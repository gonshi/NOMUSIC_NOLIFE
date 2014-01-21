
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<?php echo Asset::js('ajax.js'); ?>
<?php echo Asset::css('ajax.css'); ?>
<?php echo html_tag('link',
 		array(
  		'rel' => 'icon',
  		'type' => 'image/jpg',
  		'href' => Asset::get_file('favicon.ico', 'img'),
 		)
); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

</head>
<body>

<div id = "youtube_header">
	<?php echo Asset::img('youtube.png',array('style' => 'display:inline'));?>
	<form id="frmSearch" style="display:inline">
	  	<input type="text" id="keyword" name="keyword">
	  	<input type="image" src="<?php echo Asset::get_file('button.png', 'img');?>" class="button">
	</form>
</div>

<div id = "container">
	<div id="videos">
	</div>
</div>
</body>
</html>
