<?php
require_once("templates/header.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");

$user = new User();

$userDAO = new UserDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken(true);
?>

<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md4 new-produto-container">
        <h1 class="page-description">Adicionar Produtos</h1>
        <form action="<?= $BASE_URL ?>produto_process.php" id="add-produto-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="type" value="create">
        <div class="form-group">
            <label for="name_prod">Nome Teste:</label>
            <input type="text" class="form-control" id="name_prod" name="name_prod" placeholder="Digite o Nome do produto">
        </div><div class="form-group">
            <label for="produto_name">Nome:</label>
            <input type="text" class="form-control" id="produto_name" name="produto_name" placeholder="Digite o Nome do produto">
        </div>
        <div class="form-group">
            <label for="image">Imagem:</label>
            <input type="file" class="form-control-file" id="image" name="image" placeholder="Digite o Nome do produto">
        </div>
        <div class="form-group">
            <label for="produto_preco">Preço:</label>
            <input type="text" class="form-control" id="produto_preco" name="produto_preco" placeholder="Digite o Preço do produto">
        </div>
        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea name="produto_descricao" rows="5" class="form-control" id="produto_descricao" name="produto_descricao" placeholder="Descreva sobre o produto"></textarea>
        </div>
        <input type="submit" class="btn card-btn" value="Adicionar Produto">
        </form>
    </div>
</div>
<?php
require_once("templates/footer.php");
?>