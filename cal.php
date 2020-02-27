<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>PHP Calendar</title>
<style>
.center {
	text-align: center;
	margin-left: auto;
	margin-right: auto;
}
</style>
</head>
<body>

<?php

//今月の情報を取得
$date = new DateTime();


//GETパラメータのチェック
//年は1582以降の4桁数値（後に使用するツェラーの公式では1582年以降が対象の為。）
//月は1～12までの数値
if (preg_match('/^[0-9]{4}+$/', $_GET["year"]) && $_GET["year"] > 1582 && preg_match('/^[1-9]{1}?[0-2]*?$/', $_GET["month"])) {
	$year = (int)$_GET["year"];
	$month = (int)$_GET["month"];
//上記以外の場合は今月のカレンダーを表示する
}else{
	$year = (int)$date->format('Y');
	$month = (int)$date->format('n');
}

$day = 1;

//表示するカレンダーの年月を表示
echo '<div class="center">'.$year.'年'.$month.'月</div><br>';

//月の日数を判定
if( $month == 2){
	//閏年
	if($year % 4 == 0 && $year % 100 != 0 || $year % 400 == 0 ){
		$dayMax = 29;
	//閏年以外
	}else{
		$dayMax = 28;
	}
}else if( $month == 4 || $month == 6 || $month == 9 || $month == 11){
	$dayMax = 30;
}else{
	$dayMax = 31;
}

//1日が何曜日になるのかを判定する（ツェラーの公式を使用する。1582年以降が対象。）
//1月は前年の13月にする
if($month == 1){
	$month = 13;
	$year = $year - 1;
//2月は前年の14月にする
}else if($month == 2){
	$month = 14;
	$year = $year - 1;
}
//buf1は、「日：0, 月：1, 火：2, 水：3, 木：4, 金：5, 土：6 」になる
$buf1 = (floor(($month * 13 + 8) / 5) + floor($year / 4) + $year - floor($year / 100) + floor($year / 400) + $day) % 7;

echo '<table border="1" cellpadding="5" cellspacing="0" align="center">';
	//カレンダーを表示
	echo '<tr>';
		echo '<td align="center" bgcolor="#eeeeee">日</td>';
		echo '<td align="center" bgcolor="#eeeeee">月</td>';
		echo '<td align="center" bgcolor="#eeeeee">火</td>';
		echo '<td align="center" bgcolor="#eeeeee">水</td>';
		echo '<td align="center" bgcolor="#eeeeee">木</td>';
		echo '<td align="center" bgcolor="#eeeeee">金</td>';
		echo '<td align="center" bgcolor="#eeeeee">土</td>';
	echo '</tr>';

	echo '<tr>';
	//カレンダー1行目の出力
	for ($j = 0; $j <= 6; $j++){
		//1日まではパディング
		if($j < $buf1){
			echo '<td></td>';
		//1日以降のdayを入力
		}else{
			echo '<td align="center">'.$day.'</td>';
			$day = $day + 1;
		}
	}
	echo '</tr>';
	//カレンダー2行目以降の出力
	for (; $day+7 <= $dayMax+1;){
		echo '<tr>';
		for ($j = 0; $j <= 6; $j++){
			echo '<td align="center">'.$day.'</td>';
			$day = $day + 1;
		}
		echo '</tr>';
	}
	//最終日以降パディングが必要なら出力
	if($day < $dayMax+1){
		echo '<tr>';
		for ($j = 0; $j <= 6; $j++){
			//月末まで
			if($day <= $dayMax){
				echo '<td align="center">'.$day.'</td>';
				$day = $day + 1;
			//月末以降をパディング
			}else{
				echo '<td></td>';
			}
		}
		echo '</tr>';
	}
echo '</table>';

//ツェラーの公式で使用した1月、2月を元に戻す
if($month == 13){
	$month = 1;
	$year = $year + 1;
}else if($month == 14){
	$month = 2;
	$year = $year + 1;
}
?>
<br>

echo '<div class="center">';
	//今月ボタン
	echo '<form name="now" method="GET" action="cal.php">';
	echo '<input type="submit" value="今月">';
	echo '</form>';
echo '</div><br>';

echo '<table align="center">';
	echo '<tr>';
		echo '<td>';
			//前月ボタン
			echo '<form name="before" method="GET" action="cal.php">';
			$monthBefore = $month -1;
			$yearBefore = $year;
			//前月が0月になると、年を1年戻して12月にする
			if($monthBefore ==0){
				$monthBefore =12;
				$yearBefore = $year - 1;
			}
			echo '<input type="hidden" name="year" value="'.$yearBefore.'">';
			echo '<input type="hidden" name="month" value="'.$monthBefore.'">';
			echo '<input type="submit" value="前月">';
			echo '</form>';
		echo '</td>';
		
		echo '<td></td>';
		
		echo '<td>';
			//来月ボタン
			echo '<form name="after" method="GET" action="cal.php">';
			$monthAfter = $month +1;
			$yearAfter = $year;
			//来月が13月になると、年を1年上げて1月にする
			if($monthAfter==13){
				$monthAfter=1;
				$yearAfter = $year + 1;
			}
			echo '<input type="hidden" name="year" value="'.$yearAfter.'">';
			echo '<input type="hidden" name="month" value="'.$monthAfter.'">';
			echo '<input type="submit" value="来月">';
			echo '</form>';
		echo '</td>';
	echo '</tr>';
echo '</table>';




</p>
</body>
</html>