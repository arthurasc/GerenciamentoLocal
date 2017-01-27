<?php

    require_once('connection.php');

    try
    {
        $request = json_decode(file_get_contents("php://input"));

        $search = $conn->prepare('SELECT * FROM ' . $dbName . '.users WHERE login = :l AND senha = :s');
        $search->bindValue(':l', $request->l, PDO::PARAM_STR);
        $search->bindValue(':s', $request->s, PDO::PARAM_STR);
        $search->execute();
        echo json_encode($search->fetchAll());
    }
    catch(PDOException $e)
    {
        echo 'Erro:' . $e->getMessage();
    }

?>