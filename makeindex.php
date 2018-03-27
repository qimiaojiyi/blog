<?php
//配置
$root_dir = dirname(__FILE__); // 根目录
$default_content = ' ';  //生成的index.html文件默认内容
//开始执行
function rscandir($base = '',$return = 'all', &$data = array()  ) {
	$ds = '/'; // DIRECTORY_SEPARATOR
	$base = rtrim($base,$ds).$ds;
	$array = array_diff(scandir($base), array('.', '..', '.svn'));
	foreach ($array as $value) {
		if (is_dir($base . $value)) {
			if($return != 'file')
			$data[] = $base . $value . $ds;
			$data = rscandir($base . $value . $ds, $return, $data );
		} elseif (is_file($base . $value)) {
			if($return == 'dir') continue;
			$data[] = $base . $value;
		}
	}
	return $data;
}
$dirs = rscandir($root_dir, 'dir');
$current_path = str_replace('\\', '/', dirname(__FILE__));
$source_path = $current_path.'/index.html';
file_put_contents($source_path, $default_content);

foreach ($dirs as $d)
{
	copy($source_path, $d.'index.html');
}