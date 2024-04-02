<?php

require_once("models/User.php");
require_once("models/Message.php");

//$message = new Message($BASE_URL);

class UserDAO implements UserDAOInterface {

    /* Conexão com banco de dados */
    private $conn;
    private $url;
    private $message;
    

    public function __construct(PDO $conn, $url){
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildUser($data){
        $user = new User();

        $user->id = $data["id"];
        $user->name = $data["name"];
        $user->lastname = $data["lastname"];
        $user->email = $data["email"];
        $user->gender = $data["gender"];
        $user->cpf = $data["cpf"];
        $user->password = $data["password"];
        $user->token = $data["token"];

        return $user;
    }
    public function create(User $user, $authUser = false){

        $stmt = $this->conn->prepare("INSERT INTO users(name, lastname, email, gender, cpf, password, token
        ) VALUES (:name, :lastname, :email, :gender, :cpf, :password, :token)");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":gender", $user->gender);
        $stmt->bindParam(":cpf", $user->cpf);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":token", $user->token);

        $stmt->execute();

        // Autenticar usuario, caso auth seja true
        if($authUser){
            $this->setTokenToSession($user->token);
        }

    }

    public function update(User $user, $redirect = true){

        $stmt = $this->conn->prepare("UPDATE users SET
        name = :name,
        lastname = :lastname,
        email = :email,
        cpf = :cpf,
        token = :token
        WHERE id = :id
        ");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":cpf", $user->cpf);
        $stmt->bindParam(":token", $user->token);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        if($redirect){
            $this->message->setMessage("Dados atualizados com sucesso", "success", "index.php");
        }

    }
    public function verifyToken($protected = false){

        if(!empty($_SESSION["token"])){

            $token = $_SESSION["token"];

            $user = $this->findByToken($token);

            if($user){
                return $user;
            } else if($protected){

                $this->message->setMessage("Faça a autenticação para acessar esta pagina.", "error", "index.php");
            }
        } else if($protected){

            $this->message->setMessage("Faça a autenticação para acessar esta pagina.", "error", "index.php");
            
        }

    }
    public function setTokenToSession($token, $redirect = true){

        // Salvar token na session
        $_SESSION["token"] = $token;

        if($redirect){
            $this->message->setMessage("Seja bem-vindo", "success", "editprofile.php");
        }

    }
    public function authenticateUser($email, $password){

        $user = $this->findByEmail($email);

        if($user){
            //verificação das senhas
            if(password_verify($password, $user->password)){

                //Gerar um token e inserir na session
                $token = $user->generateToken();

                $this->setTokenToSession($token, false);

                //Atualiza o token no usuario
                $user->token = $token;

                $this->update($user, false);

                return true;

            } else {
                return false;
            }
        } else {
             return false;
        }

    }
    
    public function findByEmail($email){

        if($email != ""){

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");

            $stmt->bindParam(":email", $email);

            $stmt->execute();

            if($stmt->rowCount() > 0){

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;

            } else {
                return false;
            }

        } else {
            return false;
        }

    }
    public function findById($id){

    }
    public function findByToken($token){

        if($token != ""){

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");

            $stmt->bindParam(":token", $token);

            $stmt->execute();

            if($stmt->rowCount() > 0){

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;

            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    public function destroyToken(){

        //Remove o token da session
        $_SESSION["token"] = "";

        $this->message->setMessage("Logout", "success", "index.php");
    }

    public function changePassword(User $user){

    }

}