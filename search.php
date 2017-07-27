<? 
include 'config.php';

if(isset($_POST["search"])) {
	$obj = mysqli_real_escape_string($mysqli, $_POST["search"]);
	$result = mysqli_query($mysqli, "SELECT id,pid,name,pic FROM items WHERE (locate(lower('$obj'),lower(name))>0) ORDER BY name LIMIT 0,10");
	echo "<table class='table'>";
	while($myrow = mysqli_fetch_assoc($result)) {
		$href = "?craft&pid=".$myrow['pid'];
		$pic = strtolower($myrow['pic']);
		$id = $myrow['id'];
		echo "<tr><td><a href='$href'><img src=\"img/pic/$pic.png\"></a></td><td><a href='$href'>".$myrow['name']."</a></td><td>$id</td></tr>";
	}
	echo "</table>";
}

mysqli_close($mysqli); 
?>