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
    }
}
// SI il n'existe pas ou il n'y en a pas dans la bbd ALORS on redirige vers l'acceuil + alert ( produit inconnu )
else
{
    $_SESSION['erreur'] = "URL invalide";
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Détails du produit</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails du produit <?= $produit['produit'] ?></h1>
                <p>ID : <?= $produit['id'] ?></p>
                <p>Produit : <?= $produit['produit'] ?></p>
                <p>Prix : <?= $produit['prix'] ?></p>
                <p>Nombre : <?= $produit['nombre'] ?></p>
                <p><a href="index.php" class="btn btn-secondary"> Retour</a> <a href="edit.php?id=<?= $produit['id'] ?>" class="btn btn-primary"> Modifier </a></p>

            </section>
        </div>
    </main>
</body>
</html>
