<?php

require_once(__DIR__ . '/../config/config.php');

$orderApp = new \MyApp\Order();

try {
  $res = $orderApp->post();
  header('Content-Type: application/json');
  echo json_encode($res);
} catch (\Exception $e) {
  echo $e->getMessage();
}


 ?>
