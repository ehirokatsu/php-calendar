<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=Shift_JIS" />
<title>PHP Calendar</title>
</head>
<body>

<table border="1" cellpadding="5" cellspacing="0">
<?php


$answer = $_GET["answer"];

$date = new DateTime();
$year = $date->format('Y');
$month = $date->format('m');
$day = 1;

if($answer != 0){
	$year = $_GET["year"];
	$month = $_GET["month"];
}

//���̓���
if( $month == 2){
	if($year % 4 == 0 && $year % 100 != 0 || $year % 400 == 0 ){
		$dayMax = 29;
	}else{
		$dayMax = 28;
	}
}
else if( $month == 4 || $month == 6 || $month == 9 || $month == 11){
	$dayMax = 30;
}else{
	$dayMax = 31;
}

echo '$year='.$year.'�N<br>';
echo '$month='.$month.'��<br>';
//echo '$day='.$day.'<br>';
//echo '$dayMax='.$dayMax.'<br>';

if($month == 1){
	$month = 13;
	$year = $year - 1;
}else if($month == 2){
	$month = 14;
	$year = $year - 1;
}

//1�������j�����H
$buf1 = (floor(($month * 13 + 8) / 5) + floor($year / 4) + $year - floor($year / 100) + floor($year / 400) + $day) % 7;

//echo 'buf1='.$buf1.'<br>';


echo '<tr>';
	echo '<td>��</td>';//0
	echo '<td>��</td>';//1
	echo '<td>��</td>';//2
	echo '<td>��</td>';//3
	echo '<td>��</td>';//4
	echo '<td>��</td>';//5
	echo '<td>�y</td>';//6
echo '</tr>';

	echo '<tr>';
	for ($j = 0; $j <= 6; $j++){
		//1���܂ł̓p�f�B���O
		if($j < $buf1){
			echo '<td></td>';
		//1���ȍ~��day�����
		}else{
			echo '<td>'.$day.'</td>';
			//7���Ɨ]��0�ɂ���
			if($day == 7){
				$buf2 = 0;
			}else{
				$buf2 = $day;
			}
			$day = $day + 1;
			
		}
	}
	echo '</tr>';
	
	for (; $day+7 <= $dayMax+1;){
		echo '<tr>';
		for ($j = 0; $j <= 6; $j++){
			//
			if($day%7 != $buf2){
				echo '<td>'.$day.'</td>';
				$day = $day + 1;
			}else{
				echo '<td>'.$day.'</td>';
			}
		}
		echo '</tr>';
		$day = $day + 1;
	}
	if($day < $dayMax){
		echo '<tr>';
		for ($j = 0; $j <= 6; $j++){
			//�����܂�
			if($day <= $dayMax){
				echo '<td>'.$day.'</td>';
				$day = $day + 1;
			//�����ȍ~���p�f�B���O
			}else{
				echo '<td></td>';
			}
		}
		echo '</tr>';
	}
	

if($month == 13){
	$month = 1;
	$year = $year + 1;
}else if($month == 14){
	$month = 2;
	$year = $year + 1;
}

echo '</table>';

//�O��
echo '<form name="before" method="GET" action="cal.php">';
$monthBefore = $month -1;
$yearBefore = $year;
if($monthBefore ==0){
	$monthBefore =12;
	$yearBefore = $year - 1;
}
echo 'yearBefore='.$yearBefore.'<br>';
echo 'monthBefore='.$monthBefore.'<br>';
echo '<input type="hidden" name="year" value="'.$yearBefore.'">';
echo '<input type="hidden" name="month" value="'.$monthBefore.'">';
echo '<input type="hidden" name="answer" value="1">';
echo '<input type="submit" value="before">';
echo '</form>';

//����
echo '<form name="now" method="GET" action="cal.php">';
echo '<input type="hidden" name="answer" value="0">';
echo '<input type="submit" value="now">';
echo '</form>';

//����
echo '<form name="after" method="GET" action="cal.php">';
$monthAfter = $month +1;
$yearAfter = $year;
if($monthAfter==13){
	$monthAfter=1;
	$yearAfter = $year + 1;
}
echo 'yearAfter='.$yearAfter.'<br>';
echo 'monthAfter='.$monthAfter.'<br>';
echo '<input type="hidden" name="year" value="'.$yearAfter.'">';
echo '<input type="hidden" name="month" value="'.$monthAfter.'">';
echo '<input type="hidden" name="answer" value="1">';
echo '<input type="submit" value="after">';
echo '</form>';
?>


</p>
</body>
</html>