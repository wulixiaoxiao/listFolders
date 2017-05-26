<html>
<?php 
error_reporting(0);
$dir = $_GET['dir'];
$zDir = $_GET['zDir'];
$exts = explode(',',$_GET['exts']);


if($zDir) {
	$dir = $zDir;
}

if(!$dir) $dir = __DIR__;


$fileName = $_GET['file'];
if($fileName) {
	read_file($dir.'/'.$fileName);
	exit;
}


$upLevel = dirname($dir);

function read_file($file_path){
	if(file_exists($file_path)){
		$fp = fopen($file_path,"r");
		$str = "";
		$buffer = 1024;//每次读取 1024 字节
		while(!feof($fp)){//循环读取，直至读取完整个文件
			$str .= fread($fp,$buffer);
		} 
		$str = str_replace("\r\n","<br />",$str);
		echo "<div style='margin:100px;'>";
		echo '<pre>';
		echo $str;
		echo '</div>';
	}
	exit;
}

function read_dir($dir,$exts) 
{
	$list = [];
	$handle = opendir($dir);
	while(false !== ($file = readdir($handle))) {
		if ($file == '.') continue;
		if (is_dir($dir.'/'.$file)) {
			$list['dirl'][] = $file;
		} else {
			if(!empty($exts[0])){
				if(in_array(pathinfo($file, PATHINFO_EXTENSION),$exts)){
					$list['files'][] = $file;
					continue;
				}
			}else{
				$list['files'][] = $file;
			}
		}
	}
	return $list;
}

$list = (read_dir($dir,$exts));
$list['dirl'] && array_multisort($list['dirl']);

$list['files'] && array_multisort($list['files']);
//sort($list);
//var_dump($list);exit;
//return json_encode($s);


?>

<body>
	<div style="margin:100px;">
	
	
		<?php foreach($list['dirl'] as $v){?>
			<?php if($v == '..'){?>
			<a style="color:red" href="javascript:readdir('<?php echo $upLevel;?>', 1)">返回上一级</a>
			<?php } else {?>
			<a href="javascript:readdir('<?php echo $v;?>')"><?php echo $v;?></a>
			<?php }?>
			<br>
		<?php }?>

		<?php foreach($list['files'] as $v){?>
			<a style="color:black" href="javascript:readfile('<?php echo $v;?>')"><?php echo $v;?></a>
			<br>
		<?php }?>
	</div>
</body>

<script>

var Base = "<?php echo $dir;?>";

var Exts = "<?php echo $_GET['exts'];?>";
function readdir(Path, tag = 0){
	
	if (tag == 1) {
		location.href = '?zDir='+ Path + '&exts=' + Exts;
		return ;
	}
	location.href = '?zDir='+ Base + '/' + Path + '&exts=' + Exts;
}

function readfile(file){
	location.href = '?zDir='+Base+'/'+'&file='+file;
}


</script>
</html>
