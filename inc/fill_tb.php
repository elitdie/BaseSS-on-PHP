<?php
#require 'connect.php';
mysql_query('drop tables w_cats,works');
echo 'База дропнута успешно!';
mysql_query("create table w_cats (name varchar(50) NOT NULL, cat varchar(50), value varchar(50) not null PRIMARY KEY)");
mysql_query("insert into w_cats values ('Диагностика', '', 'diag')");
mysql_query("insert into w_cats values ('Аппаратный ремонт', '', 'a_repair')");
mysql_query("insert into w_cats values ('Программный ремонт', '', 'p_repair')");
mysql_query("insert into w_cats values ('Выезд', '', 'goto')");

mysql_query("create table works (name varchar(100), cat varchar(50), descr varchar(150), cost int, id int not null auto_increment primary key)");
mysql_query("insert into works values ('Диагностика ноутбука', 'diag', 'Аппаратная диагностика ноутбука', '300', '')");
mysql_query("insert into works values ('Диагностика жесткого диска', 'diag', 'Проверка жесткого диска на запуск и наличие бэд-блоков', '150', '')");
mysql_query("insert into works values ('Аппаратная чистка и профилактика ноутбука', 'a_repair', 'Удаление пыли, замена термоинтерфейса, замена смазывающего материала', '450', '')");
mysql_query("insert into works values ('Ремонт блока питания', 'a_repair', 'Перепайка конденсаторов', '500', '')");
mysql_query("insert into works values ('Установка драйверов на устройства', 'p_repair', 'Скачивание драйвера на устройство из сети Интернет', '150', '')");
mysql_query("insert into works values ('Установка ОС Gentoo Linux', 'p_repair', 'Установка', '1500', '')");
mysql_query("insert into works values ('Выезд днем', 'goto', 'Выезд с 10 до 19 часов', '200', '')");
mysql_query("insert into works values ('Выезд вечером', 'goto', 'Выезд с 19 до 22 часов', '250', '')");
mysql_query("insert into works values ('Выезд рядом', 'goto', 'Выезд в пределах Свердлова, Поленова', '100', '')");

echo 'Таблицы созданы и заполнены!';
?>
