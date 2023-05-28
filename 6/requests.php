<?php

function DB_Connect(){
    $user = 'u53851';
    $pass = '6440273';
    $db = new PDO('mysql:host=localhost;dbname=u53851', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
    return $db;
}

function DB_Admins($db, $login){
    $statement = $db->prepare("SELECT login FROM admins where login=:login");
    $statement->execute(['login'=>"$login"]);
    $res = $statement->fetchAll();
    return $res;
}

function DB_Users($db){
    $statement = $db->prepare("SELECT id, login, password FROM form");
    $statement->execute();
    $users = $statement->fetchAll();
    return $users;
}

function Kol_1($db){
    $statement = $db->prepare("SELECT COUNT(id) FROM connection where id_ability=:num");
    $statement->execute(['num'=>"1"]);
    $k = $statement->fetchAll();
    return $k[0]['COUNT(id)'];
}
function Kol_2($db){
    $statement = $db->prepare("SELECT COUNT(id) FROM connection where id_ability=:num");
    $statement->execute(['num'=>"2"]);
    $k = $statement->fetchAll();
    return $k[0]['COUNT(id)'];
}
function Kol_3($db){
    $statement = $db->prepare("SELECT COUNT(id) FROM connection where id_ability=:num");
    $statement->execute(['num'=>"3"]);
    $k = $statement->fetchAll();
    return $k[0]['COUNT(id)'];
}

function Delete_Cookies(){
    foreach($_COOKIE as $word => $value){
        setcookie($word, '', 1000000);
    }
}

function ID_User_Data($db, $id){
    $statement = $db->prepare("SELECT * FROM form where id=:id");
    $statement->execute(['id'=>"$id"]);
    $user = $statement->fetchAll();
    return $user;
}

function DB_Power($db, $id){
    $statement = $db->prepare("SELECT id_ability FROM connection where id=:id");
    $statement->execute(['id'=>"$id"]);
    $data_powers = $statement->fetchAll();
    return $data_powers;
}

?>