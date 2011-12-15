<html>
<head>
<title>ПЕЧАТЬ БЛАНКА ЗАКАЗА</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel=stylesheet type=text/css href=./print.css>
</head>
<body>
<?php
include "./inc/connect.php";
require "./inc/func.php";

//загон информации из таблицы БД в массив

$query = "SELECT nomer,date,klient,phone,prinyato,problem,sum,oplacheno FROM zakaz WHERE n='$_REQUEST[print]'";
$result = mysql_query ($query);
$row = mysql_fetch_array ($result);

//формирование  таблицы

//отрывной квиток
echo "<div class=klient><b>ОТРЫВНОЙ КВИТОК К БЛАНКУ № $row[nomer]</b>
<img src=logo.png>
<br><br><b>Клиент:</b> $row[klient]
<br><br><b>Дата:</b> ".print_date($row[date]);
echo "<br><br><b>Подпись принимающего:</b>____________________/_____________________/
<br><br>
<b>Оборудование, сданное в сервис-центр:</b> $row[prinyato]<br><br><br><br>
&#8195&#8195&#8195М.П.
<br><br><br><br><br>
<p class=phone>Телефон: (3952) 24-00-23, 242-700</p><br><br>";
echo 'Внимание! Техника, находящаяся в ремонте, выдаётся ТОЛЬКО при наличии данного квитка. В случае утери отрывного квитка техника выдается при наличии паспорта и уплате штрафа в размере 50 рублей. Срок хранения ремонтируемой техники в Компьютерном Сервис-Центре "ЭЛПРИС", филиал С1, составляет 3 суток (после оповещения клиента о готовности заказа). За каждые сутки свыше срока хранения взымается штраф в размере 50 рублей.';

echo "</div>";

//наша часть
echo '<div class=our>';
echo "<center><b>АКТ ПРИЕМА ТЕХНИКИ В РЕМОНТ № $row[nomer]</b></center>";
echo "<br><b>Клиент:</b> $row[klient]
<br><br><b>Контакты:</b> $row[phone]
<br><br><b>Дата:</b> ".print_date($row[date]);
echo "<br><br><b>Проблема со слов клиента:</b><br>
$row[problem]
<br><br><b>Принятое оборудование:</b><br>
$row[prinyato]
<br><br>";
if ($row[oplacheno]=='Да') echo "Предоплата: <i>$row[sum] рублей</i>";
echo "<br><br>
Технику сдал:_____________________________/$row[klient]/
<br><br>
С условиями приема ознакомлен:_______________________________/$row[klient]/
<br><br>
Претензий по работам не имею:________________________________/$row[klient]/
</div>";

mysql_close ($connection);		//заканчиваем работу с мускулем
?>
</body>
</html>  
