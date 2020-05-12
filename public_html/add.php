<?php

require_once(__DIR__ . '/../config/config.php');

$orderApp = new \MyApp\Order();

$adds = $orderApp->add();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $orderApp->postadd();
}


 ?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>add</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <h1>商品追加</h1>
    <form action="" method="post" id="addform">
      <ul>
        <li><label for="user_cd">商品CD</label><input type="text" name="user_cd" id="user_cd" value="<?= isset($orderApp->getValues()->cd) ? h($orderApp->getValues()->cd) : '' ;?>" maxlength="10"><li>
        <li><label for="user_category">分類CD</label><input type="text" name="user_category" id="user_category" value="<?= isset($orderApp->getValues()->category) ? h($orderApp->getValues()->category) : '' ;?>" maxlength="3"><li>
        <li><label for="user_name">商品名</label><input type="text" name="user_name" id="user_name" value="<?= isset($orderApp->getValues()->name) ? h($orderApp->getValues()->name) : '' ;?>" maxlength="30"><li>
        <li><label for="user_unit">発注単位</label><input type="text" name="user_unit" id="user_unit" value="<?= isset($orderApp->getValues()->unit) ? h($orderApp->getValues()->unit) : '' ;?>"maxlength="4"><li>
        <li><label for="user_quantity">定量</label><input type="text" name="user_quantity" id="user_quantity" value="<?= isset($orderApp->getValues()->quantity) ? h($orderApp->getValues()->quantity) : '' ;?>" maxlength="4"><li>
        <li><label for="user_rank">ランク</label><input type="text" name="user_rank" id="user_rank" value="<?= isset($orderApp->getValues()->rank) ? h($orderApp->getValues()->rank) : '' ;?>" placeholder="ABC" maxlength="5"><li>
        </ul>
      <?php if (isset($adds)) : ?>
        <p class="add"><?= h($adds); ?></p>
      <?php endif; ?>
      <?php if ($orderApp->getErrors('cd') !== '') : ?>
        <p class="error "><?= h($orderApp->getErrors('cd')); ?></p>
      <?php endif ; ?>
      <?php if ($orderApp->getErrors('category') !== '') : ?>
        <p class="error "><?= h($orderApp->getErrors('category')); ?></p>
      <?php endif ; ?>
      <?php if ($orderApp->getErrors('unit') !== '') : ?>
        <p class="error "><?= h($orderApp->getErrors('unit')); ?></p>
      <?php endif ; ?>
      <?php if ($orderApp->getErrors('quantity') !== '') : ?>
        <p class="error "><?= h($orderApp->getErrors('quantity')); ?></p>
      <?php endif ; ?>
      <?php if ($orderApp->getErrors('duplicate') !== '') : ?>
        <p class="error "><?= h($orderApp->getErrors('duplicate')); ?></p>
      <?php endif ; ?>
      <div class="btn">追加</div>
      <input type="hidden" name="token" id="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div class="back"><a href="index.php">戻る</a></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="order.js"></script>
  </body>
</html>
