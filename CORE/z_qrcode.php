<?php
include "qrcode/qrlib.php";
function c_color($f_name,$t_rgb){
	$img_file = $f_name;
	list($src_w,$src_h,$src_type) = getimagesize($img_file);

	$im = ImageCreateFromPng($img_file);
	
	$t_rgb = explode(',',$t_rgb);

	$t_color = imagecolorallocate($im,$t_rgb[0],$t_rgb[1],$t_rgb[2]);

	for($x = 0; $x < $src_w; $x++){
		for($y = 0; $y < $src_h; $y++){
			$rgb = ImageColorAt($im, $x, $y);		
			if($rgb == 1){
				imagesetpixel ($im,$x,$y,$t_color);
			}			
		}
	}
	imagepng($im,$f_name);
	imagedestroy($im);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>z_qrcode</title>
</head>

<body>
<?php
$qr_data = $_POST['d'];
if(!$qr_data) $qr_data = 'z_qrcode';
$errorCorrectionLevel = $_POST['e'];
if(!$errorCorrectionLevel) $errorCorrectionLevel = 'L';
$matrixPointSize = $_POST['s'];
if(!$matrixPointSize) $matrixPointSize = 4;
$qr_color = $_POST['c'];
if(!$qr_color) $qr_color = '0,0,0';

$filename = 'qr_img'.DIRECTORY_SEPARATOR;
$filename .= 'qr_'.md5(time().$errorCorrectionLevel.$matrixPointSize.$qr_data.mt_rand(1000,9999)).'.png';

QRcode::png($qr_data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

if($qr_color != '0,0,0'){
	c_color($filename,$qr_color);
}

echo '<img src="',$filename,'">';
?>
</body>
</html>
