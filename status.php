<?php

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0", false);
header("Cache-Control: max-age=0", false);
header("Pragma: no-cache");

error_reporting(E_ALL);
//echo "<h2>Соединение TCP/IP</h2>\n";
/* Получаем порт сервиса WWW. */
$port = 6112;
$connect = true;
/* Получаем  IP адрес целевого хоста. */
if(isset($_GET["test"]))
	$address = "95.84.211.190";
else
	$address = "188.138.11.57";
/* Создаём  TCP/IP сокет. */

$timeout = 1;  //timeout in seconds

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
  or die("Unable to create socket\n");

socket_set_nonblock($socket)
  or die("Unable to set nonblock on socket\n");

$time = time();
while (!@socket_connect($socket, $address, $port))
{
  $err = socket_last_error($socket);
  if ($err == 115 || $err == 114)
  {
	if ((time() - $time) >= $timeout)
	{
	  socket_close($socket);
	  $connect = false;
	  break;
	}
	sleep(1);
	continue;
  }
  //die(socket_strerror($err) . "\n");
}

if($connect) {
	socket_set_block($socket)
	or die("Unable to set block on socket\n");
	
	$in = -1;
	$in = pack("i", $in); // signed integer
	$out = '';
	 
	//echo "Отправляем запрос...";
	socket_write($socket, $in, strlen($in));
	//echo "OK.\n";
	 
	//echo "Читаем ответ:\n\n";

	$out = socket_read($socket, 8);
	$out = unpack("i2", $out);
	//print_r($out);
	
	$All = $out[2];

	$Year = floor($All/31536000);
	$Xsec = $All-$Year*31536000;
	$Day = floor($Xsec/86400);
	$Yday = $Xsec-$Day*86400;
	$Hour = floor($Yday/3600);
	$Zhour = $Yday-$Hour*3600;
	$Minutes = floor($Zhour/60);
	$Second = $Zhour-$Minutes*60;

	$time = "";
	$text = "";
	if ($Year > 0)
	  $time .= $Year." лет ";
	if ($Day > 0) {
	  $mismod2 = $Day%100;
	  $mismod = $mismod2%10;
				if($mismod == 1 and $mismod2 != 11)
					$text = " day ";
				if($mismod > 1 and $mismod < 5)
				  $text = " days ";
				if($mismod2 > 4 and $mismod2 < 21 or $mismod > 4 and $mismod <= 9 or $mismod == 0)
				  $text = " days ";
	  $time .= $Day.$text;
	}
	if ($Hour > 0) {
	  $mismod2 = $Hour%100;
	  $mismod = $mismod2%10;
				if($mismod == 1 and $mismod2 != 11)
					$text = " hour ";
				if($mismod > 1 and $mismod < 5)
				  $text = " hours ";
				if($mismod2 > 4 and $mismod2 < 21 or $mismod > 4 and $mismod <= 9 or $mismod == 0)
				  $text = " hours ";
	  $time .= $Hour.$text;
	}
	if ($Minutes > 0) {
	  $mismod2 = $Minutes%100;
	  $mismod = $mismod2%10;
				if($mismod == 1 and $mismod2 != 11)
					$text = " min ";
				if($mismod > 1 and $mismod < 5)
				  $text = " min ";
				if($mismod2 > 4 and $mismod2 < 21 or $mismod > 4 and $mismod <= 9 or $mismod == 0)
				  $text = " min ";
	  $time .= $Minutes.$text;
	}
	if ($Second > 0) {
	  $mismod2 = $Second%100;
	  $mismod = $mismod2%10;
				if($mismod == 1 and $mismod2 != 11)
					$text = " sec ";
				if($mismod > 1 and $mismod < 5)
				  $text = " sec ";
				if($mismod2 > 4 and $mismod2 < 21 or $mismod > 4 and $mismod <= 9 or $mismod == 0)
				  $text = " sec ";
	  $time .= $Second.$text;
	}
	$str = "Online: ".$out[1]." Uptime: ".$time;
}
else {
	$str = "Offline";
}  

header ("Content-type: image/png");
 
// Шрифты
$font = 'font/fallout_display.ttf';
$size = 8;
$margin = 5;
$box = imagettfbbox($size, 0, $font, $str);
 
//$str1 = implode(" ",$box);
 
$w = $box[2] + 10;
$h = 18;
 
$im = ImageCreate ($w, $h) or die ("Ошибка при создании изображения");              

// Цвета
$fon = ImageColorAllocate ($im, 255, 255, 255); 
$white = ImageColorAllocate ($im, 0, 0, 0);  
$black = ImageColorAllocate ($im, 0, 200, 0);	
$gray = ImageColorAllocate ($im, 236, 236, 236);
if($str == "Offline")
	$black = ImageColorAllocate ($im, 200, 0, 0);

//ImageColorTransparent ($im, $fon);

imagefilledrectangle($im, 0, 0, $w, $h, $white);

// Рамка
//ImageRectangle ($im, 0, 0, $w-1, $h-1, $black);
//ImageColorTransparent ($im, $white);

Imagettftext($im, $size, 0, 5, 13, $black, $font, $str);
//Imagettftext($im, $size, 0, 0, 20, $black, $font, $str1);
ImagePng ($im);
?>