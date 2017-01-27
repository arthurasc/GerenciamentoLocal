<?php

    require_once('../connection.php');

    try
    {
        $dbName = $dbName . '.' . $_GET['t'];
        $delete = $conn->prepare('DELETE FROM ' . $dbName . ' WHERE id = :i');
        $delete->bindValue(':i', $_GET['i'], PDO::PARAM_INT);
        $delete->execute();
    }
    catch(PDOException $e)
    {
        echo 'Erro:' . $e->getMessage();
    }

?>