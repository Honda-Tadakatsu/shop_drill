<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>会員登録画面</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>

	<?php require 'menu.php'; ?>
	<?php
	//MySQLDBに接続
	require 'db_connect.php';
	//SQL文を作成
	$sql = "INSERT into customer values(null,:name,:address,:login,:password)";
	//プリペアードステートメントを作成
	$stm = $pdo -> prepare($sql);
	$stm -> bindvalue(':name',$_POST['name'],PDO::PARAM_STR);
	$stm -> bindvalue(':address',$_POST['address'],PDO::PARAM_STR);
	$stm -> bindvalue(':login',$_POST['login'],PDO::PARAM_STR);
	$stm -> bindvalue(':password',$_POST['password'],PDO::PARAM_STR);
	//SQL文を実行
	$stm -> execute();
	print "お客様情報を登録しました。";
	?>
</body>

</html>