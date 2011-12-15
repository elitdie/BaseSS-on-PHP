<?php 
session_start ();			//Старт сессии
?>
<html>
<head>
<title>ТЕСТОВАЯ ВЕРСИЯ ПРОГРАММЫ УЧЕТА</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<link rel=stylesheet type=text/css href=./my.css>
<script type="text/javascript">
function changeVis() {
var el=document.getElementById('canvas')
var chan=document.getElementById('changer')

if (el.style.display == 'none') {
el.style.display = 'block'
chan.value='Скрыть панель' }
else {
el.style.display = 'none'
chan.value='Показать панель'
}
}

</script>
</head>
<body>
<?php
#var_dump($_REQUEST[typeofget]);
#var_dump($_REQUEST);

require('./inc/connect.php');
require('./inc/func.php');
	$query = "CREATE TABLE IF NOT EXISTS zakaz (n INT, nomer INT, date VARCHAR(10), date_z VARCHAR(10), klient VARCHAR(40), phone VARCHAR(25), prinyato VARCHAR(200), problem VARCHAR(100), status VARCHAR(20), sum VARCHAR(15), worker VARCHAR(20), oplacheno VARCHAR(3), type VARCHAR(100), materials VARCHAR(200))";												//создание таблицы с двумя резервными полями
	$result = mysql_query ($query)										//запрос
		or die ("Ошибка при создании таблицы в базе данных. Подробнее: ".mysql_error ());
	$query = "CREATE TABLE IF NOT EXISTS env (counter INT, nomer INT, counter_work INT, rezerv1 VARCHAR(50), rezerv2 VARCHAR(50))";		//создание таблицы с переменными
	$result = mysql_query ($query)										//запрос
		or die ("Ошибка при создании таблицы переменных в базе данных. Подробнее: ".mysql_error ());

//загрузка базы с переменными в массив

$query = "SELECT counter,nomer FROM env LIMIT 1";
$result = mysql_query ($query)
	or die ("Ошибка при загрузке данных из базы переменных в массив: ".mysql_error ());
$env = mysql_fetch_assoc ($result);

if ($env['counter'] == '')
	{
	$query = "insert into env values ('1', '1000', '1', '', '')";
	$result = mysql_query ($query)
		or die ("Ошибка при внесении базовых переменных. Подробнее: ".mysql_error ());

	$query = "SELECT counter,nomer FROM env LIMIT 1";
	$result = mysql_query ($query)
		or die ("Ошибка при загрузке данных из базы переменных в массив: ".mysql_error ());
	$env = mysql_fetch_assoc ($result);
	}

//заносим переменные из базы в сессионные переменные
$_SESSION['counter'] = $env['counter'];
$_SESSION['nomer'] = $env['nomer'];

#var_dump($_SESSION);

if ($_REQUEST[drop]) require './inc/fill_tb.php';

include "./inc/massive.php";

$date = date("Y-m-d");

if ($_REQUEST[typeofget]) {
	foreach ($_REQUEST[typeofget] as $kt) {
		foreach ($type as $k => $v) {
			if ($kt == $k) $typeofget.=$v.',';
		}
	}
#echo $typeofget;
}


if ($_REQUEST['date_m']) $date = $_REQUEST[date_y].'-'.$_REQUEST[date_m].'-%'.$_REQUEST[date_d];
foreach ($type as $var_type => $var_label)
	{
	if ($_REQUEST[$var_type]) $label.=$_REQUEST[$var_type]."%";
	}
if ($_REQUEST['date_m_z']) $date_z = $_REQUEST[date_y_z].'-'.$_REQUEST[date_m_z].'-%'.$_REQUEST[date_d_z];

$query = "SELECT date,status FROM zakaz WHERE date_z like CURRENT_DATE() AND status = 'Выполняется!'";
$result = mysql_query ($query);
$today_num = mysql_num_rows($result);
if ($today_num) {
	$today_style = 'style="text-decoration:blink;"';
	$today_num = ' ('.$today_num.')';
	}
else $today_num='';

$query = "SELECT date_z,status FROM zakaz WHERE DATE(date_z) < CURRENT_DATE() AND status = 'Выполняется!'";
$result = mysql_query ($query);
$attention_num = mysql_num_rows($result);
if ($attention_num) {
	$attention_style = 'style="text-decoration:blink;"';
	$attention_num = ' ('.$attention_num.')';
	}
else $attention_num='';

$query = ''; //обнуляем query, ибо потом понадобится

?>
<center>
<div class='main'>
<input id='changer' type='button' value='Показать панель' onClick='changeVis()'>
<div id='canvas' style='display:none;'>
<h1>ТЕСТОВАЯ ВЕРСИЯ ПРОГРАММЫ УЧЕТА</h1>
<!-- Кнопки -->
<table><tr><td>
<form method="post" action="add.php">
<input type="submit" name="button" value="Добавить">
</form></td><td>
<form method="post" action="print_zak.php">
<input type="submit" name="button" value="Распечатать бланк заключения">
</form></td>
</td></tr></table>
<form action="./index.php">
<?php
echo "Показать данные за ";
echo "<select name='date_d'>";
for ($i=1;$i<32;$i++)
{	
	if ($i==date("j")) echo "<option selected>$i</option>";
	else echo "<option>$i</option>";
}
echo "<option></option>";
echo "</select>";
echo "<select name='date_m'>";
foreach ($months as $var_months => $var_number)
	{
	if ($var_number == date('m')) echo "<option selected value=$var_number>$var_months</option>";
	else echo "<option value=$var_number>$var_months</option>";
	}
echo "</select> ".date('Y')." года. <input type='hidden' name='date_y' value='".date('Y')."'><input type='submit' name='button' value='Показать'>
</form>";
echo "<form action=./index.php>";
echo "Показать заявки, завершающиеся ";
echo "<select name='date_d_z'>";
for ($i=1;$i<32;$i++)
{	
	if ($i==date("j")+1) echo "<option selected>$i</option>";
	else echo "<option>$i</option>";
}
echo "</select>";
echo "<select name=date_m_z>";
foreach ($months as $var_months => $var_number)
	{
	if ($var_number == date('m')) echo "<option selected value=$var_number>$var_months</option>";
	else echo "<option value=$var_number>$var_months</option>";
	}
echo "</select> ".date('Y')." года. <input type='hidden' name='date_y_z' value='".date('Y')."'><input type='submit' name='button' value='Показать'>
</form>";
echo "<form action=./index.php>";
echo "Показать заявки, завершающиеся <input type=submit value=сегодня></form>";
echo "<form action='./inc/sort.php'><input type='submit' name='button' value='Дополнительные параметры сортировки...'></form>";

echo '</div></div>';

if ($_REQUEST[view]=='today') $today_act='id="act_but"';
elseif ($_REQUEST[view]=='attention') $attention_act='id="act_but"';
else $now_act='id="act_but"';

echo "<div class='menu' name='menu'>
	<div class='but' $now_act><a href='index.php?view=now' onClick=''>Текущие заявки</a></div>
	<div class='but' $today_act><a href='index.php?view=today' $today_style onClick=''>Заявки, завершающиеся сегодня$today_num</a></div>
	<div class='but' $attention_act><a href='index.php?view=attention' $attention_style onClick=''>Просроченные заявки$attention_num</a></div>
	<div class='sps'></div>
</div>";

if ($_REQUEST[date_m]) {
$query = "select * from zakaz where date like '%$date%' and klient like '%$_REQUEST[q_klient]%' and phone like '%$_REQUEST[q_tel]%' and prinyato like '%$_REQUEST[q_get]%' and type like '%$typeofget%' and worker like '%$_REQUEST[q_slave]%' order by nomer";
$title = 'Заявки на '.$date;
}
elseif ($_REQUEST[date_m_z]) $query = "SELECT * FROM zakaz WHERE DATE(date_z) LIKE '$date_z' AND status = 'Выполняется!'";
elseif ($_REQUEST[view]=='attention') $query = "SELECT * FROM zakaz WHERE DATE(date_z) < CURRENT_DATE() AND status = 'Выполняется!'";
#elseif ($_REQUEST[view]=='attention') $query = "SELECT * FROM zakaz WHERE DATE(date_z) BETWEEN '".date('Y')."-01-01' AND CURRENT_DATE() AND status = 'Выполняется!'"; 	от 1 января сего года до сегодняшнего дня ВКЛЮЧИТЕЛЬНО!
elseif ($_REQUEST[view]=='today') $query = 'select * from zakaz where date_z like CURRENT_DATE() and status = "Выполняется!" order by nomer';
else {
$query = "select * from zakaz where date like '".date('Y-m')."%' order by nomer";
}
newPrintBase($query,$title);

function newPrintBase ($query,$title) {
#echo $query;
$result = mysql_query ($query) or die ('<div class=error>Не удалось выполнить запрос и сформировать таблицу.</div>');
if (!mysql_num_rows($result)) {
	echo '<div class=error>Нет данных</div>';
	break;
}
echo '<table class=prTable border=0><tr><td colspan=13 align=center>'.$title.'</td></tr>
<tr bgcolor=#ffcc00><th>Дата</th><th>Дата завершения</th><th>Номер</th><th>Клиент</th><th>Телефон</th><th>Принято</th><th>Проблема</th><th>Статус</th><th>Сумма</th><th>Работник</th><th>Оплачено</th></tr>';
while ($row = mysql_fetch_assoc ($result)) {
$color = 'green';
if ($row[status]=='Выполняется!') $color='red';
if ($row[status] == 'Выполнено' AND $row[oplacheno]=='Нет') $color = 'yellow';
echo "<tr align=center><td>",print_date($row['date']),"</td><td>",print_date($row['date_z']),"</td><td>",$row['nomer'],"</td><td>",$row['klient'],"</td><td>",$row['phone'],"</td><td>",$row['prinyato'],"</td><td>",$row['problem'],"</td><td bgcolor='$color'>",$row['status'],"</td><td>",$row['sum'],"</td><td>",$row['worker'],"</td><td>",$row['oplacheno'];
echo "<td valign='top'><form method=post action=edit.php><input type='hidden' name='edit' value=".$row['n']."><input type='submit' value='Редакт.'></form><form method='post' action='print.php' target='_blank'><input type='hidden' name='print' value=".$row['n']."><input type='submit' value='Печать'></form></td>";
echo "</tr>";
}
echo "</table>";
}

echo "</center>";

#echo '<form action=index.php><input type=submit name=drop value=Дропнуть базу></form>';


mysql_close ($connection);		//заканчиваем работу с мускулем
?>
</body>
</html> 
