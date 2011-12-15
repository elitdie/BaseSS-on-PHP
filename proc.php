<?php
require './inc/connect.php';
#var_dump($_REQUEST);

if ($_REQUEST[elems]) {
	$query = mysql_query("select * from works where cat like '$_REQUEST[elems]'");
	echo '<table><tr><th>Название</th><th>Описание</th><th>Стоимость</th><th></th></tr>';
	while ($row = mysql_fetch_assoc($query)) {
		echo "<tr><td>$row[name]</td><td>$row[descr]</td><td>$row[cost] рублей</td><td><input type=button value=Добавить name='$row[id]' onClick='addWork(this.name)'></td></tr>";
		}
	}

if ($_REQUEST[work]) {
	$query = mysql_query("select * from works where id like '$_REQUEST[work]'");
	while ($row = mysql_fetch_assoc($query)) {
		echo "<tr><td>$row[name]</td><td>$row[cost]</td><td><input type=button value=Удалить name='$row[id]' onClick='delWork(this.name)'><input type=hidden value=$row[id] name=addWorks[]><input type=hidden value=$row[cost] name=costWorks[]></td></tr>";
		}
}
?>
