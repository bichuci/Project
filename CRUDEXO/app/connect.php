<?php
// On se connecte a la base de données
try
{
    //Connexion de la base
    $db = new PDO('mysql:host=localhost;dbname=crud_liste', 'root', '');
    $db->exec('SET NAMES "UTF8"');
}
// On affiche une erreur si probleme de connection PDO EXECEPTION
catch (PDOException $e)
{
    echo 'Erreur : '. $e->getMessage();
    die();
}