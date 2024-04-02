<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("models/Message.php");

$message = new Message($BASE_URL);

$userDAO = new UserDAO($conn, $BASE_URL);

// Resgata o tipo de formulário
$type = filter_input(INPUT_POST, "type");

// Verificação do tipo de formulario
if($type === "register"){

    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $cpf = filter_input(INPUT_POST, "cpf");
    $gender = filter_input(INPUT_POST, "gender");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    //Verificação de dados minimos
    if($name && $lastname && $email && $password){
        
        //Verificar se as senhas batem
        if($password === $confirmpassword){
             
            //Verifica se o email ja esta cadastrado no sistema
            if($userDAO->findByEmail($email) === false){

                $user = new User();

                // Criação de token e senha
                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->cpf = $cpf;
                $user->gender = $gender;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDAO->create($user, $auth);

            } else {
                $message->setMessage("Email ja cadastrado", "error", "back");
            }

        } else {
            $message->setMessage("Senhas não conferem", "error", "back");
        }

    } else {
    $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
    } 

} else if ($type === "login"){
    
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    //Tenta autenticar usuario
    if($userDAO->authenticateUser($email, $password)){
        
        $message->setMessage("Seja Bem-Vindo", "success", "editprofile.php");

    //Redirecina o usuario, caso nao conseguir autenticar
    } else {
        $message->setMessage("Usuario ou senha invalidos", "error", "index.php");
        
    }
 } else {
        $message->setMessage("Informações invalidas.", "error", "index.php");
}
