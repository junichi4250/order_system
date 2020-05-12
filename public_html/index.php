<?php

require_once(__DIR__ . '/../config/config.php');

$orderApp = new \MyApp\Order();

$err = $orderApp->getError();

 ?>


<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Order System</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div class="container">
      <h1>発注システム</h1>
      <form action="result.php" method="post" id="form">
        <input type="text" name="CD" maxlength="3" placeholder="分類CD(3桁まで)">
        <div class="btn">表示</div>
        <input type="hidden" name="token" id="token" value="<?= h($_SESSION['token']); ?>">
      </form>
    </div>
    <?php if(isset($err)) : ?>
      <div class="error"><?= h($err); ?></div>
    <?php endif; ?>
    <h2><a href="add.php">データの追加</a></h2>
    <h2><a href="allselect.php">登録商品を全て表示する</a></h2>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="order.js"></script>
  </body>
</html>
