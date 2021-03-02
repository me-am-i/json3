<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Search form</title>
</head>
<body>

<form method="POST">
    <input type="text" name="req" minlength = "3" >
    <br><br>
    <button name="form">Найти</button>
</form>

<?php

require_once('db_conf.php');
    $req = $_POST['req'];
if (strlen($req) >= 3) {
    try {
            $dbh = new PDO("mysql:host=$host; dbname=$dbname", $user, $password);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            exit();
        }

    $query = "SELECT posts.title, comments.body
            FROM posts 
            INNER JOIN comments 
            ON comments.body LIKE ?
            AND posts.id = comments.postId";

    $params = ["%$req%"];
    $stmt = $dbh->prepare($query);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!count($data)) {
        echo "<br>записей не найдено";
    }
    else {
        $i = 1;
            echo "<br>";
        foreach ($data as $record) {
            echo $i++ . '. Заголовок : ' . $record['title'] . "<br> Комментарий: " . $record['body'] . '<br><br>';
        }
    }
}
else {
    print("<br>Ведите текст для поиска");
}

