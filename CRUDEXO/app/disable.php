<?php
// On démarre une session => utilisation $_SESSION
session_start();



// On va récupérer l'id de l'url puis vérifier si l'id existe ET SI il existe on affiche la page
// VERIFICATION DE L'ID => isset => existe t'il? // !empty => non null
if(isset($_GET['id']) && !empty($_GET['id']))
{
    // JE me connecte a la BDD
    require_once('connect.php');

    // On nettoie l'id envoyé contre injection sql
    $id = strip_tags($_GET['id']);

    $sql ='SELECT * FROM `liste` WHERE `id` = :id;';

    // On prepare requete
    $query = $db->prepare($sql);

    // On "accroche" les paramètres (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    //On execute la requete
    $query->execute();

    // on recupere le produit
    $produit = $query->fetch();
     
    // on verifie si le produit existe
    if(!$produit)
    {
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header("Location: index.php");
        die();
    }

    // Si $produit['actif'] == 0 => SI OUI = 1 SINON = 0
    $actif = ($produit['actif'] == 0) ? 1 : 0;

    $sql ='UPDATE `liste` SET `actif`=:actif WHERE `id` = :id;';

    // On prepare requete
    $query = $db->prepare($sql);

    // On "accroche" les paramètres (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':actif', $actif, PDO::PARAM_INT);

    //On execute la requete
    $query->execute();

    $_SESSION['message'] = "Statut changé";
    header("Location: index.php");
}
// SI il n'existe pas ou il n'y en a pas dans la bbd ALORS on redirige vers l'acceuil + alert ( produit inconnu )
else
{
    $_SESSION['erreur'] = "URL invalide";
    header("Location: index.php");
}
?>
