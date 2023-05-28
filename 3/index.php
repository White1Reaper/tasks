<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Спасибо, результаты сохранены.');
  }
  include('form.php');
  exit();
}

$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}
if (!preg_match('/^[a-zA-Zа-яА-Я\s]+$/u', $_POST['fio'])&&!empty($_POST['fio'])) {
   print('имя пишите только латинскими буквами или только на кириллице');
   $errors = TRUE;
   
 }
if (empty($_POST['year'])) {
  print('Заполните дату<br/>');
  $errors = TRUE;
}
if (empty($_POST['email'])) {
  print('Заполните email<br/>');
  $errors = TRUE;
}
$email = $_POST["email"];
$user = '[a-zA-Z0-9_\-\.\+\^!#\$%&*+\/\=\?`\|\{\}~\']+'; // локальная часть
$domain = '(?:(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.?)+'; // домен
$ipv4 = '[0-9]{1,3}(\.[0-9]{1,3}){3}'; // ip-адрес по протоколу ipv4
$ipv6 = '[0-9a-fA-F]{1,4}(\:[0-9a-fA-F]{1,4}){7}'; // ip-адрес по протоколу ipv6

if (!preg_match("/^$user@($domain|(\[($ipv4|$ipv6)\]))$/", $email)&&!empty($_POST['email'])) {
 print('Некорректно введён email. нет символа "@"<br/>');
 $errors = TRUE;
}
if (empty($_POST['biography'])) {
  print('Заполните биографию<br/>');
  $errors = TRUE;
}
$abi=true;
if(!empty($_POST["Abilities"])){
 
$abi=false;}
if($abi){
  print('выберите хотя бы одну суперспособность');
$errors=true;
}

if ($errors) {
  exit();
}
$user = 'u53851';
$pass = '6440273';
$db = new PDO('mysql:host=localhost;dbname=u53851', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

try {
  $stmt = $db->prepare("INSERT INTO form2(fio, email, biography, limbs, year, gender) VALUES (:fio,:email,:biography,:limbs,:year,:gender)");
  
  $name = $_POST["fio"];
  $ye = $_POST["year"];
  $em = $_POST["email"];
  $bio = $_POST["biography"];
  $limbs = $_POST["limbs"];
  $gen=$_POST["gender"];
  $stmt -> execute(['fio'=>"$name", 'email'=>"$em", 'biography'=>"$bio",'limbs'=>"$limbs", 'year'=>"$ye","gender"=>"$gen"]);
 $id_connection=$db->lastInsertId();
  $stmt = $db->prepare("INSERT INTO connection2(id_ability, id_person) VALUES (:id_ability,:id_person)");

  foreach ($_POST["Abilities"] as $abilities){
    
    if ($abilities!=false){
     $stmt-> execute(['id_ability'=> $abilities, 'id_person'=>$id_connection]);
    }
  }

}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}


header('Location: ?save=1');?>