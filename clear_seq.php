<?php
foreach(glob('seq/'.$_GET['id'].'/*') as $file){
	if(is_dir($file)) rrmdir($file); else unlink($file);
	} rmdir('seq/'.$_GET['id']);