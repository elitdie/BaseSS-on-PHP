<?php
include "./inc/head.php";
echo "<body><center>";
include "./inc/connect.php";
include "./inc/massive.php";
$query = "SELECT * FROM zakaz WHERE n='".$_REQUEST['edit']."' limit 1";		//достаем все из базы, что нужно менять
$result = mysql_query ($query)
or die ("Ошибка выгрузки значений из базы:".mysql_error ());
$row = mysql_fetch_array ($result);
$_SESSION['counter_edit']=$_REQUEST['edit'];
echo "<h1>ТЕСТОВАЯ ВЕРСИЯ ПРОГРАММЫ УЧЕТА</h1>";
echo "<h2>Форма редактирования заказа:</h2>";
# Создание основной формы
echo "<form action='edit2.php'>";
echo "<table width=800><tr><td>Номер заявки:</td>";
echo "<td><input type='text' name='date' value='".$row['nomer']."'></td></tr>";
print_date('','');
print_date(' завершения','_z');
echo "</select></td></tr>";
echo "<tr><td>Клиент:</td>";
echo "<td><input type='text' name='klient' value='".$row['klient']."'></td></tr>";
echo "<tr><td>Телефон:</td>";
echo "<td><input type='text' name='phone' value='".$row['phone']."'></td></tr>";
echo "<tr><td>Принято:</td>";
echo "<td><textarea name='prinyato' cols='50' rows='4'>".$row['prinyato']."</textarea></td></tr>";
echo "<tr><td>Проблема:</td>";
echo "<td><textarea name='problem' cols='50' rows='4'>".$row['problem']."</textarea></td></tr>";
echo "<tr><td>Сумма:</td>";
echo "<td><input type='text' name='sum' value='".$row['sum']."'></td></tr>";
echo "<tr><td>Работник:</td>";
echo "<td><select name='worker'>";
foreach ($workers as $slave)
{
if ($slave==$row['worker']) echo "<option selected>$slave</option>";
else echo "<option>$slave</option>";
}
echo "</select></td></tr>";

#echo "<tr><td>Выполнено?</td>";
#if ($row[status] == 'Выполнено') $checked = 'checked';
#echo "<td><input type='checkbox' $checked name='status' value='Выполнено' onChange=checkErr(this.name)></td></tr>";

#echo "<tr><td>Оплачено?</td>";
#if ($row[oplacheno] == 'Нет') $checked = '';
#echo "<td><input type='checkbox' $checked name='oplacheno' value='Да' onChange=checkErr(this.name)></td></tr>";

$checked = '';
echo "<tr><td>Статус заявки</td>";
echo "<td><label><input type='radio' checked name='status' value='Выполняется!'>В работе</label><br>";
if ($row[status]=='Выполнено') $checked = 'checked';
echo "<label><input type='radio' $checked name='status' value='Выполнено'>Выполнено</label><br>";
if ($row[oplacheno]!=='Да') $checked = '';
echo "<label><input type='radio' $checked name='status' value='Выполнено и оплачено'>Выполнено и оплачено</label>";
echo "</td></tr>";

echo "<tr><td>Затраченные материалы:</td>";
echo "<td><input type='text' name='mat' value='$row[materials]'></td></tr>";

echo "<tr><td>Комментарий:</td>";
#echo "<td><input type='text' name='comment' value='$row[comment]'></td></tr>";
echo "<td><textarea name='comment' cols='50' rows='4'>$row[comment]</textarea></td></tr>";

include "./inc/massive.php";
echo "<tr><td colspan=2><table><tr>";
$array=explode(",",$row['type']);

for ($i=0;$i<sizeof($type);$i++)	//от 0 до конца массива с шагом 1
{
	$f=0;
	list($var_type,$var_label)=each($type); //берем один элемент массива
	if ($i==5 or $i==10) echo "</tr><tr>";	//если элемент 5 или 10 то переносим строку
	foreach ($array as $k)		//массив с нужным условием
		{
		if ($var_label==$k) {
		echo "<td><input type='checkbox' checked name='$var_type' value='$var_label' id='$var_type'><label for='$var_type'>$var_label</label></td>";//если условие выполняется, отмечаем чекбокс
		$f=1;}
		}
	if ($f==0) echo "<td><input type='checkbox' name='$var_type' value='$var_label' id='$var_type'><label for='$var_type'>$var_label</label></td>";
	next;
}

echo "</tr></table>";

#echo '<select name=w_cats onChange=printElem(this.value)><option value="" selected=1>Выберите категорию...</option>';
#$query = mysql_query('select name,value from w_cats');
#while ($row = mysql_fetch_assoc($query)) echo "<option value='$row[value]'>$row[name]</option>";
#echo '</select>';

echo '<div id=printer></div>
<div id=works_canvas><table id=works></table></form></div>';

echo "<tr><td><input type='submit' value='Изменить заявку'></td><td align=right><input type='reset' value='Вернуть как было'</tr>";
echo "</table></form>";
echo "<form method='post' action='index.php'><input type='submit' value='Назад'></form>";

?>
<script type='text/javascript'>

function printElem(value) {
var changer = document.getElementById('printer') 
var req = new XMLHttpRequest() 
req.onreadystatechange = function() { 
	if (req.readyState == 4) {
		if(req.status == 200) {
		changer.style.display = 'block'
		changer.innerHTML = req.responseText }
	}
}
req.open('GET', 'proc.php?elems='+value, true)
req.send(null)
}

function addWork(id) {
var req = new XMLHttpRequest() 
req.onreadystatechange = function() { 
	if (req.readyState == 4) {
		if(req.status == 200) {
		document.getElementsByName('status').disabled = !document.getElementsByName('status').disabled
		document.getElementById('works_canvas').style.display = 'block'
		document.getElementById('works').innerHTML = document.getElementById('works').innerHTML+req.responseText }
	}
}
req.open('GET', 'proc.php?work='+id, true)
req.send(null)
}

function checkErr(el) {
//if (document.getElementById('works').innerHTML == '') alert('Не указаны работы! Без списка работ невозможно вычислить сумму заявки и пометить ее как выполненную.')
//document.getElementsByName(el).checked = 0;
}
</script>

<?php
mysql_close ($connection);			//заканчиваем работу с мускулем

function print_date($char,$z)
{
global $months;
global $row;
$date = explode("-",$row["date$z"]);
echo "<tr><td>";
echo "Дата$char:</td>";
echo "<td><select name=date_d$z>";
for ($i=1;$i<32;$i++)
{	
	if ($i==$date[2] or $i==$_REQUEST['date_d']) echo "<option selected>$i</option>";
	else echo "<option>$i</option>";
}
echo "</select>";
echo "<select name=date_m$z>";
foreach ($months as $var_months => $var_number)
{
	if ($var_number == $date[1] or $var_number==$_REQUEST['date_m']) echo "<option selected value=$var_number>$var_months</option>";
	else echo "<option value=$var_number>$var_months</option>";
}
echo "</select>";
echo "<select name=date_y$z>";
for ($i=2009;$i<=date("Y");$i++)
{	if ($i==$date[0] or $i==$_REQUEST['date_y']) echo "<option selected>$i</option>";
	else echo "<option>$i</option>";
}
echo "</select></td></tr>";
}
?>
</body>
</html>
