<?php
include "./inc/head.php";
include "./inc/massive.php";

echo "<body><center>";
echo "<h1>ТЕСТОВАЯ ВЕРСИЯ ПРОГРАММЫ УЧЕТА</h1>";
echo "<h2>Форма добавления заказа:</h2>";
#Создание основной формы
echo "<form action='add2.php'>";
echo "<table width=800>";
echo "<tr><td>";
echo "Номер заявки: </td>";
if ($_REQUEST['nomer']) echo "<td><input type='text' name='nomer' value='".$_REQUEST['nomer']."'></td></tr>";
else echo "<td><input type='text' name='nomer' value='".$_SESSION['nomer']."'></td></tr>";
calendar(0,'','');
calendar(1,' завершения','_z');
echo "<tr><td>Клиент:</td>";
echo "<td><input type='text' name='klient' value=".$_REQUEST['klient']."></td></tr>";
echo "<tr><td>Телефон:</td>";
echo "<td><input type='text' name='phone' value=".$_REQUEST['phone']."></td></tr>";
echo "<tr><td>Принято:</td>";
echo "<td><textarea name='prinyato' cols='50' rows='4'>".$_REQUEST['prinyato']."</textarea></td></tr>";
echo "<tr><td>Проблема:</td>";
echo "<td><textarea name='problem' cols='50' rows='4'>".$_REQUEST['problem']."</textarea></td></tr>";
echo "<tr><td>Сумма:</td>";
echo "<td><input type='text' name='sum' value=".$_REQUEST['sum']."></td></tr>";
echo "<tr><td>Работник:</td>";
echo "<td><select name='worker'>";
if ($_REQUEST['worker'])
{
foreach ($workers as $slave)
{
	if ($slave == $_REQUEST['worker']) echo "<option selected>$slave</option>";
	else echo "<option>$slave</option>";
}
}
else {
foreach ($workers as $slave)
{
	if ($slave == '') echo "<option selected>$slave</option>";
	else echo "<option>$slave</option>";
}
}
echo "</select>";
echo "</td></tr><tr><td>Оплачено заранее?</td>";
if ($_REQUEST['oplacheno'] == "Да") echo "<td><input type='checkbox' checked name='oplacheno' value='Да'></td></tr>";
else echo "<td><input type='checkbox' name='oplacheno' value='Да'></td></tr>";
echo "<tr><td colspan=2>Тип:</td>";
echo "<tr><td colspan=2><table><tr>";

$array=explode(",",$_REQUEST['type']);
for ($i=0;$i<sizeof($type);$i++)	//от 0 до конца массива с шагом 1
{
	$f=0;
	list($var_type,$var_label)=each($type); //берем один элемент массива
	if ($i==5 or $i==10) echo "</tr><tr>";	//если элемент 5 или 10 то переносим строку
	foreach ($array as $k)		//массив с нужным условием
		{
		if ($var_label==$k) {
		echo "<td><label><input type='checkbox' checked name='$var_type' value='$var_label'>$var_label</label></td>";//если условие выполняется, отмечаем чекбокс
		$f=1;}
		}
	if ($f==0) echo "<td><label><input type='checkbox' name='$var_type' value='$var_label'>$var_label</label></td>";
	next;
}
echo "</tr></table></td></tr>";
echo "<tr><td colspan=2><br></td></tr>";
echo "<tr><td><input type='submit' value='Добавить в базу'></td><td align=right><input type='reset' value='Очистить поля'></td></tr>";

function calendar($f,$char,$z)
{
global $months;
echo "<tr><td>";
echo "Дата$char:</td>";
echo "<td><select name=date_d$z>";
for ($i=1;$i<32;$i++)
{	
	if ($i==date("j")+$f or $i==$_REQUEST['date_d']+$f) echo "<option selected>$i</option>";
	else echo "<option>$i</option>";
}
echo "</select>";
echo "<select name=date_m$z>";
foreach ($months as $var_months => $var_number)
{
	if ($var_number == date('m') or $var_number==$_REQUEST['date_m']) echo "<option selected value=$var_number>$var_months</option>";
	else echo "<option value=$var_number>$var_months</option>";
}
echo "</select>";
echo "<select name=date_y$z>";
for ($i=2009;$i<=date("Y");$i++)
{	if ($i==date("Y") or $i==$_REQUEST['date_y']) echo "<option selected>$i</option>";
	else echo "<option>$i</option>";
}
echo "</select></td></tr>";
}
?>
</table>
</form>
<form method='post' action='index.php'><input type='submit' value='Назад'></form>
</body>
</html> 
