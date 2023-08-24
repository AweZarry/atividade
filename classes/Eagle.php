<?php
include('conexao/conexao.php');

$db = new Conexao();

class eagle
{
    private $conn;
    private $table_name = "banquinho";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function cadastrar($nome, $email, $senha, $confSenha)
    {
        if ($senha === $confSenha) {

            $emailExistente = $this->verificarEmailExistente($email);
            if ($emailExistente) {
                print "<script> alert('Email ja cadastrado')</script>";
                return false;
            }

            $usuarioExistente = $this->verificarUsuarioExistente($nome);
            if ($usuarioExistente) {
                print "<script> alert('Usuario ja cadastrado')</script>";
                return false;
            }

            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO ". $this->table_name . " (nome, email, senha) VALUES (? ,? ,?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $senhaCriptografada);
            
            $rows = $this->read();
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
            return true;
        }else{
            return false;
        }
        
    }

    private function verificarEmailExistente($email)
    {
        $sql = "SELECT COUNT(*) FROM banquinho WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    private function verificarUsuarioExistente($nome)
    {
        $sql = "SELECT COUNT(*) FROM banquinho WHERE nome = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $nome);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function logar($nome, $senha)
    {
        $sql = "SELECT * FROM banquinho WHERE nome = :nome";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $eagle = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($senha, $eagle['senha'])) {
                return true;
            }
        }

        return false;
    }
    public function read(){
        $sql = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function update($postValues){
        
        $id = $postValues['id'];
        $nome = $postValues['nome'];
        $email = $postValues['email'];
        $senha = $postValues['senha'];

        if(empty($id) || empty($nome) || empty($email) || empty($senha)){
            return false;
        }
        
        $sql = "UPDATE ". $this->table_name . " SET nome = ?, email = ?, senha = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1,$nome);
        $stmt->bindParam(2,$email);
        $stmt->bindParam(3,$senha);
        $stmt->bindParam(6,$id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
        public function readOne($id){
            $sql = "SELECT * FROM ". $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }



}

?>
