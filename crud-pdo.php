<?php
//-------------conexão------------------------
try 
{
    $pdo = new PDO("mysql:dbname=CRUDPDO;host=localhost","root","");
}
catch (PDOEXception $e) {
    echo "Erro com banco de dados: ".$e->getMessage();
}
catch(Exception $e) 
{
    echo "Erro generico: ".$e->getMessage();
}
// ---------------- INSERT ----------------------------------
//1 forma:
//    $res= $pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES (:n, :t, :e)");
//     $res->bindValue(":n", "Roberta");
//     $res->bindValue(":t", "1111");
//     $res->bindValue(":e", "Roberta@gmail.com");
//     $res->execute();

// 2 forma:

    // $pdo ->query("INSERT INTO pessoa(nome, telefone, email) VALUES('Paulo','2222','Paulo@gmail.com')");



//--------------- DELETE E UPDATE -------

// $cmd = $pdo-> prepare("DELETE FROM pessoa WHERE id = :id");
// $id = 2;
// $cmd->bindValue(":id",$id);
// $cmd->execute();
// OU
// $res = $pdo->query("DELETE FROM pessoa WHERE id = '3'");

// $cmd = $pdo->prepare("UPDATE pessoa SET email = :e WHERE id = :id");
// $cmd->bindValue(":e", "Miriam@gmail.com");
// $cmd->bindValue(":id",1);
// $cmd->execute();

// $res = $pdo->query("UPDATE pessoa SET email = 'Paulo2@hotmail.com' WHERE id = '4'");

// ----------------- SELECT ------------------------

$cmd = $pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
$cmd ->bindValue(":id",4);
$cmd -> execute();
$resultado = $cmd->fetch(PDO::FETCH_ASSOC);

foreach ($resultado as $key => $value)
{
    echo $key.": ".$value. "<br>";
}
?>