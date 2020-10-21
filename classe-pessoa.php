<?php

Class Pessoa{

    private $pdo;

    // Conexão com o banco de dados
    public function __construct($dbname, $host, $user, $senha)
    {
        try
        {
           $this-> pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
        }
        catch (PDOException $e) {
            echo "Erro com banco de dados: ".$e->getMessage();
            exit();
        }
        catch (Exception $e) {
            echo "Erro genérico: ".$e->getMessage();
            exit();
        }
    }
    //funcao para buscar dados e colocar no canto direito
    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    //funcao de cadastrar pessoas no banco de dados
    public function cadastrarPessoa($nome, $telefone, $email)
    {
        //antes do cadastro checa se já existe o email
        $cmd = $this->pdo->prepare("SELECT id from pessoa where email = :e");
        $cmd->bindValue(":e",$email);
        $cmd->execute();
        if($cmd->rowCount() > 0) //email ja existe no banco
        {
            return false;
        }else //nao foi encontrado o email
        {
            $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
            $cmd-> bindValue(":n",$nome);
            $cmd-> bindValue(":t",$telefone);
            $cmd-> bindValue(":e",$email);
            $cmd-> execute();
            return true;
        }
    }

    public function excluirPessoa($id)
    {
        $cmd = $this->pdo->prepare("delete from pessoa where id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }

    //buscar dados de uma pessoa
    public function buscarDadosPessoa($id)
    {
        $res = array();
        $cmd = $this->pdo->prepare("select * from pessoa where id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    //ATUALIZAR DADOS NO BANCO DE DADOS

    public function atualizarDados($id, $nome, $telefone, $email)
    {
        $cmd = $this->pdo->prepare("update pessoa set nome = :n, telefone = :t, email = :e where id = :id");
        $cmd->bindValue(":n",$nome);
        $cmd->bindValue(":t",$telefone);
        $cmd->bindValue(":e",$email);
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        return true;
    }
}
?>