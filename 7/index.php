<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

// Генерируем токен CSRF и сохраняем его в сессию
if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Спасибо, результаты сохранены.');
  }
  $values['fio'] = isset($_COOKIE['fio']) ? $_COOKIE['fio'] : '';
  $values['gender'] = isset($_COOKIE['gender']) ? $_COOKIE['gender'] : '';
  $values['limbs'] = isset($_COOKIE['limbs']) ? $_COOKIE['limbs'] : '';
  include(dirname(__FILE__).'/form.php'); 
  exit();
}

$errors = FALSE;

if (empty($_POST['fio'])) {
  setcookie('err_fio', '1', time() + 3600 * 24 * 365);
  $errors = TRUE;
} else {
  setcookie('err_fio', '');
}

if (empty($_POST['year'])) {
  setcookie('err_date', '1', time() + 3600 * 24 * 365);
  $errors = TRUE;
} else {
  setcookie('err_date', '');
}

if (empty($_POST['email'])) {
  setcookie('err_email', '1', time() + 3600 * 24 * 365);
  $errors = TRUE;
} else { 
  setcookie('err_email', '');
}

if (empty($_POST['biography'])) {
  setcookie('err_biography', '1', time() + 3600 * 24 * 365);
  $errors = TRUE;
} else {
  setcookie('err_biography', '');
}

if (!preg_match('/^[a-zA-Zа-яА-Я\s]+$/u', $_POST['fio'])) {
  $errors = TRUE;
  setcookie('err_fio2', '1', time() + 3600 * 24 * 365);
} else {
  setcookie('err_fio2', '');
}

$email = $_POST["email"];
$user = '[a-zA-Z0-9_\-\.\+\^!#\$%&*+\/\=\?`\|\{\}~\']+'; // локальная часть
$domain = '(?:(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.?)+'; // домен
$ipv4 = '[0-9]{1,3}(\.[0-9]{1,3}){3}'; // ip-адрес по протоколу ipv4
$ipv6 = '[0-9a-fA-F]{1,4}(\:[0-9a-fA-F]{1,4}){7}'; // ip-адрес по протоколу ipv6

if (!preg_match("/^$user@($domain|(\[($ipv4|$ipv6)\]))$/", $email)) {
  $errors = TRUE;
  setcookie('err_email2', '1', time() + 3600 * 24 * 365);
} else {
  setcookie('err_email2', '');
}

$abi = true;

foreach ($_POST["Abilities"] as $ab1) {
  if ($ab1 != false) {
    $abi = false;
  }
}

if ($abi) {
  setcookie("err_abil", "1", time() + 3600 * 24 * 365);
  $errors = true;
} else {
  setcookie("err_abil", "");
}

// Проверяем токен CSRF
if ($_POST && $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
  die('Invalid token');
}

if ($errors) {
  header('Location: index.php');
  exit();
}

$user = 'u53851';
$pass = '6440273';
$db = new PDO('mysql:host=localhost;dbname=u53851', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

try {
  // Генерируем новый токен CSRF и сохраняем его в сессию
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

  $stmt = $db->prepare("INSERT INTO form2(fio, email, biography, limbs, year, gender) VALUES (:fio, :email, :biography, :limbs, :year, :gender)");

  $name = $_POST["fio"];
  $ye = $_POST["year"];
  $em = $_POST["email"];
  $bio = $_POST["biography"];
  $limbs = $_POST["limbs"];
  $gen = $_POST["gender"];

  // Экранируем опасные символы для защиты от XSS-атак
  $name = htmlspecialchars($_POST["fio"], ENT_QUOTES, 'UTF-8');
  $ye = htmlspecialchars($_POST["year"], ENT_QUOTES, 'UTF-8');
  $em = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
  $bio = htmlspecialchars($_POST["biography"], ENT_QUOTES, 'UTF-8');
  $limbs = htmlspecialchars($_POST["limbs"], ENT_QUOTES, 'UTF-8');
  $gen = htmlspecialchars($_POST["gender"], ENT_QUOTES, 'UTF-8');
  $abil = array_map('intval', $_POST["Abilities"]);

  $stmt->execute(['fio' => "$name", 'email' => "$em", 'biography' => "$bio", 'limbs' => "$limbs", 'year' => "$ye", "gender" => "$gen"]);

  $id_connection = $db->lastInsertId();
  $stmt = $db->prepare("INSERT INTO connection2(id_ability, id_person) VALUES (:id_ability,:id_person)");

  foreach ($abil as $abilities) {
    if ($abilities != false) {
      $stmt->execute(['id_ability' => $abilities, 'id_person' => $id_connection]);
    }
  }

  setcookie('fio', $name, time() + 3600 * 24 * 365);
  setcookie('year', $ye, time() + 3600 * 24 * 365);
  setcookie('email', $em, time() + 3600 * 24 * 365);
  setcookie('biography', $bio, time() + 3600 * 24 * 365);
  setcookie('limbs', $limbs, time() + 3600 * 24 * 365);
  setcookie('gender', $gen, time() + 3600 * 24 * 365);

  if (isset($_COOKIE['radio1']) && $_COOKIE['radio1'] == "true") {
    $radio1 = ' checked="checked"';
    $radio2 = '';
  } else if (isset($_COOKIE['radio2']) && $_COOKIE['radio2'] == "true") {
    $radio1 = '';
    $radio2 = ' checked="checked"';
  }

  setcookie('abil1',serialize($_POST["Abilities"]),time()+365*24*3600);

} catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}

header('Location: ?save=1');
?>