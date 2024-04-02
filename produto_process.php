<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Produto.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("dao/ProdutoDAO.php");

$message = new Message($BASE_URL);
$userDAO = new UserDAO($conn, $BASE_URL);
$produtoDAO = new ProdutoDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST, "type");

$userData = $userDAO->verifyToken();

if($type === "create") {
    $name_prod = filter_input(INPUT_POST, "name_prod");
    $produto_name = filter_input(INPUT_POST, "produto_name");
    $produto_descricao = filter_input(INPUT_POST, "produto_descricao");
    $produto_preco = filter_input(INPUT_POST, "produto_preco");

    $produto = new Produto();

    //Validações
    if(!empty($produto_name) && !empty($produto_descricao) && !empty($produto_preco)) {

        $produto->name_prod = $name_prod;
        $produto->produto_name = $produto_name;
        $produto->produto_descricao = $produto_descricao;
        $produto->produto_preco = $produto_preco;

        //Upload da imagem
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            //Checando tipo de imagem
            if(in_array($image["type"], $imageTypes)){

                //Checa se imagem é jpg
                if(in_array($image["type"], $jpgArray)) {
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                //Gerando o nome da imagem
                $imageName = $produto->imageGenerateName();

                imagejpeg($imageFile, "./img/" . $imageName, 100);

                $produto->image = $imageName;
            } else {
                $message->setMessage("Tipo invalido de imagem, insira PNG ou JPG", "error", "back");   
            }
            
        }

        $produtoDAO->create($produto);

    } else {
        $message->setMessage("Preencha todo o formulario", "error", "back");  
    }

} else {
    $message->setMessage("Informações inválidas!", "error", "index.php");
}