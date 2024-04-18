<?php

header("Access-Control-Allow-Origin:* ");

header("Access-Control-Allow-Headers:* ");

header("Access-Control-Allow-Methods:* ");

$connect = new PDO("mysql:host=pro.freedb.tech;dbname=protectora", "Doggenn", "deUkARF%!gW!5Xp");

$method = $_SERVER['REQUEST_METHOD']; //return GET, POST, PUT, DELETE

if ($method === 'GET') {

    $query = "SELECT * FROM usuarios ORDER BY id DESC";

    $result = $connect->query($query, PDO::FETCH_ASSOC);

    $data = array();

    foreach ($result as $row) {
        $data[] = $row;
    }

    echo json_encode($data);
} elseif ($method === 'POST') {
    // Obtener los datos del cuerpo de la solicitud
    $input_data = json_decode(file_get_contents("php://input"), true);

    // Obtener los valores de usuario y contraseña
    $usuario = $input_data['usuario'];
    $password = $input_data['password'];

    // Valor predeterminado para el rol
    $rol = 'usuario';

    // Insertar el nuevo registro en la base de datos
    $query = "INSERT INTO usuarios (usuario, password, rol) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($query);
    $stmt->execute([$usuario, $password, $rol]);

    // Devolver una respuesta exitosa
    echo json_encode(array("message" => "Registro insertado correctamente"));
} elseif ($method === 'PUT') {
    // Manejar una solicitud PUT para actualizar un registro existente
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_PUT['id'];
    $usuario = $_PUT['usuario'];
    $password = $_PUT['password'];

    // Actualizar el registro en la base de datos
    $query = "UPDATE usuarios SET usuario=?, password=? WHERE id=?";
    $stmt = $connect->prepare($query);
    $stmt->execute([$usuario, $password, $id]);

    // Devolver una respuesta exitosa
    echo json_encode(array("message" => "Registro actualizado correctamente"));
} elseif ($method === 'DELETE') {
    // Obtener los datos del cuerpo de la solicitud DELETE
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si se proporcionó el ID en los datos
    if (isset($data['id'])) {
        // Obtener el ID del usuario a eliminar
        $id = $data['id'];

        // Eliminar el registro de la base de datos
        $query = "DELETE FROM usuarios WHERE id=?";
        $stmt = $connect->prepare($query);
        $stmt->execute([$id]);

        // Devolver una respuesta exitosa
        echo json_encode(array("message" => "Registro eliminado correctamente"));
    } else {
        // Si no se proporciona el ID, devolver un mensaje de error
        echo json_encode(array("error" => "ID del usuario no proporcionado"));
    }
}
