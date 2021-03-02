<?php

require_once('db_conf.php');

define("postsUrl", 'https://jsonplaceholder.typicode.com/posts');
define("commentsUrl", 'https://jsonplaceholder.typicode.com/comments');

try {
    $dbh = new PDO("mysql:host=$host; dbname=$dbname", $user, $password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    exit();
}

$postsData = file_get_contents(postsUrl);
$commentsData = file_get_contents(commentsUrl);

$postsArray = json_decode($postsData, true);
$commentsArray = json_decode($commentsData, true);

$stmt = $dbh->prepare("INSERT INTO posts (userId, id, title, body) VALUES (:userId, :id, :title, :body)");
try {
    $dbh->beginTransaction();
    $postsCount = 0;  // ручной счётчик, т.к. при транзакциях некоторые методы подсчёта не работают
    foreach ($postsArray as $row)
    {
        if($stmt->execute($row)){
            $postsCount++;
        }
    }
    $dbh->commit();
} catch (Exception $e){
    $dbh->rollback();
    throw $e;
}

$stmt = $dbh->prepare("INSERT INTO comments (postId, id, name, email, body) VALUES (:postId, :id, :name, :email, :body)");
try {
    $dbh->beginTransaction();
    $commentCount = 0;
    foreach ($commentsArray as $row)
    {
        if($stmt->execute($row)){
            $commentCount++;
        }
    }
    $dbh->commit();
} catch (Exception $e){
    $dbh->rollback();
    throw $e;
}

echo "Загружено $postsCount записей и $commentCount комментариев" . PHP_EOL;
