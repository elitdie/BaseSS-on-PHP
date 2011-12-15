<?php
require "./inc/head.php";
require "./inc/connect.php";
#var_dump($_REQUEST);
if ($_REQUEST['sum'] == '' AND $_REQUEST['status'] == 'Выполнено и оплачено')
{
echo '<div class=error>';
echo "Присвоение статуса 'Выполнено и оплачено' невозможно без указания суммы!";
echo "<form method=post action=./edit.php><input type='hidden' value=".$_SESSION['counter_edit']." name='edit'>
<input type='submit' value='Исправить'></form>";
echo '</div>';
}
else {
include "./inc/connect.php";

include "./inc/massive.php";

foreach ($type as $var_type => $var_value)
	{
	if (isset($_REQUEST[$var_type]))
		{
		$type_var.=$_REQUEST[$var_type].",";
		}
	}
foreach ($months as $var_months => $var_number)
	{
	if ($var_months == $_REQUEST['date_m']) $date_m = $var_number;
	if ($var_months == $_REQUEST['date_m_z']) $date_m_z = $var_number;
	}

$date = $_REQUEST['date_y']."-".$_REQUEST['date_m']."-".$_REQUEST['date_d'];
$date_z = $_REQUEST['date_y_z']."-".$_REQUEST['date_m_z']."-".$_REQUEST['date_d_z'];

#if($_REQUEST[addWorks]) {
#	foreach ($_REQUEST[addWorks] as $k) $works.=$k.'-';
#	foreach ($_REQUEST[costWorks] as $k) $cost+=$k;
#}

$oplacheno = 'Нет';
if ($_REQUEST['status'] == 'Выполнено и оплачено') {
    $status = 'Выполнено';
    $oplacheno = 'Да';
}
else $status = $_REQUEST['status'];

//а вот тут запрос к мускулю, основанный на данных, введенных в форме edit.php
$query = "UPDATE zakaz SET date='".$date."', date_z='".$date_z."', klient='".$_REQUEST['klient']."', phone='".$_REQUEST['phone']."', problem='".$_REQUEST['problem']."', prinyato='".$_REQUEST['prinyato']."', sum='".$_REQUEST[sum]."', worker='".$_REQUEST['worker']."', status='".$status."', type='$type_var', materials='".$_REQUEST['mat']."', oplacheno='".$oplacheno."', comment='".$_REQUEST['comment']."'  WHERE n='".$_SESSION['counter_edit']."'";

#echo $query;

//если все прошло удачно, выводим сообщение
if (mysql_query($query) == true) echo "<div class=succ>Изменения внесены успешно</div>";
else die ("<div class=error>Ошибка при внесении изменений. Подробнее: ".mysql_error ()."</div>");	//иначе ошибку
mysql_close ($connection);				//заканчиваем работу с мускулем
}
?>
<center><input type=button value='В базу' onclick='location.href="index.php"'></center>
</body>
</html> 
