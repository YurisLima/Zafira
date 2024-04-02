<?php

require_once("templates/header.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");

$user = new User();

$userDAO = new UserDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken(true);

$fullName = $user->getFullName($userData);

?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <form action="user_process.php" method="POST">
                <input type="hidden" name="type" value="update">
                <div class="row">
                    <div class="col-md-4">
                      <h1><?= $fullName ?></h1>
                      <p class="page-description"> Alteração de cadastro:</p>                      
                      <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu Nome" value="<?= $userData->name ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite seu Sobrenome" value="<?= $userData->lastname ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail:</label>
                        <input type="email" readonly class="form-control disabled" id="email" name="email" placeholder="Digite seu E-Mail" value="<?= $userData->email ?>">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gênero:</label>
                        <input type="text" class="form-control" id="gender" name="gender" placeholder="Digite seu Gênero" value="<?= $userData->gender ?>">
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite seu CPF" value="<?= $userData->cpf ?>">
                    </div>
                        <input type="submit" class="btn card-btn" value="Alterar">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
require_once("templates/footer.php");
?>