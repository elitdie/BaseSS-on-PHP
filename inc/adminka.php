<?php
echo "<form method='post' action='./adminka.php'>
<input type=submit name=dump value='Сделать дамп базы'>
<input type=submit name=load value='Загрузить последний дамп'></form>
<form method='post' action='../index.php'>
<input type=submit name=dump value='Назад'>
</form>";
if ($_REQUEST['dump']) exec('mysqldump --user=base --password=375555 baseBFC > /var/www/localhost/htdocs/new_base/sqldump');
if ($_REQUEST['load']) exec('mysql --user=base --password=375555 < /var/www/localhost/htdocs/new_base/sqldump');
echo $_REQUEST['dump'];
echo $_REQUEST['load'];
?> 
