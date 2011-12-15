<?php

function print_date($date) {
$var = explode('-', $date);
$date = $var[2].'.'.$var[1].'.'.$var[0];
return $date;
}

function ConvertDate2SQL ($date,$arg) {
$var = explode('.', $date);
$date = $var[0].'-'.$var[1].'-'.$var[2]+$arg;
return $date;
}

function date_m() {
	$months = array('января'=>'01','февраля'=>'02','марта'=>'03','апреля'=>'04','мая'=>'05','июня'=>'06','июля'=>'07','августа'=>'08','сентября'=>'09','октября'=>'10','ноября'=>'11','декабря'=>'12',''=>'__');
	foreach ($months as $var_months => $var_number)	{
		if ($var_number == date('m') or $var_number == $_REQUEST['date_m']) echo "<option selected>$var_months</option>";
		else echo "<option>$var_months</option>";
	}
}

?>
