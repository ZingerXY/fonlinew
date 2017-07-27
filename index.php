<?php 
//header('Location:http://fonlinew.ru'.$_SERVER['REQUEST_URI']);
header('Content-Type: text/html;charset=UTF-8'); 
?>
<html>
<head>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-1137676622459224",
    enable_page_level_ads: true
  });
</script>
<?
/* Отладка
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
*/

$title = "";
$descrip = "";
$jscookie = "";
$calculator = "";
$search = "";
$menu = "";
$content = "";
include 'config.php';

if (isset($_COOKIE['error'])) {
	$error = $_COOKIE['error'];
	$jscookie = "var error = $error;";
	setcookie("error", "", time()-3600);
}
else {
	$jscookie = "var error = 0;";
}

if(isset($_GET["char"]) or isset($_GET["hash"])) {	
		// CALC
		if(isset($_GET["en"])) {
			$title .= "Fonlinew - Calculator";
			$descrip .= "Build calculator, character creation on server Fallout 2 Online: Requiem";
			
			$calculator = "<div id='lang'><a href='?char' rel='alternate' hreflang='ru'><img src='img/flag_dirty_ru.png'></a></div><iframe id='iframe' src='char/char_eng.php";		
		}					
		else {
			$title .= "Fonlinew - Калькулятор";
			$descrip .= "Калькулятор билдов, создание персонажа на сервере Fallout 2 Online: Requiem";
			
			$calculator = "<div id='lang'><a href='?char&en' rel='alternate' hreflang='en'><img src='img/flag_dirty_en.png'></a></div>
				<iframe id='iframe' src='char/char_rus.php";
		}			
		if(isset($_GET["hash"])) {
			$hashcalc = def($_GET["hash"]);
			$calculator .= "?hash=$hashcalc";
			$title .= ": $hashcalc";
		}
			
		$calculator .= "'>Ваш браузер не поддерживает плавающие фреймы!</iframe>";
}
else {
	// SEARCH
	$search = "<div id='secondary'>";
	if(isset($_GET["craft"]) && /*!isset($_GET["pid"]) &&*/ !isset($_GET["id"]) && !isset($_GET["class"]) && !isset($_GET["rmic"])) {
			$search .= "<aside id='search-2'>
							<form role='search' method='get' class='search-form' action=''>
								<label>
									<span class='screen-reader-text'>Найти:</span>
									<input id='search' class='input' type='search' class='search-field' placeholder='Поиск…' value='' name='s'>
								</label>
								<input type='submit' class='search-submit' value='Поиск'>
							</form>
						</aside>";
	}
	$search .=
	// MENU
	$menu = "<aside id='categories'>";				
	if(isset($_GET["barter"])) {
		$title .= "Fonlinew - Торговля";
		$descrip .= "Тоговцы и караваны на сервере Fallout 2 Online: Requiem";
		
		$znan = array(
			"nubloc" => "Нуболока",
			"arroyo" => "Арройо",
			"westwood" => "Вествуд",
			"klamat" => "Кламат",
			"den" => "Ден",
			"modoc" => "Модок",
			"gekko" => "Гекко",
			"vc" => "Город-Убежище",
			"redd" => "Реддинг",
			"nr" => "Нью-Рено",
			"bh" => "Брокен Хиллс",
			"ncr" => "НКР",
			"sanfran" => "Сан-Франциско",
			"dry" => "Драйфилд",
			"maripos" => "Марипоза",
			"atol" => "Атолл",
			"caravant" => "Караванщики",
			"caravan" => "Караваны"
		);
		$menu .= "<h3 class=\"widget-title\">Торговля</h3><ul>";
		foreach ($znan as $k => $a) {
			if ($k != "LIMIT") {
				$menu .= "<li><a href='#$k'>$a</a></li>";
			}
		}						
	}
	else if(isset($_GET["craft"])) 
	{		
		$title .= "Fonlinew - Крафт";	
		$descrip .= "База крафта предметов на сервере Fallout 2 Online: Requiem";

		$menu .= "<h3 class=\"widget-title\">Крафт</h3><ul>";
		$menu .= "<li><a href='?craft&rmic'>Микро-рецепты</a></li>";
		$result = mysqli_query($mysqli, "SELECT DISTINCT class,podclass FROM items ORDER BY class");
		while($myrow = mysqli_fetch_assoc($result)) {
			$class = $myrow['class'];
			$podclass = $myrow['podclass'];
			if($class != "Container" and $class != "Keys" and $class != "Mortier and foxholes" and $class != "New lockers" and $class != "Valuta" and $class != "Инженер") {
				if($podclass != "")
					$menu .= "<li><a href='?craft&class=$class&podclass=$podclass'>$podclass</a></li>";
				else
					$menu .= "<li><a href='?craft&class=$class'>$class</a></li>";
			}								
		}
	}
	else if(isset($_GET["znan"])) {
		$title .= "Fonlinew - Знания";
		$descrip .= "Декрафт и получение знаний на сервере Fallout 2 Online: Requiem";
		
		$znan = array(
			"METALLURGY" => "Металургия",
			"BALLISTIC" => "Баллистика",
			"MECHANICS" => "Механика",
			"CHEMISTRY" => "Химия",
			"OPTICS" => "Оптика",
			"ELECTRONICS" => "Электроника",
			"CYBERNETICS" => "Кибернетика",
			"ENERGETICS" => "Энергетика",
			"PHARMACOLOGY" => "Фармокология",
			"VIRUSOLOGY" => "Вирусология",
			"BIOLOGY" => "Биология",
			"LIMIT" => "Лимит"
		);
		$menu .= "<h3 class=\"widget-title\">Знания</h3><ul>";
		foreach ($znan as $k => $a)
			if ($k != "LIMIT")
				$menu .= "<li><a href='?znan=$k'>$a</a></li>";					
	}
	else if(isset($_GET["info"])) {
		if(isset($_GET["en"])) {
			$title .= "Fonlinew - Info";
			$descrip .= "Info for server Fallout 2 Online: Requiem";
			
			$znan = array(
				"med" => "Medals",
				"update" => "Upgrades",
				"drug" => "Drugs",
				"imp" => "Implants",
				"gunperk" => "Weapon perks",
				"addslot" => "Slots",
				"spec" => "SPECIAL",
				"over" => "OVERALL",
				"cbiz" => "TsBiZ"
			);
			$menu .= "<h3 class=\"widget-title\">Info</h3><ul>";
			foreach ($znan as $k => $a) {
				if ($k != "LIMIT") {
					$menu .= "<li><a href='#$k'>$a</a></li>";
				}
			}
		}
		else {
			$title .= "Fonlinew - Инфа";
			$descrip .= "Полезная информация о сервере Fallout 2 Online: Requiem";
			
			$znan = array(
				"med" => "Медали",
				"update" => "Улучшения",
				"drug" => "Упорка",
				"imp" => "Импланты",
				"gunperk" => "Перки оружия",
				"addslot" => "Доп слоты",
				"spec" => "SPECIAL",
				"over" => "OVERALL",
				"cbiz" => "ЦБИЗ"
			);
			$menu .= "<h3 class=\"widget-title\">Инфа</h3><ul>";
			foreach ($znan as $k => $a) {
				if ($k != "LIMIT") {
					$menu .= "<li><a href='#$k'>$a</a></li>";
				}
			}
		}
	}
	else {
		$menu .= "<h3 class=\"widget-title\">Меню</h3><ul>";
		$menu .= "<li><a href='?barter'>Торговля</a></li>
			<li><a href='?craft'>Крафт</a></li>
			<li><a href='?znan'>Знания</a></li>
			<li><a href='?char'>Калькулятор</a></li>
			<li><a href='?info'>Инфа</a></li>";
	}
	$menu .= "</ul></aside></div>";
	// CONTENT
	$content = "<div id='primary'>
				<div id='namecat'>
				</div>
				<div id='maincontent' class='tab-main'>";
	if(isset($_GET["barter"]))
		$content .= file_get_contents("pages/barter.php");		
	else if(isset($_GET["info"])){
		if(isset($_GET["en"])) {
			$content .=  "<div id='lang'><a href='?info' rel='alternate' hreflang='ru'><img src='img/flag_dirty_ru.png'></a></div>";
			$content .= file_get_contents("pages/info_en.php");										
		}
		else {
			$content .=  "<div id='lang'><a href='?info&en' rel='alternate' hreflang='en'><img src='img/flag_dirty_en.png'></a></div>";
			$content .= file_get_contents("pages/info.php");			
		}
		$content .=  "<style>
		#lang {
			margin-left: 674px;
			margin-top: -125px;
		}		
		</style>";
	}		
	else if(isset($_GET["craft"])) {
		if(isset($_GET["class"])) {
						
			$podclass = "";		
			$class = def($_GET["class"],$mysqli);
			$titl = "";
			$title .= ":";
			if(isset($_GET["podclass"])) {
				$podclass = def($_GET["podclass"],$mysqli);
				$result = mysqli_query($mysqli, "SELECT * FROM items WHERE class='$class' AND podclass='$podclass' ORDER BY podclass,name");
				$title .= " ".mb_strtolower($podclass, 'UTF-8');
				$titl .= $podclass;
			} 
			else {
				$result = mysqli_query($mysqli, "SELECT * FROM items WHERE class='$class' ORDER BY podclass,name");			
			}
			if(mysqli_num_rows ( $result ) > 0) {
				$title .= " ".mb_strtolower($class, 'UTF-8');
				$titl .= " ".$class;
				$content .=  "<h3 class='mtitle'>$titl</h3>";
				$content .=  "<table class='table'>";
				while($myrow = mysqli_fetch_assoc($result)) {
					if($podclass != $myrow['podclass']) {
						$podclass = $myrow['podclass'];
						$content .=  "<tr><td><a name='$podclass'></a><h3 class='mtitle'>$podclass</h3></td></tr>";
					}
					$href = "?craft&pid=".$myrow['pid'];
					$pid = $myrow['pid'];
					$pic = strtolower($myrow['pic']);
					$result2 = mysqli_query($mysqli, "SELECT COUNT(pid) FROM craft WHERE pid = '$pid'");
					$myrow2 = mysqli_fetch_assoc($result2);
					if($myrow2['COUNT(pid)'])
						$content .=  "<tr><td><a href='$href'><img src=\"img/pic/$pic.png\"></a></td><td><a href='$href'>".$myrow['name']."</a></td></tr>";
					if($class == "Топ")
						$content .=  "<tr><td><a href='$href'><img src=\"img/pic/$pic.png\"></a></td><td><a href='$href'>".$myrow['name']."</a></td></tr>";
				}
				$content .=  "</table>";
			}
		}
		else if (isset($_GET["pid"]) or isset($_GET["id"]))
		{
			$znan = array(
				"METALLURGY" => "Металургия",
				"MECHANICS" => "Механика",
				"CHEMISTRY" => "Химия",
				"OPTICS" => "Оптика",
				"ELECTRONICS" => "Электроника",
				"CYBERNETICS" => "Кибернетика",
				"ENERGETICS" => "Энергетика",
				"PHARMACOLOGY" => "Фармокология",
				"VIRUSOLOGY" => "Вирусология",
				"BIOLOGY" => "Биология",
				"BALLISTIC" => "Баллистика",
				"LIMIT" => "Лимит"
			);
			
			function divide($mysqli, $str, $nm, $par = "", $tp = true) {
				$returne = "";
				$craft = array();
				$param = explode('&',$str);
				$n0 = 1;
				foreach ($param as $a) {
					if($n0 > 1) $returne .=  "и ";
					$n0++;
					$param11 = explode('|',$a);
					$n1 = 1;
					foreach ($param11 as $b) {
						if($n1 > 1) $returne .=  "или ";
						$n1++;
						$param12 = explode(' ',$b);
						$pid0 = $param12[0];
						if($nm == "items")
							$result3 = mysqli_query($mysqli, "SELECT name,pic FROM $nm WHERE pid = '$pid0'");
						else
							$result3 = mysqli_query($mysqli, "SELECT name FROM $nm WHERE pid = '$pid0'");
						$myrow3 = mysqli_fetch_assoc($result3);
						
						$count = $param12[1];
						if($nm == "items") {
							$link0 = "<a href='?craft&pid=$pid0'>";
							$link1 = "</a>";
							if(isset($_GET["x"])) {
								$xx = def($_GET["x"]);
								$count = $count * $xx;
							}
						}
						else {$link0 = ""; $link1 = "";}
						$returne .=  $link0.$myrow3['name'].$link1." ".($tp?$count:"").$par."<br>";
						$craft[$myrow3['name']] = $myrow3['pic'];
					}
				}
				if($nm == "items")
					foreach($craft as $c) {
						if($c == "") continue;
						$returne .=  strtolower("<img src=\"img/pic/$c.png\" class='imgcr'>");
					}
				return $returne;
			}
			
			/*ini_set('error_reporting', E_ALL);
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);*/
			
			if(isset($_GET["pid"])) {
				$obj = def($_GET["pid"],$mysqli);
				$result = mysqli_query($mysqli, "SELECT * FROM items WHERE pid =  '$obj'");
			}			
			else if(isset($_GET["id"])) {
				$obj = def($_GET["id"],$mysqli);
				$result = mysqli_query($mysqli, "SELECT * FROM items WHERE id =  '$obj'");	
			}
			else return;
			
			//print_r($result);
			
			if($result->num_rows < 1) exit();
			
			$myrow = mysqli_fetch_assoc($result);
			$pid = $myrow['pid'];
			$pic = strtolower($myrow['pic']);
			$content .=  "<table class='table'><tr><th><img src=\"img/pic/$pic.png\"></th>";
			$content .=  "<th>".$myrow['name']."</th></tr>"; 
			$title .= ": ".$myrow['name'];
			if(isset($_GET["inf"]) || true) {
				$content .=  "<tr><td>PID</td><td>".$myrow['pid']."</td></tr>";
				$content .=  "<tr><td>ID</td><td>".$myrow['id']."</td></tr>";
			}
			$content .=  "<tr><td colspan=2>".$myrow['description']."</td></tr>"; 
			$content .=  "<tr><td>Вес </td><td>".$myrow['Weight']."</td></tr>"; 
			$content .=  "<tr><td>Цена </td><td>".$myrow['Cost']."</td></tr>"; 
			$content .=  "<tr><td>Класс </td><td>".$myrow['class']."</td></table></tr>";
			if($myrow['class'] != "Топ") {
				$content .=  "<h2>Декрафт:</h2><table class='table'>"; 		
				$result2 = mysqli_query($mysqli, "SELECT * FROM decraft WHERE pid =  '$pid'");
				if(!($result2->num_rows < 1)) {
					$myrow2 = mysqli_fetch_assoc($result2);	
					foreach ($myrow2 as $k => $a)				
						if ($k != "pid" && $a != 0)
							$content .=  "<tr><td>".$znan[$k]."</td><td>$a</td></tr>";
				}
				$content .=  "</table>";
			}
			$result2 = mysqli_query($mysqli, "SELECT * FROM craft WHERE pid =  '$pid'");
			$num = 1;	
			while($myrow2 = mysqli_fetch_assoc($result2)) {
				if ($myrow2){
					$content .=  "<div class='craft'><h2>Крафт $num:</h2>"; 
					$outitem = explode('|', $myrow2['output']);
					foreach ($outitem as $a) {
						$param = explode(' ',$a);
						$pid0 = $param[0];
						$result3 = mysqli_query($mysqli, "SELECT name FROM items WHERE pid = '$pid0'");
						$myrow3 = mysqli_fetch_assoc($result3);
						$count = 0;
						if(isset($_GET["x"])) {
							$count =  def($_GET["x"]);
						}
								
						$content .=  $myrow3['name']." ".$param[1]." шт. ".($count > 0 ? "X $count" : "")." <br>";
					}
					$content .=  $myrow2['exp']." опыта<br>";
					$content .=  "<br>".$myrow2['description']."<br>";
					$content .=  "<br>Параметры для появления:<br>";
					$content .= divide($mysqli, $myrow2['param1'], "perks");
					$content .=  "<br>Параметры для крафта:<br>";
					$content .= divide($mysqli, $myrow2['param2'], "perks");
					$content .=  "<br>Инструменты:<br>";
					$content .= divide($mysqli, $myrow2['tool'], "items", "", false);
					$content .=  "<br>Предметы:<br>";
					$content .= divide($mysqli, $myrow2['items'], "items", " шт.");
					$content .=  "</div>";
				}
				$num++;					
			}				
			if($num == 1){
				if($myrow['class'] != "Топ")
					$content .=  "<br>Не крафтится<br>";
				else {
					
					$result4 = mysqli_query($mysqli, "SELECT * FROM top WHERE pid =  '$pid'");
					$myrow4 = mysqli_fetch_assoc($result4);
					if ($myrow4){
						
						$content .=  "<div class='craft'><h2>Крафт $num:</h2>"; 
						$outitem = explode('|', $myrow4['output']);
						foreach ($outitem as $a) {
							$param = explode(' ',$a);
							$pid0 = $param[0];
							$result5 = mysqli_query($mysqli, "SELECT name FROM items WHERE pid = '$pid0'");
							$myrow5 = mysqli_fetch_assoc($result5);
							$content .=  $myrow5['name']." ".$param[1]." шт. <br>";
						}
						$content .=  "<br>".$myrow4['description']."<br>";
						$content .=  "<br>Предметы:<br>";
						$content .= divide($mysqli, $myrow4['items'], "items", " шт.");
						$content .=  "</div>";
					}
				}
			}
				
			
			$num = 1;
			$result2 = mysqli_query($mysqli, "SELECT DISTINCT pid, items FROM craft");
			$content .=  "<div class='craft nofloat'>";
			while($myrow2 = mysqli_fetch_assoc($result2)) {			
				$pid0 = $myrow2['pid'];
				if(stripos($myrow2['items'], $pid) !== false) {		
					if($num == 1) $content .=  "<h2>Можно скрафтить:</h2>";			
					$pid0 = $myrow2['pid'];
					$result3 = mysqli_query($mysqli, "SELECT name FROM items WHERE pid = '$pid0'");
					$myrow3 = mysqli_fetch_assoc($result3);
					if($myrow3['name'] != "")
						$content .=  "<a href='?craft&pid=$pid0'>".$myrow3['name']."</a><br>";
					$num++;	
				}
			}
			$content .=  "</div>";
			$content .=  "<div class='craft nofloat'>";
			$result2 = mysqli_query($mysqli, "SELECT DISTINCT pid,items FROM top");
			while($myrow2 = mysqli_fetch_assoc($result2)) {			
				$pid0 = $myrow2['pid'];
				if(stripos($myrow2['items'], $pid) !== false) {		
					if($num == 1) $content .=  "<h2>Можно скрафтить:</h2>";			
					$pid0 = $myrow2['pid'];
					$result3 = mysqli_query($mysqli, "SELECT name FROM items WHERE pid = '$pid0'");
					$myrow3 = mysqli_fetch_assoc($result3);
					if($myrow3['name'] != "")
						$content .=  "<a href='?craft&pid=$pid0'>".$myrow3['name']."</a><br>";
					$num++;	
				}
			}
			$content .=  "</div>";
		}
		else if(isset($_GET["rmic"])) {
			$content .= "<h3 class='mtitle'>Микро-рецепты</h3>";
			$content .= "<input id='rmicsearch' class='input' type='search' class='search-field' placeholder='Поиск…' value='' name='s'>";
			$content .= "<table id='rmic' class='table'>";
			$content .= "<tr><th>Первый</th><th></th><th>Второй</th><th></th><th>Результат</th></tr>";
			$result = mysqli_query($mysqli, "SELECT * FROM rmicro");
			while($myrow = mysqli_fetch_assoc($result)) {
				$item = $myrow['item'];
				$fitem = $myrow['fitem'];
				$sitem = $myrow['sitem'];
				$item_ = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM items WHERE id = '$item'"));
				$fitem_ = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM items WHERE id = '$fitem'"));
				$sitem_ = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM items WHERE id = '$sitem'"));
				$content .=  "<tr>
				
				<td><a href='?craft&pid=".$fitem_['pid']."'>".$fitem_['name']."<br><img src=\"img/pic/".$fitem_['pic'].".png\"></a></td><td>+</td>
				<td><a href='?craft&pid=".$sitem_['pid']."'>".$sitem_['name']."<br><img src=\"img/pic/".$sitem_['pic'].".png\"></a></td><td>=</td>
				<td><a href='?craft&pid=".$item_['pid']."'>".$item_['name']."<br><img src=\"img/pic/".$item_['pic'].".png\"></a></td>
				</tr>";
				//$content .=  "<tr><td><a href='#'><img src=\"img/pic/$pic.png\"></a></td><td><a href='#'>"."тест"."</a></td><td><a href='#'>"."тест"."</a></td></tr>";
			}
			$content .=  "</table>";
		}
		else {
			$content .=  "В этом разделе содержится информация по крафту вещей.";
		}
	}
	else if(isset($_GET["znan"])) {
		$znanie =  def($_GET["znan"],$mysqli);
		if($znanie != "") {
			if(isset($_GET["lim"])){
				$lim = def($_GET["lim"],$mysqli);
				$result = mysqli_query($mysqli, "SELECT * FROM decraft WHERE `$znanie` > 0 AND `LIMIT` >= $lim ORDER BY `$znanie`,`LIMIT`");
				$content .=  "<h2>".$znan[$znanie]." лимит $lim</h2>";
				$title .= ": ".$znan[$znanie]." лимит $lim";
			}
			else
			{
				$result = mysqli_query($mysqli, "SELECT * FROM decraft WHERE `$znanie` > 0 ORDER BY `$znanie`,`LIMIT`");
				$content .=  "<h2>".$znan[$znanie]."</h2>";
				$title .= ": ".$znan[$znanie];
			}				
			if($result) {
				$content .=  "<table class='table'>";			
				$content .=  "<tr><td>Предмет</td><td align='center'>".$znan[$znanie]."</td><td align='center'>Лимит</td>";
				while($myrow = mysqli_fetch_assoc($result)) {
					$content .=  "<tr>";
					$param = $myrow[$znanie];
					$limit = $myrow['LIMIT'];
					$pid = $myrow['pid'];		
					$result2 = mysqli_query($mysqli, "SELECT name FROM items WHERE pid = '$pid'");
					$myrow2 = mysqli_fetch_assoc($result2);
					$name = $myrow2['name'];
					$content .=  "<td><a href='?craft&pid=$pid'>".$name."</a></td>";
					$content .=  "<td align='center'>$param</td>";
					$content .=  "<td align='center'><a href='?znan=$znanie&lim=$limit'>$limit</a></td>";
					
					$content .=  "</tr>";
				}	
				$content .=  "</table>";
			}
		}
		else {
			$content .=  "В этом разделе можно узнать какие вещи надо разбирать для получения знаний.";
		}
	}
	else {
		$title .= "Fonlinew";
		$descrip .= "Сайт содержит базу вещей и калькулятор персонажей для сервера Fallout 2 Online: Requiem";
		
		$content .=  "<h3 class='mtitle'>Информация</h3>
		<ul>
			<li>Страница <a href='?barter'>Торговля</a> содержит информацию о прокачке торговли, навыке торговцев в городах и их специализацию, а так же навык торговли караванов в пустоши</li>
			<li><a href='?craft'>Крафт</a> это база предметов в игре с описанием их крафта с возможностью поиска предметов</li>
			<li>На странице <a href='?znan'>Знания</a> можно узнать какие предметы необходимо разобрать для прокачки различных знаний</li>
			<li><a href='?char'>Калькулятор</a> - это online приложение для создания билдов для игры с возможностью их сохранения</li>
			<li>Страница <a href='?info'>Информация</a> содержит различные полезные сведения об игре</li>
		</ul>";
	}	
	$content .= "</div></div>";
}
@mysqli_close($mysqli);

?>
	<meta charset="utf-8"></meta>
	<title>
	<?
	echo $title;
	?>	
	</title>
	<meta name="yandex-verification" content="4b19e0a6d3646335" />
	<meta name=viewport content="width=device-width, initial-scale=0.6">
	<meta name="description" content="<? echo $descrip;?>">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="style.css">
	<script type = "text/javascript">
	<?
		echo $jscookie;
	?>
	</script>
	<script type = "text/javascript" async src = "js/app.js"></script>
	<script type="text/javascript" async src="js/jquery-2.1.4.min.js" ></script>
	<?
	if(isset($_GET["char"]) and false) {
	?>
	<link rel='alternate' hreflang='en' href='?char&en' /><script>var calc = true;</script>
	<?
	}else {
		echo "<script>var calc = false;</script>";
	}
	?>	
	<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter40203619 = new Ya.Metrika({ id:40203619, clickmap:true, trackLinks:true, accurateTrackBounce:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/40203619" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-85764115-1', 'auto');
  ga('send', 'pageview');
	</script>
</head>
<body>
	<header id = "header" class = "header">
		<div class="header-wrap">
			<div class="container"> 
				<div id="head" class="row">
					<div class="logo">
						<a href="?"><h1 id="textlogo"><span class="logoOne logtxt">Fonli</span><span class="logoTwo logtxt">new</span></h1></a>		
					</div>
					<div class="wrap-menu">
						<nav id="mainnav" class="mainnav">
							<div class="menu-menyu-container">
								<ul id="primary-menu" class="menu">
									<li><a href="?barter">Торговля</a></li>
									<li><a href="?craft">Крафт</a></li>
									<li><a href="?znan">Знания</a></li>
									<li><a href="?char">Калькулятор</a></li>
									<li><a href="?info">Инфа</a></li>
									<?/* include'check.php';
									if($check) {?>
									<li><a href="#"><?echo $email;?></a></li>
									<li><a href="logout.php">Выход</a></li>
									<?} else {?> 
									<li><a href="#" onclick="LoginShow(); return false;">Войти</a></li>
									<?}*/?>
								</ul>
							</div>						
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div id="main" class="main-content">
		<div class="container">
			<div class="row">
				<div class="status"><img src="status.php">
				</div>
<?	// ФРЕЙМ КАЛЬКУЛЯТОРА
	echo $calculator;
	// ПОИСК
 	echo $search;
	// МЕНЮШКИ РАЗДЕЛОВ
	echo $menu;
	// КОНТЕНТ РАЗДЕЛОВ
	echo $content;
?>						
			</div>
		</div>
	</div>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-wrap">
			<div id="foot" class="site-info container">			
				Сайт создан при поддержке администрации сервера <a href="http://forum.fallout2online.ru/">Fallout Online: Requiem</a>
			</div>
		</div>
	</footer>
	<?
	// Регистрация и авторизация
	?>
	<div id="scroll" class="scrollLeft">
		<a href="#" class="scrollup"><img src="img/icon_top.png"></a>
	</div>
	<script>
	if(!calc) {
		var h = window.innerHeight - (document.getElementById("header").offsetHeight + document.getElementById("colophon").offsetHeight) - 80;
		if((document.getElementById("main").offsetHeight-80) < h)
			document.getElementById("secondary").style.height = h+"px";
		if(window.innerWidth > 1100)
			document.getElementById("scroll").style.width = 100+"px";
	}	
	</script>
</body>
</html>