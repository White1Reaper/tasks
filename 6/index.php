<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
    session_start();
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if(!empty($_COOKIE["session"])){
  session_destroy();
  setcookie("session","");
  $_SESSION["authorized"]="";
  header('Location: index.php');
  exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if(isset($_COOKIE["authorized"])||!empty($_SESSION["authorized"])){

echo 'Вы авторизованы! ';
$_SESSION["authorized"]='111';
setcookie("authorized",'');
if(!empty($_COOKIE["login"])){
$_SESSION["login"]=$_COOKIE["login"];
$_SESSION["password"]=$_COOKIE["password"];
setcookie("login",'');
setcookie("password",'');
}

   $user = 'u53851';
$pass = '6440273';
$db = new PDO('mysql:host=localhost;dbname=u53851', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
$res = $db->query("SELECT * FROM form WHERE password='{$_SESSION["password"]}' and login='{$_SESSION["login"]}' ");
foreach($res as $ss){
  if($_SESSION['password']==$ss["password"]&&$_SESSION['login']==$ss["login"]){
    //echo $ss["fio"];
    // setcookie('fio',$ss["fio"],time()+3600*24*365);
    // setcookie('year',$ss["year"],time()+3600*24*365);
    // setcookie('email',$ss["email"],time()+3600*24*365);
    // setcookie('biography',$ss["biography"],time()+3600*24*365);
    // setcookie('limbs',$ss["limbs"],time()+3600*24*365);
    // setcookie('gender',$ss["gender"],time()+3600*24*365);
    $_SESSION["id"]=$ss["id"];
    $_SESSION["fio"]=$ss["fio"];
    $_SESSION["year"]=$ss["year"];
    $_SESSION["email"]=$ss["email"];
    $_SESSION["biography"]=$ss["biography"];
    $_SESSION["limbs"]=$ss["limbs"];
    $_SESSION["gender"]=$ss["gender"];
  $id_connection2=$ss["id"];
$a="";
  $res2 = $db->query("SELECT * FROM connection WHERE id_person='{$id_connection2}'");
  foreach($res2 as $ss2){
$a.=$ss2["id_ability"];
  }
  $b=str_split($a);
 // setcookie('abil1',serialize($b),time()+365*24*3600);
  $_SESSION["abil1"]=serialize($b);
}
 
}
}
//session_destroy();
  

  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_COOKIE['save'])&&empty($_COOKIE["update"])) {
    // Если есть параметр save, то выводим сообщение пользователю.

    echo'Спасибо, результаты сохранены. Ваш логин: ';
    echo $_COOKIE['log'];

    
    echo ', ваш пароль: ';
    echo $_COOKIE['pass'];
echo sprintf(' Вы можете <a href="login.php">войти</a> для изменения данных.');
  setcookie('save','');
}
elseif(!empty($_COOKIE["update"])){
  setcookie("update",'');
  
  echo 'обновление данных прошло успешно';
}

  $values['fio'] = isset($_COOKIE['fio']) ? $_COOKIE['fio'] : '';
  $values['gender'] = isset($_COOKIE['gender']) ? $_COOKIE['gender'] : '';
  $values['limbs'] = isset($_COOKIE['limbs']) ? $_COOKIE['limbs'] : '';
  // Включаем содержимое файла form.php.
  
  include('form.php'); 

  // setcookie('fio','',time()+3600*24*365);
  //   setcookie('year','',time()+3600*24*365);
  //   setcookie('email','',time()+3600*24*365);
  //   setcookie('biography','',time()+3600*24*365);
  //   setcookie('limbs','',time()+3600*24*365);
  //   setcookie('gender','',time()+3600*24*365);
  //   setcookie('abil1','',time()+365*24*3600);
 

  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else{
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

$abi=true;
foreach ($_POST["Abilities"] as $ab1){
  if ($ab1!=false){
$abi=false;}}
if($abi){
setcookie("err_abil","1");
$errors=true;
}
else{
  setcookie("err_abil","");
}
if ($errors) {header('Location: index.php');
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.

$user = 'u53851';
$pass = '6440273';
$db = new PDO('mysql:host=localhost;dbname=u53851', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

// Подготовленный запрос. Не именованные метки.
$save=true;
try {
  //session_status() === PHP_SESSION_NONE
  if (!empty($_SESSION["authorized"])) {
    $stmt = $db->prepare("SELECT id from form where login=:login_value and password=:password_value");
    $stmt->bindParam(':login_value', $_SESSION["login"]);
    $stmt->bindParam(':password_value', $_SESSION["password"]);
    $stmt->execute();
    $id = $stmt->fetch(PDO::FETCH_COLUMN);
    //setcookie("id",$id);
    $sql = "UPDATE form SET fio=:fio_value, email=:email_value, year=:year_value, biography=:biography_value, limbs=:limbs_value, gender=:gender_value WHERE login=:login_value and password=:password_value";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':fio_value', $_POST["fio"]);
    $stmt->bindParam(':login_value', $_SESSION["login"]);
    $stmt->bindParam(':password_value', $_SESSION["password"]);
    $stmt->bindParam(':email_value', $_POST["email"]);
    $stmt->bindParam(':year_value', $_POST["year"]);
    $stmt->bindParam(':biography_value', $_POST["biography"]);
    $stmt->bindParam(':limbs_value', $_POST["limbs"]);
    $stmt->bindParam(':gender_value', $_POST["gender"]);
    $stmt->execute();
    
    $stmt = $db->prepare("DELETE from connection where id_person=:id_value");
    $stmt->bindParam(':id_value', $id);
    $stmt->execute();
    
    $stmt = $db->prepare("INSERT INTO connection(id_ability, id_person) VALUES (:id_ability,:id_person)");
    //$abbb[]=$_SESSION["Abil1"];
    foreach ($_POST["Abilities"] as $ab){
        if ($ab!=false){
            $stmt->execute(['id_ability' => $ab, 'id_person' => $_SESSION["id"]]);
        }
    }

$save=false;
setcookie("update",'333');
  }
  else{
  $login=rand(1000,100000);
  $pass=rand(1000,100000);
  setcookie('log',$login);
  setcookie('pass',$pass);
  $stmt = $db->prepare("INSERT INTO form(fio, email, biography, limbs, year, gender,login,password) VALUES (:fio,:email,:biography,:limbs,:year,:gender,:login,:password)");
  
  $name = $_POST["fio"];
  $ye = $_POST["year"];
  $em = $_POST["email"];
  $bio = $_POST["biography"];
  $limbs = $_POST["limbs"];
  $gen=$_POST["gender"];
  $stmt -> execute(['fio'=>"$name", 'email'=>"$em", 'biography'=>"$bio",'limbs'=>"$limbs", 'year'=>"$ye","gender"=>"$gen",'login'=>$login,'password'=>$pass]);
 $id_connection=$db->lastInsertId();
  $stmt = $db->prepare("INSERT INTO connection(id_ability, id_person) VALUES (:id_ability,:id_person)");

  foreach ($_POST["Abilities"] as $abilities){
    
    if ($abilities!=false){
     $stmt-> execute(['id_ability'=> $abilities, 'id_person'=>$id_connection]);
    }
  }
  // setcookie('fio',$name,time()+3600*24*365);
  // setcookie('year',$ye,time()+3600*24*365);
  // setcookie('email',$em,time()+3600*24*365);
  // setcookie('biography',$bio,time()+3600*24*365);
  // setcookie('limbs',$limbs,time()+3600*24*365);
  // setcookie('gender',$gen,time()+3600*24*365);

$abil=$_POST["Abilities"];
setcookie('abil1',serialize($_POST["Abilities"]),time()+365*24*3600);

}
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}if($save){
setcookie('save', '1');
}
header('Location: index.php');
}