<?php
error_reporting();
set_time_limit(0);
$dir = trim($_GET['dir'])?:__DIR__;
$ext = trim($_GET['ext'])?:__DIR__;
$exts = explode(',', $ext);
readf($dir, $exts);
function readf($dir, $exts){
	$list = scandir($dir);
	foreach ($list as $v) {
		if($v != '.' && $v != '..') {
			$fileName = $dir.'/'.$v;
			if (is_dir($fileName)) {
				readf($fileName, $exts);
			} else {
			    $finfo = finfo_open(FILEINFO_MIME);
                $fileInfo = finfo_file($finfo, $fileName);
                finfo_close($finfo);
                $fileInfo = explode(';', $fileInfo);
                $fileInfo = explode('/', $fileInfo[0]);
                if (!empty($exts[0])) {
                    if (in_array($fileInfo[1], $exts)) {
                        echo $fileName.'<br>';
                    }
                }else{
                    echo $fileName.'<br>';
                }
			}
		}
	}
}


















