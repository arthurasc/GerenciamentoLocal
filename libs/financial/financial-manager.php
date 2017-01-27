<?php

    require_once('../connection.php');

    $request = json_decode(file_get_contents('php://input'));

    if(isset($_GET['s']))
    {
        try
        {
            if(isset($_GET['p']))
            {
                $search = $conn->prepare('SELECT payments.id, students.id as alunoId, students.nome, class.curso, class.horario, class.valor as valorCurso, class.desconto as descontoCurso, payments.venc, (CASE WHEN DATEDIFF(payments.venc, "' . date('Y-m-d') .  '") < 0 THEN payments.valor ELSE (payments.valor - payments.des) END) as valor FROM ' . $dbName . '.students, ' . $dbName . '.payments, ' . $dbName . '.class WHERE students.id = payments.aluno AND students.nome LIKE "%' . $_GET['s'] . '%" AND class.id = students.curso AND payments.valor_p = 0');
                $search->execute();
                echo json_encode($search->fetchAll());
            }
            else
            {
                $search = $conn->prepare('SELECT students.id, students.nome, class.curso, class.horario, class.valor, class.desconto FROM ' . $dbName . '.students, ' . $dbName . '.class WHERE class.id = students.curso AND students.vencimento = 0 AND students.nome LIKE "%' . $_GET['s'] . '%"');
                $search->execute();
                echo json_encode($search->fetchAll());
            }
        }
        catch(PDOException $e)
        {
            echo 'Erro:' . $e->getMessage();
        }
    }

    if(isset($_GET['i']))
    {
        try
        {
            $update = $conn->prepare('UPDATE ' . $dbName . '.students SET vencimento = :v WHERE id = :i');
            $update->bindValue(':v', $_GET['v'], PDO::PARAM_STR);
            $update->bindValue(':i', $_GET['i'], PDO::PARAM_STR);

            if($update->execute())
            {
                $insert = $conn->prepare('INSERT INTO ' . $dbName . '.payments VALUES(null, :i, :d, :vl, :des, :pag, 1)');
                $insert->bindValue(':i', $_GET['i'], PDO::PARAM_STR);
                $insert->bindValue(':d', date('Y-m-d'), PDO::PARAM_STR);
                $insert->bindValue(':vl', $_GET['vl'], PDO::PARAM_STR);
                $insert->bindValue(':des', $_GET['des'], PDO::PARAM_STR);
                $insert->bindValue(':pag', date('Y-m-d'), PDO::PARAM_STR);
                $insert->execute();
            }
        }
        catch(PDOException $e)
        {
            echo 'Erro:' . $e->getMessage();
        }
    }

    if(isset($_GET['b']))
    {
        $nextP = strftime("%Y-%m-%d", mktime (0, 0, 0, $request->mes + 1, $request->dia, $request->ano));

        $update = $conn->prepare('UPDATE ' . $dbName . '.payments SET valor_p = 1, data = "' . date('Y-m-d') . '" WHERE id = :i');
        $update->bindValue(':i', $request->id, PDO::PARAM_STR);

        if($update->execute())
        {
            $insert = $conn->prepare('INSERT INTO ' . $dbName . '.payments VALUES(null, :a, :v, :vl, :d, "", 0)');
            $insert->bindValue(':a', $request->aluno, PDO::PARAM_STR);
            $insert->bindValue(':v', $nextP, PDO::PARAM_STR);
            $insert->bindValue(':vl', $request->valor, PDO::PARAM_STR);
            $insert->bindValue(':d', $request->desconto, PDO::PARAM_STR);
            $insert->execute();
        }

    }

?>