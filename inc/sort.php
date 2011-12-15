<html>
<head></head><meta http-equiv="Content-Type" content="text/html; charset=utf8"><body>
<form action='../index.php'>
<h1>Задайте параметры сортировки:</h1>
<table>
<?php
include "./massive.php";
echo "Дата: ";
echo "<select name=date_m>";
foreach ($months as $var_months => $var_number)
{
	if ($var_number == date('m')) echo "<option selected value=$var_number>$var_months</option>";
	else echo "<option value=$var_number>$var_months</option>";
}
echo "</select>";
echo "<select name=date_y>";
for ($i=2009;$i<=date("Y");$i++)
{	if ($i==date("Y")) echo "<option selected>$i</option>";
	else echo "<option>$i</option>";
}
echo "<option></option>";
echo "</select><br>";
echo "Клиент: <input type='text' name='q_klient'><br>";
echo "Телефон: <input type='text' name='q_tel'><br>";
echo "Принято: <input type='text' name='q_get'><br>";

echo "Работник: <input type='text' name='q_slave'><br>";

echo "Тип:<table width=700><tr>";
for ($i=0;$i<sizeof($type);$i++)
{
	$f=0;
	list($var_type,$var_label)=each($type);
	if ($i==5 or $i==10) echo "</tr><tr>";
	echo "<td><input type='checkbox' name='$var_type' value='$var_label'>$var_label</td>";
	next;
}

echo "</tr></table>";
echo '<select multiple="multiple" name=typeofget[]>';
foreach ($type as $type => $var_type) { echo "<option value='$type'>$var_type</option>";}
echo '</select>';
echo "<input type='submit' name='button' value='Сортировать'>";
?>
</form>
</body> 
