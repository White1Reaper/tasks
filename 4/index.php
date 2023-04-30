<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, результаты сохранены.');
  }

  $values['fio'] = isset($_COOKIE['fio']) ? $_COOKIE['fio'] : '';
  $values['gender'] = isset($_COOKIE['gender']) ? $_COOKIE['gender'] : '';
  $values['limbs'] = isset($_COOKIE['limbs']) ? $_COOKIE['limbs'] : '';
  // Включаем содержимое файла form.php.
  include('form.php'); 
 $radio1=NULL;
   $radio2=NULL;
 // $radio1 =isset($_COOKIE['limbs'])&&$_COOKIE['limbs'] == "4limbs"  ?  print("checked") : NULL;
//   if( isset($_COOKIE['limbs'])&&_$_COOKIE['limbs'] == "4limbs"){
//   $radio1="checked";
// }
// if( isset($_COOKIE['limbs'])&&_$_COOKIE['limbs'] == "10limbs"){
//   $radio12"checked";
// }
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['fio'])) {
 // print('Заполните имя.<br/>');
  setcookie('err_fio','1',time()+3600*24*365);
  $errors = TRUE;
}
else{
  
  setcookie('err_fio','');
}
if (empty($_POST['year'])) {
  setcookie('err_date','1',time()+3600*24*365);
  //print('Заполните дату.<br/>');
  $errors = TRUE;
}
else{
  
  setcookie('err_date','');
}
if (empty($_POST['email'])) {
  //print('Заполните email.<br/>');
  setcookie('err_email','1',time()+3600*24*365);
  $errors = TRUE;
}
else{
  
  setcookie('err_email','');
}
if (empty($_POST['biography'])) {
  //print('Заполните биографию.<br/>');
  setcookie('err_biography','1',time()+3600*24*365);
  $errors = TRUE;
}
else{
  
  setcookie('err_biography','');
}
if (!preg_match('/^[a-zA-Zа-яА-Я\s]+$/u', $_POST['fio'])) {
 // print('имя пишите только латинскими буквами или только на кириллице');
  $errors = TRUE;
  
  setcookie('err_fio2','1',time()+3600*24*365);
}
else{
  
  setcookie('err_fio2','');
}
$email = $_POST["email"];
$user = '[a-zA-Z0-9_\-\.\+\^!#\$%&*+\/\=\?`\|\{\}~\']+'; // локальная часть
$domain = '(?:(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.?)+'; // домен
$ipv4 = '[0-9]{1,3}(\.[0-9]{1,3}){3}'; // ip-адрес по протоколу ipv4
$ipv6 = '[0-9a-fA-F]{1,4}(\:[0-9a-fA-F]{1,4}){7}'; // ip-адрес по протоколу ipv6

if (!preg_match("/^$user@($domain|(\[($ipv4|$ipv6)\]))$/", $email)) {
 //print('Некорректно введён email<br/>');
 $errors = TRUE;
 
 setcookie('err_email2','1',time()+3600*24*365);
}
else{
  setcookie('err_email2','');
}
/*
if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  print('Заполните год.<br/>');
  $errors = TRUE;
}
*/

// *************
// Тут необходимо проверить правильность заполнения всех остальных полей.
// *************

if ($errors) {header('Location: index.php');
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.

$user = 'u53851';
$pass = '6440273';
$db = new PDO('mysql:host=localhost;dbname=u53851', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

// Подготовленный запрос. Не именованные метки.
try {
  $stmt = $db->prepare("INSERT INTO form(fio, email, biography, limbs, year, gender) VALUES (:fio,:email,:biography,:limbs,:year,:gender)");
  
  $name = $_POST["fio"];
  $ye = $_POST["year"];
  //$stmt = $db->prepare("INSERT INTO form(email) VALUES (:email)");
  $em = $_POST["email"];
  $bio = $_POST["biography"];
  $limbs = $_POST["limbs"];
  $gen=$_POST["gender"];
  $stmt -> execute(['fio'=>"$name", 'email'=>"$em", 'biography'=>"$bio",'limbs'=>"$limbs", 'year'=>"$ye","gender"=>"$gen"]);
 $id_connection=$db->lastInsertId();
 //$stmt = $db->prepare("INSERT INTO form(for_key) VALUES (:for_key)");
 //$stmt -> execute(['for_key'=>"$id_connection"]);
  $stmt = $db->prepare("INSERT INTO connection(id_ability, id_person) VALUES (:id_ability,:id_person)");

  foreach ($_POST["Abilities"] as $abilities){
    
    if ($abilities!=false){
     $stmt-> execute(['id_ability'=> $abilities, 'id_person'=>$id_connection]);
    }
  }
  setcookie('fio',$name,time()+3600*24*365);
 // setcookie('Abilities',$abilities,time()+1000);
  setcookie('year',$ye,time()+3600*24*365);
  setcookie('email',$em,time()+3600*24*365);
  setcookie('biography',$bio,time()+3600*24*365);
  setcookie('limbs',$limbs,time()+3600*24*365);
  setcookie('gender',$gen,time()+3600*24*365);
//   if (isset($_POST['limbs']) && $_POST['limbs'] == "4limbs") {
//     setcookie('radio1', "true", 600, '/');
//     setcookie('radio2', "false", 600, '/');
//     $radio1 ='checked';
//     $radio2 = NULL;
// } else if(isset($_POST['limbs']) && $_POST['limbs'] == "10limbs") {
//     setcookie('radio1', "false", 600, '/');
//     setcookie('radio2', "true", 600, '/');
//     $radio1 = NULL;
//     $radio2 = 'checked';
// }

if (isset($_COOKIE['radio1']) && $_COOKIE['radio1'] == "true") {
    $radio1 = ' checked="checked"';
    $radio2 = '';
} else if (isset($_COOKIE['radio2']) && $_COOKIE['radio2'] == "true") {
    $radio1 = '';
    $radio2 = ' checked="checked"';
}
// $a1=NULL;
// $a2=NULL;
// $a3=NULL;
$abil=$_POST["Abilities"];
setcookie('abil1',serialize($_POST["Abilities"]),time()+365*24*3600);
  //$stmt = $db->prepare("INSERT INTO form(email) VALUES (:email)");
  //$em = $_POST["email"];
  //$stmt -> execute(['email'=>"$em"]);
 //$stmt = $db->prepare("INSERT INTO application SET name = ?");
 //$stmt -> execute($_POST['fio']);
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

//  stmt - это "дескриптор состояния".
 
//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(['label'=>'perfect', 'color'=>'green']);
 
//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');