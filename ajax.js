//this is js for ajax page

$(function(){	
	$('#videos').imagesLoaded(function(){
		$('#videos').masonry({
			itemSelector : '.ajax_item',
			isFitWidth: true,
			isAnimated: true,
			isResizable: true
		});
	});

	$("#frmSearch").submit(function(){
		search($("#keyword").val());
		return false;
	});
});

function search(keyword) {
	var i;
	$("#videos").text("Loading...");
	$.ajax({
		dataType: "jsonp",
		data: {
			"vq": keyword,
			"max-results":"9",
			"alt":"json-in-script"
		},
		cache: true,
		url: "http://gdata.youtube.com/feeds/api/videos",
		success: function (data) {
			$("#videos").empty();
			$.each(data.feed.entry, function(i,item){
				var group = item.media$group;

				//add title
				$("<div class = 'ajax_item' id = '" + i + "'><div class = 'info'>" + group.media$title.$t + "</div></div>")
				.appendTo("#videos");

				//add picture
				$("<div class = 'player'>")
				.append("<img src='" + group.media$thumbnail[0].url + "' class = 'play_video' width = '320px'/>")
				.append("<img src='/assets/img/play2.png' class='play_button' width='90px' style='opacity:0.4'>")
				.appendTo("#" + i);

				//add comment
				
				$("#" + i)
				.append("<div id = 'comment'><form action='/i/<?php echo $year;?>' accept-charset='utf-8' method='post'><textarea title='Your Message' rows='1' cols='30' name='comment' placeholder='ƒRƒƒ“ƒg‚ð“ü—Í‚µ‚Ä‚­‚¾‚³‚¢(”CˆÓ)'></textarea><input type = 'hidden' name='video' value='" + group.media$content[0].url + "'><input type = 'hidden' name='video_title' value=\"" + group.media$title.$t.replace(/"/i,"&quot;") + "\"><input type = 'image' src = '<?php echo Asset::get_file('like.png', 'img');?>' width = '40px'></form></section>");
				
				i++;
			});
			$("#videos").masonry('reload');
			play();
		}
	});
}

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
                        $(this).replaceWith("<iframe width='320' height='240' src='http://www.youtube.com/embed/"+params[4]+"?rel=0&autoplay=1&wmode=transparent' style='z-index:2'frameborder='0' allowfullscreen wmode='Opaque'></iframe>");
                });
        });
}
