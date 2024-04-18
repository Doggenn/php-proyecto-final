<?php

header("Access-Control-Allow-Origin:* ");

header("Access-Control-Allow-Headers:* ");

header("Access-Control-Allow-Methods:* ");

$connect = new PDO("mysql:host=pro.freedb.tech;dbname=protectora", "Doggenn", "deUkARF%!gW!5Xp");

$method = $_SERVER['REQUEST_METHOD']; //return GET, POST, PUT, DELETE

if ($method === 'GET') {
    //fetch all user

    $query = "SELECT * FROM personalidad ORDER BY id DESC";

    $result = $connect->query($query, PDO::FETCH_ASSOC);

    $data = array();

    foreach ($result as $row) {
        $data[] = $row;
    }

    echo json_encode($data);
} elseif ($method === 'POST') {
    $input_data = json_decode(file_get_contents("php://input"), true);

    // Obtener los valores de id_mascota y nombre
    $id_mascota = $input_data['id_mascota'];
    $nombre = $input_data['nombre'];

    // Insertar el nuevo registro en la base de datos
    $query = "INSERT INTO personalidad (id_mascota, nombre) VALUES (?, ?)";
    $stmt = $connect->prepare($query);
    $stmt->execute([$id_mascota, $nombre]);

    // Devolver una respuesta exitosa
    echo json_encode(array("message" => "Registro insertado correctamente"));
} elseif ($method === 'DELETE') {
    // Obtener los datos del cuerpo de la solicitud DELETE
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si se proporcionó el ID en los datos
    if (isset($data['id'])) {
        // Obtener el ID del usuario a eliminar
        $id = $data['id'];

        // Eliminar el registro de la base de datos
        $query = "DELETE FROM personalidad WHERE id=?";
        $stmt = $connect->prepare($query);
        $stmt->execute([$id]);

        // Devolver una respuesta exitosa
        echo json_encode(array("message" => "Registro eliminado correctamente"));
    } else {
        // Si no se proporciona el ID, devolver un mensaje de error
        echo json_encode(array("error" => "ID del usuario no proporcionado"));
    }
}
/*
{
    "id_mascota": 12345,
    "nombre":"Alterado"
}
*/