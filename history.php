<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>購入履歴画面</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<!-- ログイン履歴 -->
	<?php require 'menu.php'; ?>
	<table>
		<th>商品番号</th>
		<th>商品名</th>
		<th>価格</th>
		<th>個数</th>
		<th>小計</th>

		<?php
		//ログインの確認
		if (isset($_SESSION['customer'])) {
			//DBに接続
			require 'db_connect.php';
			//購入履歴を表示
			$sql = "select * from purchase_detail, product where purchase_id = :purchase_id and product_id = id and count = count";
			$stm = $pdo->prepare($sql);
			$stm->bindValue(':purchase_id', $_SESSION['customer']['id'], PDO::PARAM_STR);
			$stm->execute();
			$result = $stm->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $row) {
				$id = $row['id'];
		?>
				<tr>
					<td><?= $id ?></td>
					<td><a href="detail.php?id=<?= $id ?>"><?= $row['name'] ?></a></td>
					<td><?= $row['price'] ?></td><td><?= $row['count']?></td>
				</tr>
			<?php
			}
			?>
		<?php
		} else {
		?>
			購入履歴を表示するには、ログインしてください。
		<?php
		}
		?>


</body>

</html>