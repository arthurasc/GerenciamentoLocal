<?php

    require_once('../connection.php');

    if(isset($_GET['s']))
    {
        try
        {
            $search = $conn->prepare('SELECT * FROM ' . $dbName . '.students WHERE nome LIKE "%' . $_GET['s'] . '%" ORDER BY nome ASC');
            $search->execute();
            echo json_encode($search->fetchAll());
        }
        catch(PDOException $e)
        {
            echo 'Erro:' . $e->getMessage();
        }
    }

    if(isset($_GET['si']))
    {
        try
        {
            $search = $conn->prepare('SELECT students.id,students.nome,students.dt_nasc,students.telefone,students.nome_resp,students.filiacao,students.telefone_resp,students.celular,students.rg,students.cpf,students.email,students.cidade,students.bairro,students.endereco,students.vencimento,students.numero, payments.*, class.sala, class.curso as Curso, class.horario, class.valor, class.desconto, (CASE WHEN DATEDIFF(payments.venc, payments.data) < 0 THEN payments.valor ELSE (payments.valor - payments.des) END) as valorPago FROM ' . $dbName . '.students, ' . $dbName . '.payments, ' . $dbName . '.class WHERE students.id = :i AND payments.aluno = students.id AND class.id = students.curso AND payments.valor_p = 1');
            $search->bindValue(':i', $_GET['i'], PDO::PARAM_STR);
            $search->execute();
            echo json_encode($search->fetchAll());
        }
        catch(PDOException $e)
        {
            echo 'Erro:' . $e->getMessage();
        }
    }

?>