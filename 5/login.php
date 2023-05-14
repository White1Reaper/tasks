<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
if(session_status() === PHP_SESSION_ACTIVE)
{
session_destroy();}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  //session_start();

?>
	<style>
.err {
  background: red;
}
    </style>
<form  action="" method="post">
  <div> <?php if(!empty($_COOKIE['err_autho'])) {print 'Неверный логин или пароль!';}?></div>
  <input name="login"  <?php if(!empty($_COOKIE['err_autho'])) {print 'class="err"';} ?>/>
  <input name="pass" <?php if(!empty($_COOKIE['err_autho'])) {print 'class="err"';    setcookie("err_autho","");} ?> />
  <input type="submit" value="Войти" />
  <a href="index.php"> Зарегистрироваться</a>
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
$pass1=$_POST["pass"];
$log1=$_POST["login"];

  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.

  // Если все ок, то авторизуем пользователя.
 $user = 'u53851';
$pass = '6440273';
$db = new PDO('mysql:host=localhost;dbname=u53851', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
  $res= $db->query("SELECT * FROM form");
  $a_err=true;
foreach($res as $ss){
  $log2=$ss["login"];
  $pass2=$ss["password"];
if($log1==$log2&&$pass1==$pass2){

  
    setcookie('login',$_POST['login']);
    setcookie('password',$_POST['pass']);
$a_err=false;

    setcookie('authorized','1');
    header('Location: ./');

  }
}
  if($a_err){
    echo 'неверный логин или пароль';
    setcookie("err_autho","1");
   header('Location: login.php');
  // При наличии ошибок завершаем работу скрипта.
  exit();
  
  // Записываем ID пользователя.
  
  // Делаем перенаправление.
 // header('Location: ./');
}
}