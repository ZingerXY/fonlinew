<?php
$host='localhost';
$user='vitality_craft';
$password='Pu*91bbQ';
$db='vitality_craft';

$options = [
	'cost' => 11,
    'salt' => md5("salt"),
];

$mysqli = new mysqli($host, $user, $password, $db);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
if (!$mysqli->real_connect($host, $user, $password, $db)) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
else
{
	//echo "OK!";
}

function def($text,$linksql = false) {
	$result = strip_tags($text);
	$result = htmlspecialchars($result);
	if($linksql)
		$result = mysqli_real_escape_string ($linksql, $result);
	return $result;
}

?>