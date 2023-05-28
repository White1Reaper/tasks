<?php


// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

if(session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

if(!empty($_COOKIE["change"])) {
    $cid = $_COOKIE["change"];
    setcookie("change", "");
    try {
        $user = 'u53851';
        $pass = '6440273';
        $db = new PDO('mysql:host=localhost;dbname=u53851', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

        $stmt = $db->prepare("SELECT * FROM form WHERE id = :cid");
        $stmt->bindParam(':cid', $cid, PDO::PARAM_INT);
        $stmt->execute();
        $res1 = $stmt->fetch(PDO::FETCH_ASSOC);
    

        $stmt = $db->prepare("SELECT * FROM form");
        $stmt->execute();
        $a_err = true;
        while ($ss = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $log1 = $ss["login"];
            $pass1 = $ss["password"];
            if($log1 == $res1["login"] && $pass1 == $res1["password"]) {
                setcookie('login', $res1["login"]);

          
                setcookie('password', $res1["password"]);

                $a_err = false;
                setcookie('authorized', '1');

                header('Location: ./');

            }
        }
        if($a_err) {
           header('Location: admin.php');
           exit();
        }
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') { ?>
    
    <style>.err {background-color: red;}</style>
   
    <form  action="" method="post">
        <div> <?php if(!empty($_COOKIE['err_autho'])) {print 'Неверный логин или пароль!';}?></div>
        <input name="login"  <?php if(!empty($_COOKIE['err_autho'])) {print 'class="err"';} ?>/>
        <input name="pass" <?php if(!empty($_COOKIE['err_autho'])) {print 'class="err"'; setcookie("err_autho","");} ?> />
        <input type="submit" value="Войти" />
        <a href="index.php"> Зарегистрироваться</a>
    </form>
<?php } else {
    try {
        $log1 = $_POST["login"];
        $pass1 = $_POST["pass"];
        $user = 'u53851';
        $pass = '6440273';
        $db = new PDO('mysql:host=localhost;dbname=u53851', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
        $stmt = $db->prepare("SELECT * FROM form");
        $stmt->execute();
        $a_err = true;

        while ($ss = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $log2 = $ss["login"];
            $pass2 = $ss["password"];
            if($log1 == $log2 && $pass1 == $pass2) {
                setcookie('login', $_POST['login']);
                setcookie('password', $_POST['pass']);

                $a_err = false;
                setcookie('authorized', '1');

                header('Location: ./');
            }
        }

        if($a_err) {
            echo 'неверный логин или пароль';
            setcookie("err_autho","1");
            header('Location: login.php');
            exit();
        }
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}