<?php

    require_once('../connection.php');

    $request = json_decode(file_get_contents('php://input'));

    if(isset($request->s))
    {
        try
        {
            $insert = $conn->prepare('INSERT INTO ' . $dbName . '.class VALUES(null, :s, :c, :h, :v, :d)');
            $insert->bindValue(':s', $request->s, PDO::PARAM_STR);
            $insert->bindValue(':c', $request->c, PDO::PARAM_STR);
            $insert->bindValue(':h', $request->h, PDO::PARAM_STR);
            $insert->bindValue(':v', $request->v, PDO::PARAM_STR);
            $insert->bindValue(':d', $request->d, PDO::PARAM_STR);

            if($insert->execute())
            {
                $search = $conn->prepare('SELECT * FROM ' . $dbName . '.class ORDER BY sala, horario ASC');
                $search->execute();
                echo json_encode($search->fetchAll());
            }

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
            $search = $conn->prepare('SELECT * FROM ' . $dbName . '.class ORDER BY sala, horario ASC');
            $search->execute();
            echo json_encode($search->fetchAll());
        }
        catch(PDOException $e)
        {
            echo 'Erro:' . $e->getMessage();
        }
    }

?>