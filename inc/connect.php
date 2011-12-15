<?php
$connection = mysql_connect ("localhost", "base_temp", "375555")
	or die ("Не установлено соединение с базой данных (MySQL)");
$db = mysql_select_db ("base_temp", $connection)
	or die ("Ошибка при выборе базы данных. Подробнее: ".mysql_error ());
mysql_query('set names utf8');
?>
