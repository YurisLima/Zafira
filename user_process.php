<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("models/Message.php");

$message = new Message($BASE_URL);

$userDAO = new UserDAO($conn, $BASE_URL);

//Resgara o tipo do formulario
$type = filter_input(INPUT_POST, "type");

// Atualiza usuario
if($type === "update") {

    //Resgata dados do usuario
    $userData = $userDAO->verifyToken();

    //Recebe dados do POST
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $gender = filter_input(INPUT_POST, "gender");
    $cpf = filter_input(INPUT_POST, "cpf");

    //Cria um novo objeto de usuario
    $user = new User();

    //Preenche os dados do usuario
    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->email = $email;
    $userData->gender = $gender;
    $userData->cpf = $cpf;

    $userDAO->update($userData);

} else {
    $message->setMessage("Informações inválidas!", "error", "index.php");
} 