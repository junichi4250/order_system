<?php

require_once(__DIR__ . '/../config/config.php');

$orderApp = new \MyApp\Order();

$results = $orderApp->getAll();

?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Order System</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <h1>商品一覧</h1>
    <div class="btn" id="back">検索画面に戻る</div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="order.js"></script>
  </body>
</html>
