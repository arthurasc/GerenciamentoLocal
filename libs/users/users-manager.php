<?php

    require_once('../connection.php');

    $request = json_decode(file_get_contents('php://input'));

    if(!isset($request->l))
    {
        try
        {
            $search = $conn->prepare('SELECT * FROM ' . $dbName . '.users ORDER BY nivel ASC, login ASC');
            $search->execute();
            echo json_encode($search->fetchAll());
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
            $insert = $conn->prepare('INSERT INTO ' . $dbName . '.users VALUES (null, :l, "0000", :n)');
            $insert->bindValue(':l', $request->l, PDO::PARAM_STR);
            $insert->bindValue(':n', $request->n, PDO::PARAM_STR);

            if($insert->execute())
            {
                $search = $conn->prepare('SELECT * FROM ' . $dbName . '.users ORDER BY nivel ASC, login ASC');
                $search->execute();
                echo json_encode($search->fetchAll());
            }
        }
        catch(PDOException $e)
        {
            echo 'Erro:' . $e->getMessage();
        }
    }

?>