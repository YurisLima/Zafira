<?php

class Produto {

    public $id;
    public $name_prod;
    public $produto_name;
    public $produto_descricao;
    public $produto_preco;
    public $image;

    public function imageGenerateName() {
        return bin2hex(random_bytes(60)) . "jpg";
    }

}

interface ProdutoDAOInterface {

    public function buildProduto($data);
    public function findAll($data);
    public function getLatestProduto();
    public function findById($id);
    public function findByName($produto_name);
    public function create(Produto $produto);
    public function update(Produto $produto);
    public function destroy($id);

}