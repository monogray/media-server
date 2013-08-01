<?php
if (!file_exists('videos/video-'.$_GET['id'].'.flv'))
	exec('ffmpeg -f image2 -i seq/'.$_GET['id'].'/image%d.jpg -vcodec flv -b 800k -r 12 videos/video-'.$_GET['id'].'.flv');
else
	echo 'video exist';