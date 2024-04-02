<?php
require_once("templates/header.php");
require_once("dao/ProdutoDAO.php");

$ProdutoDAO = new ProdutoDAO($conn, $BASE_URL);

$LatestProduto = $ProdutoDAO->getLatestProduto();

?>

<?php foreach($LatestProduto as $produto): ?>
    <div class="carrinho-container">
            <div class="box">
                <img src="img/<?= $produto->image ?>"/>
                <a href="#" ><?= $produto->name_prod ?></a>
                <a href="#" >R$ <?= $produto->produto_preco ?></a>
                <a href="#" class="btn btn-primary rate-btn">Comprar</a>
            </div>        
                
    </div>
    <?php endforeach; ?>
<?php
require_once("templates/footer.php");
?>