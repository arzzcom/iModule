<?php $_ENV['isMobile'] = true; $_ENV['isHeaderIncluded'] = true; if (isset($_ENV['dir']) == false) REQUIRE_ONCE '../config/default.conf.php'; ?>
<!DOCTYPE HTML>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?php echo isset($title) == true ? $title : ''; ?></title>
<link rel="stylesheet" href="<?php echo $_ENV['dir']; ?>/css/NanumGothicWeb.css" type="text/css" title="style" />
<link rel="stylesheet" href="<?php echo $_ENV['dir']; ?>/css/default.css" type="text/css" title="style" />
<script type="text/javascript" src="<?php echo $_ENV['dir']; ?>/script/jquery.1.9.0.min.js"></script>
<script type="text/javascript" src="<?php echo $_ENV['dir']; ?>/script/default.js"></script>
<script type="text/javascript" src="<?php echo $_ENV['dir']; ?>/script/php2js.php"></script>
<?php
if (isset($resource) == true && is_array($resource) == true) {
	for ($i=0, $loop=sizeof($resource);$i<$loop;$i++) {
		if ($resource[$i]['type'] == 'css') {
			echo '<link rel="stylesheet" href="'.$resource[$i]['css'].'" type="text/css" title="style" />'."\n";
		} elseif ($resource[$i]['type'] == 'script') {
			echo '<script type="text/javascript" src="'.$resource[$i]['script'].'"></script>'."\n";
		} elseif ($resource[$i]['type'] == 'favicon') {
			echo '<link rel="shortcut icon" href="'.$resource[$i]['favicon'].'" />'."\n";
		} else {
			echo '<'.$resource[$i]['type'];
			foreach ($resource[$i]['content'] as $key=>$value) {
				echo ' '.$key.'="'.$value.'"';
			}
			echo ' />'."\n";
		}
	}
}
?>
</head>
<body<?php echo $body ? ' '.$body : $body; ?>>
