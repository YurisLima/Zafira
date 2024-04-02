<?php
    require_once("models/Produto.php");
    require_once("models/Message.php");

    class ProdutoDAO implements ProdutoDAOInterface {

        private $conn;
        private $url;
        private $message;
        
    
        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildProduto($data){
            $produto = new Produto();

            $produto->id = $data["id"];
            $produto->name_prod = $data["name_prod"];
            $produto->produto_name = $data["produto_name"];
            $produto->produto_descricao = $data["produto_descricao"];
            $produto->produto_preco = $data["produto_preco"];
            $produto->image = $data["image"];
    
            return $produto;
        }
        public function findAll($data){

        }

        public function getLatestProduto(){

            $produto = [];

            $stmt = $this->conn->query("SELECT * FROM produto ORDER BY id DESC");
      
            $stmt->execute();
      
            if($stmt->rowCount() > 0) { 
      
              $produtoArray = $stmt->fetchAll();
              
              foreach($produtoArray as $produto) {
                $movies[] = $this->buildProduto($produto);
              }
              
            }
      
            return $movies;
      
          }

        public function findById($id){

        }
        public function findByName($produto_name){

        }
        public function create(Produto $produto){

            $stmt = $this->conn->prepare("INSERT INTO produto (name_prod, produto_name, produto_descricao, produto_preco, image) VALUES (:name_prod, :produto_name, :produto_descricao, :produto_preco, :image)");

            $stmt->bindParam(":name_prod", $produto->name_prod);
            $stmt->bindParam(":produto_name", $produto->produto_name);
            $stmt->bindParam(":produto_descricao", $produto->produto_descricao);
            $stmt->bindParam(":produto_preco", $produto->produto_preco);
            $stmt->bindParam(":image", $produto->image);
            
            $stmt->execute();

            $this->message->setMessage("Filme adicionado com sucesso.", "success", "index.php");

        }
        public function update(Produto $produto){

        }
        public function destroy($id){

        }

    }