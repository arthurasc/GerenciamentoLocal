<?php

    require_once('../connection.php');

    $request = json_decode(file_get_contents('php://input'));

    if(isset($request->nome_s))
    {
        try
        {
            $insert = $conn->prepare('INSERT INTO ' . $dbName . '.students VALUES (NULL, :nome_s, :dtnas, :tel, :npai, :fili, :telresp, :celresp, :rg, :cpf, :email, :cid, :bair, :ende, :numend, :room, "")');

            $insert->bindValue(':nome_s', $request->nome_s, PDO::PARAM_STR);
            $insert->bindValue(':dtnas', $request->dtnas, PDO::PARAM_STR);
            $insert->bindValue(':tel', $request->tel, PDO::PARAM_STR);
            $insert->bindValue(':npai', $request->npai, PDO::PARAM_STR);
            $insert->bindValue(':fili', $request->fili, PDO::PARAM_STR);
            $insert->bindValue(':telresp', $request->telresp, PDO::PARAM_STR);
            $insert->bindValue(':celresp', $request->celresp, PDO::PARAM_STR);
            $insert->bindValue(':rg', $request->rg, PDO::PARAM_STR);
            $insert->bindValue(':cpf', $request->cpf, PDO::PARAM_STR);
            $insert->bindValue(':email', $request->email, PDO::PARAM_STR);
            $insert->bindValue(':cid', $request->cid, PDO::PARAM_STR);
            $insert->bindValue(':bair', $request->bair, PDO::PARAM_STR);
            $insert->bindValue(':ende', $request->ende, PDO::PARAM_STR);
            $insert->bindValue(':numend', $request->numend, PDO::PARAM_STR);
            $insert->bindValue(':room', $request->room, PDO::PARAM_STR);

            $insert->execute();
        }
        catch(PDOException $e)
        {
            echo 'Erro:' . $e->getMessage();
        }
    }
    else
    {
        try
        {
            $search = $conn->prepare('SELECT * FROM ' . $dbName . '.students');
            $search->execute();
            echo json_encode($search->fetchAll());
        }
        catch(PDOException $e)
        {
            echo 'Erro:' . $e->getMessage();
        }
    }

?>