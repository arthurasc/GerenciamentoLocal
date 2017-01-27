<?php

    $dbName = 'rcmanager';

    try
    {
        $conn = new PDO('mysql:host=localhost;dbName=$dbName', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo 'Erro:' . $e->getMessage();
    }

?>