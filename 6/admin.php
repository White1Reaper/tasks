<?php

include('requests.php');

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_COOKIE['init'])){
 // DEL_COOKIE();
  header("Location: admin.php");
  exit();
}

if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}
else{
  $user = 'u53851';
  $pass = '6440273';
  $db = new PDO('mysql:host=localhost;dbname=u53851', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
  $res = $db->query("SELECT * FROM admins WHERE login='{$_SERVER['PHP_AUTH_USER']}' ");
  $pass = $_SERVER['PHP_AUTH_PW'];
  $p = false;
  foreach($res as $cout){
    if($pass==$cout["password"]){
      $p = true;
    }
  }

  if(!$p){
    setcookie("unluck","2");
    setcookie("log_serv",$_SERVER['PHP_AUTH_USER']);
    //setcookie("log_db")
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
  }
  else{
    if(!empty($_POST["user_id1"])){
      setcookie("change",$_POST["user_id1"]);
      //setcookie("ooo","1");
      header('Location: login.php');
      exit();
    }
    if(!empty($_POST["user_id2"])){
      setcookie("delete",$_POST["user_id2"]);
      header('Location: delete.php');
      exit();
    }
    $users = DB_Users($db);
    
    ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index3.css">
    <title>Админка</title>
  </head>

  <body>
    <a><b>Вы авторизованы! </b></a>
    <a><b><?php if(!empty($_COOKIE["s_d"])){ echo " удаление завершено.";  setcookie("s_d","");} ?> </b></a>
    <br><br>
    <a><b>данные:<b></a>
    <table>
        <tr>
          <th>Суперспособность</th>
          <th>Кол-во человек</th>
        </tr>
      <?php
        $k = Kol_1($db);
        echo "<tr><td>левитация: </td><td class='center'>$k</td>";
        $k =  Kol_2($db);
        echo "<tr><td>бессмертие: </td><td class='center'>$k</td>";
        $k =  Kol_3($db);
        echo "<tr><td>невидимость: </td><td class='center'>$k</td>";
      ?>
    </table>
    <br><br>
    <a><b>Пользователи:</b></a>
      <table>
        <tr>
          <th>id</th>
          <th>login</th>
          <th>password</th>
        </tr>
        <?php
        foreach($users as $cout){
          $id = $cout['id'];
          $login = $cout['login'];
          $password=$cout['password'];
          
          echo 
          "<tr><td>$id</td>
          <td>$login</td>
          <td>$password</td> </tr>";}      
             ?>
      </table>
      <?php
      echo 
          "<form method='POST' target: '_blank'>
          изменение данных пользователя<br/><br/>
          <input name='user_id1' placeholder='id изменяемого пользователя'/>
          <button type='submit'  name='btn1' >Изменить данные</button>
          </form>";
          echo "
                     <form method='POST' target: '_blank'>
                  удаление пользователя<br/><br/>
                  <input name='user_id2' placeholder='id удаляемого пользователя'/>
                  <button type='submit' name='btn2'>Удалить данные</button>
              </form>
               
      ";
      ?>       

  </body>
</html>
    <?php
    exit();    
  }
}
?>