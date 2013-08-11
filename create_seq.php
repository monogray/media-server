<?php
if ( isset ($GLOBALS['HTTP_RAW_POST_DATA']) ){
	if (!is_dir('seq/'.$_GET['id'])) mkdir('seq/'.$_GET['id']);
	$filename = 'image'.$_GET['frame'].'.jpg';
	$fp = fopen('seq/'.$_GET['id'].'/'.$filename, 'wb');
	fwrite( $fp, $GLOBALS['HTTP_RAW_POST_DATA'] );
	fclose( $fp );
}