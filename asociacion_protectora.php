<?php

header("Access-Control-Allow-Origin:* ");

header("Access-Control-Allow-Headers:* ");

header("Access-Control-Allow-Methods:* ");

$connect = new PDO("mysql:host=pro.freedb.tech;dbname=protectora", "Doggenn", "deUkARF%!gW!5Xp");

$method = $_SERVER['REQUEST_METHOD']; //return GET, POST, PUT, DELETE

if ($method === 'GET') {
    //fetch all user

    $query = "SELECT * FROM asociacion_protectora ORDER BY id DESC";

    $result = $connect->query($query, PDO::FETCH_ASSOC);

    $data = array();

    foreach ($result as $row) {
        $data[] = $row;
    }

    echo json_encode($data);
}
