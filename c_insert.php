﻿<?php

$dsn = "mysql:dbname=probc;host=localhost";
$next = "v_{$_POST["type"]}_reg.php";

$my = new PDO($dsn, 'probc', 'probc');
if($_POST["type"] == "applicant"){
  if(isset($_POST["p1"],$_POST["p2"],$_POST["p3"])){
    $sql = "INSERT INTO 申請者 (職員番号,氏名,所属) VALUES (?,?,?);";
    $arr = array($_POST["p1"],$_POST["p2"],$_POST["p3"]);
    $stmt = $my->prepare($sql);
    $stmt->execute($arr);
  }
}else if($_POST["type"] == "student"){
  if(isset($_POST["p1"],$_POST["p2"],$_POST["p3"])){
    $sql = "INSERT INTO 学生 (学籍番号,氏名,給与振り込み口座) VALUES (?,?,?);";
    $arr = array($_POST["p1"],$_POST["p2"],$_POST["p3"]);
    $stmt = $my->prepare($sql);
    $stmt->execute($arr);
  }
}else if($_POST["type"] == "employment"){
  if(isset($_POST["event_id"],$_POST["student"])){
    $sql = "INSERT INTO 雇用 (イベントID,学籍番号) VALUES (?,?);";
    $arr = array($_POST["event_id"],$_POST["student"]);
    $stmt = $my->prepare($sql);
    $stmt->execute($arr);
    $next = "v_event_detail.php?id={$_POST["event_id"]}";
  }
}else if($_POST["type"] == "work"){
  if(isset($_POST["employment_id"],$_POST["p1"],$_POST["p2"],$_POST["p3"],$_POST["p4"])){
    $sql = "INSERT INTO 勤務記録 (雇用ID,勤務日,開始時刻,終了時刻,休憩時間) VALUES (?,?,?,?,?);";
    $arr = array($_POST["employment_id"],$_POST["p1"],$_POST["p2"],$_POST["p3"],$_POST["p4"]);
    $stmt = $my->prepare($sql);
    $stmt->execute($arr);
    $next = "c_calc_ttime.php?id={$_POST["event_id"]}&no={$_POST["stno"]}";
  }
}else if($_POST["type"] == "event"){
  if(isset($_POST["p1"],$_POST["p2"],$_POST["p3"],$_POST["p4"],$_POST["p5"],$_POST["p6"])){
    $sql = "INSERT INTO イベント (雇用申請者ID,イベント名,業務内容,勤務開始年月日,勤務終了年月日,予定勤務時間,時給,処理フラグ) VALUES (?,?,?,?,?,?,?,0);";
    $arr = array($_POST["applicant"],$_POST["p1"],$_POST["p2"],$_POST["p3"],$_POST["p4"],$_POST["p5"],$_POST["p6"]);
    $stmt = $my->prepare($sql);
    $stmt->execute($arr);
    $next = "v_event_list.php?flow=1";
  }
}

header("location:{$next}")
?>
