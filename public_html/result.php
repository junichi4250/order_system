<?php

require_once(__DIR__ . '/../config/config.php');

$orderApp = new \MyApp\Order();

$orderApp->postProcess();
$results = $orderApp->getCategory();

 ?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Order System</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <p>分類CD:<?= h($_POST['CD']); ?></p>
    <table border="1">
      <tr>
        <th>商品CD</th>
        <th>分類CD</th>
        <th>商品名</th>
        <th>発注単位</th>
        <th>定量</th>
        <th>ランク</th>
        <th>削除</th>
      </tr>
      <?php foreach ($results as $result) : ?>
        <tr id="order_<?= h($result->CD); ?>" data-id="<?= h($result->CD); ?>">
          <td><?= h($result->CD); ?></td>
          <td><?= h($result->category); ?></td>
          <td><?= h($result->name); ?></td>
          <td><?= h($result->unit); ?></td>
          <td><?= h($result->quantity); ?></td>
          <td><?= h($result->rank); ?></td>
          <td class="delete">×</td>
        </tr>
      <?php endforeach; ?>
    </table>
    <div class="back">
      <a href="index.php">検索画面に戻る</a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="order.js"></script>
  </body>
</html>
