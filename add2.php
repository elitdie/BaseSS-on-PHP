<?php
require "./inc/head.php";
require "./inc/connect.php";
echo "<body><center>";
require './inc/massive.php';
require ('./inc/func.php');

#var_dump($_REQUEST);

$f = 0;
foreach ($type as $var_type => $var_value)
{
	if ($_REQUEST[$var_type]) $f = 2;
}
if ($_REQUEST['sum'] == '' AND $_REQUEST['oplacheno'] == 'Да') $f = 1;
if ($f == 0 or $f == 1) adderror();
else add_to_base();

function add_to_base()
{
global $type;
global $months;
$oplacheno='Нет';
if ($_REQUEST['oplacheno']) $oplacheno=$_REQUEST['oplacheno'];

foreach ($type as $var_type => $var_value)
	{
	if ($_REQUEST[$var_type]) $type_var.=$_REQUEST[$var_type].",";
	}

$date = $_REQUEST[date_y].'-'.$_REQUEST[date_m].'-'.$_REQUEST[date_d];
$date_z = $_REQUEST[date_y_z].'-'.$_REQUEST[date_m_z].'-'.$_REQUEST[date_d_z];

include "./inc/connect.php";

//а вот тут запрос к мускулю, основанный на данных, введенных в форме add.php

$query = "INSERT INTO zakaz VALUES ('".$_SESSION['counter']."', '".$_REQUEST['nomer']."', '".$date."', '".$date_z."', '".$_REQUEST['klient']."', '".$_REQUEST['phone']."', '".$_REQUEST['prinyato']."', '".$_REQUEST['problem']."', 'Выполняется!', '".$_REQUEST['sum']."', '".$_REQUEST['worker']."', '".$oplacheno."', '".$type_var."', '', '')";

#echo $query;

//если запрос добавления данных прошел успешно, выводим сообщение:
if (mysql_query($query) == true) echo "<div class=succ>Добавление заявки выполнено успешно</div>";
else die ("Ошибка при внесении изменений. Подробнее: ".mysql_error ());		//иначе ошибка

$query = "update env set counter='".++$_SESSION['counter']."', nomer='".++$_SESSION['nomer']."'";
$result = mysql_query ($query)
	or die ("Ошибка при обновлении переменых в базе: ".mysql_error ());
mysql_close ($connection);						//заканчиваем работу с мускулем
}

function adderror()
{
echo '<div class=error>';
global $type;
global $months;
global $f;
foreach ($type as $var_type => $var_value)
	{
	if ($_REQUEST[$var_type]) $type_var.=$_REQUEST[$var_type].",";
	}
if ($f == 1) echo "<font size=+5>Нельзя оплатить услуги без указания суммы!<br>";
if ($f == 0) echo "<font size=+5>Не указан ни один тип заявки!<br>";
echo "<form action='./add.php'>
<input type='hidden' name='nomer' value=".$_REQUEST['nomer'].">
<input type='hidden' name='date_d' value=".$_REQUEST['date_d'].">
<input type='hidden' name='date_m' value=".$_REQUEST['date_m'].">
<input type='hidden' name='date_y' value=".$_REQUEST['date_y'].">
<input type='hidden' name='date_d' value=".$_REQUEST['date_d_z'].">
<input type='hidden' name='date_m' value=".$_REQUEST['date_m_z'].">
<input type='hidden' name='date_y' value=".$_REQUEST['date_y_z'].">
<input type='hidden' name='klient' value=".$_REQUEST['klient'].">
<input type='hidden' name='phone' value=".$_REQUEST['phone'].">";
echo "<input type='hidden' name='prinyato' value=".$_REQUEST['prinyato'].">
<input type='hidden' name='problem' value=".$_REQUEST['problem'].">";
echo "<input type='hidden' name='sum' value=".$_REQUEST['sum'].">
<input type='hidden' name='worker' value=".$_REQUEST['worker'].">
<input type='hidden' name='oplacheno' value=".$_REQUEST['oplacheno'].">
<input type='hidden' name='type' value=".$type_var.">
<br><input type='submit' value='Исправить'></form>";
echo '</div>';
die;
}
?>
<center><input type=button value='В базу' onclick='location.href="index.php"'></center>
</body>
</html> 
