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

		<?php
		//ログインの確認
		if (isset($_SESSION['customer'])) {
			//DBに接続
			require 'db_connect.php';
			//購入履歴を表示
			// 	$sql = "select * from purchase_detail, purchase where purchase_id = :purchase_id and product_id = id and count = count";
			// 	$stm = $pdo->prepare($sql);
			// 	$stm->bindValue(':purchase_id', $_SESSION['customer']['id'], PDO::PARAM_STR);
			// 	$stm->execute();
			// 	$result = $stm->fetchAll(PDO::FETCH_ASSOC);
			// 	foreach ($result as $row) {
			// 		$id = $row['id'];
			// 
			$sql = "SELECT purchase_id,name,count,price,product_id
				 from purchase as P
				 inner join purchase_detail as D 
					 ON P.id = D.purchase_id 
				 	 AND customer_id = :customer_id
				 JOIN product AS PR
				 ON PR.id = D.product_id;
				 ";
			// $stm -> bindValue(':customer_id', $_SESSION['customer']['id'], PDO::PARAM_STR);
			$stm = $pdo->prepare($sql);
			$stm -> bindValue(':customer_id', $_SESSION['customer']['id'],PDO::PARAM_INT);
			// $stm->bindValue(':id',$purchase_id,PDO::PARAM_STR);
			// $stm -> bindValue(':purchase_id', $_SESSION['purchase_id'],PDO::PARAM_INT);
			// $stm -> bindValue(':product_id',$_SESSION['product_id'],PDO::PARAM_INT);
			$result = $stm->execute();
			if(is_null($result)){
				print "購入履歴がありません。";
			}else{
				$array = [];
				foreach($stm as $row){
					$array[$row['purchase_id']][] = [
						'name' => $row['name'],
						'product_id' => $row['product_id'],
						'count' => $row['count'],
						'price' => $row['price'],
						'subtotal' => $row['price'] * $row['count'],
					];
				}
			}
		?>
		<?php
		foreach($array as $key => $val):
			$total = 0;
			$color = $key % 2==0 ;?>
			<table>
			<caption>注文番号:<?= $key ?></caption>
			<tr>
			<th>商品名</th>
			<th>個数</th>
			<th>単価</th>
			<th>小計</th>
			</tr>
			<hr>
			<?php foreach($val as $listVal): ?>
			<tr>
			<td><a href="dateil.php?id=<?= $listVal['product_id']?>">
				<?= $listVal['name']?></a>
			</td>
			<td><?= $listVal['count']?></td>
			<td><?= $listVal['price']?></td>
			<td><?= $listVal['subtotal']?></td>
			<?php $total += $listVal['subtotal']; endforeach; ?>
			<tr>
			<th>合計金額</th>
			<td><?= $total ?>円</td>
			</tr>
			</table>
		<?php endforeach;
		}else{
		?>
			購入履歴を表示するには、ログインしてください。
		<?php
		}
		?>


</body>

</html>