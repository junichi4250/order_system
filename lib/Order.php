<?php

namespace MyApp;

class Order {
  private $_db;
  private $_cd;
  private $_errors;
  private $_values;

  public function __construct() {
    $this->_errors = new \stdClass();
    $this->_values = new \stdClass();
    $this->_createToken();
    try {
    $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
    $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  } catch (\Exception $e) {
      echo $e->getMessage();
      exit;
    }
  }

  private function _createToken() {
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] === bin2hex(openssl_random_pseudo_bytes(16));
    }
  }

  public function getCategory() {
    $sql = "select * from users where category = $this->_cd";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getAll() {
    $sql = "select * from users order by category, CD";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function post() {
    return $this->_delete();
  }

  private function _delete() {
    $sql = sprintf("delete from users where CD = %d", $_POST['cd']);
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();
  }

  public function create($a, $b, $c, $d, $e, $f) {
    $sql = "insert into users (CD, category, name, unit, quantity, rank) values (:CD, :category, :name, :unit, :quantity, :rank)";
    $stmt = $this->_db->prepare($sql);
    $data = [':CD' => $a, ':category' => $b, ':name' => $c,
            ':unit' => $d, ':quantity' => $e, ':rank' => $f];
    $stmt->execute($data);
    }

  public function postProcess() {
    try {
      $this->_validateToken();
      $this->_validate();
    } catch (\Exception $e) {
      $_SESSION['err'] = $e->getMessage();
      header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
    }
  }

  private function _validateToken() {
    if (!isset($_SESSION['token']) ||
        !isset($_POST['token']) ||
        $_SESSION['token'] !== $_POST['token']) {
          throw new \Exception('Invalid Token');
        }
  }

  private function _validate() {
    $this->_cd = $_POST['CD'];
    if (empty($this->_cd) || preg_match('/[^0-9]/', $this->_cd)) {
    throw new \Exception('半角数字を入れてね');
    }
  }

  public function getError() {
    $err = null;
    if (isset($_SESSION['err'])) {
      $err = $_SESSION['err'];
      unset($_SESSION['err']);
    }
    return $err;
  }

  public function postadd() {
    try {
      $cd = $_POST['user_cd'];
      $category = $_POST['user_category'];
      $name = $_POST['user_name'];
      $unit = $_POST['user_unit'];
      $quantity = $_POST['user_quantity'];
      $rank = $_POST['user_rank'];

      $this->_validateToken();
      $this->_validateAdd($cd, $category, $name, $unit, $quantity, $rank);
    } catch (\MyApp\Exception\InvalidCD $e) {
      $this->setErrors('cd', $e->getMessage());
    } catch (\MyApp\Exception\InvalidCategory $e) {
      $this->setErrors('category', $e->getMessage());
    } catch (\MyApp\Exception\InvalidUnit $e) {
      $this->setErrors('unit', $e->getMessage());
    } catch (\MyApp\Exception\InvalidQuantity $e) {
      $this->setErrors('quantity', $e->getMessage());
    } catch (\MyApp\Exception\DuplicationCD $e) {
      $this->setErrors('duplicate', $e->getMessage());
    } catch (\MyApp\Exception $e) {
      echo $e->getMessage();
    }

    $this->setValues('cd', $cd);
    $this->setValues('category', $category);
    $this->setValues('name', $name);
    $this->setValues('unit', $unit);
    $this->setValues('quantity', $quantity);
    $this->setValues('rank', $rank);

    if ($this->hasError()) {
      return;
    } else {
      $this->create($cd, $category, $name, $unit, $quantity, $rank);
      $_SESSION['success'] = '追加したよ。続けて追加できるよ';
      header('Location: http://' . $_SERVER['HTTP_HOST'] . '/add.php');
    }
  }

  public function add() {
    $add = '';
    if (isset($_SESSION['success'])) {
      $add = $_SESSION['success'];
      unset($_SESSION['success']);
    }
    return $add;
  }

  public function setErrors($key, $error) {
    $this->_errors->$key = $error;
  }

  public function getErrors($key) {
    return isset($this->_errors->$key) ? $this->_errors->$key : '';
  }

  public function setValues($key, $value) {
    $this->_values->$key = $value;
  }

  public function getValues() {
    return $this->_values;
  }

  public function hasError() {
    return !empty(get_object_vars($this->_errors));
  }

    private function _validateAdd($cd, $category, $name, $unit, $quantity, $rank) {
      if (preg_match('/[^0-9]/', $cd) || empty($cd)) {
        throw new \MyApp\Exception\InvalidCD();
      }

      $sql = "select CD from users";
      $stmt = $this->_db->query($sql);
      $stmt->execute();
      $res = $stmt->fetchAll(\PDO::FETCH_COLUMN);
      if (array_search($cd, $res) !== false) {
        throw new \MyApp\Exception\DuplicationCD();
      }

      if (preg_match('/[^0-9]/', $category)) {
        throw new \MyApp\Exception\InvalidCategory();
      }

      if (preg_match('/[^0-9]/', $unit)) {
        throw new \MyApp\Exception\InvalidUnit();
      }

      if (preg_match('/[^0-9]/', $quantity)) {
        throw new \MyApp\Exception\InvalidQuantity();
      }
    }
}

 ?>
