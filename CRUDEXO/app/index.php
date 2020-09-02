<?php
// On démarre une session => utilisation $_SESSION
session_start();

// On inclut la connexion à la base ( require_once ne l'incult qu'une fois)
require_once('connect.php');

$sql = 'SELECT * FROM `liste`';

//On prépare la requete
$query = $db->prepare($sql);

//On execute la requete
$query->execute();

// On stocke le résultat dans un tableau associatif 
// PDO::FETCH_ASSOC => permet de renvoyer uniquement les résultat des colonnes
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur']))
                    {
                        echo '<div class="alert alert-danger" role="alert">
                                '.$_SESSION['erreur'].'
                        </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <?php
                    if(!empty($_SESSION['message']))
                    {
                        echo '<div class="alert alert-success" role="alert">
                                '.$_SESSION['message'].'
                        </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
                <h1>Liste des produits</h1>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Produits</th>
                        <th>Prix</th>
                        <th>Nombres</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </thead>

                    <tbody>
                        <?php
                        // On boucler pour afficher les resultats
                            foreach($result as $produit)
                            {
                                ?>
                                    <tr>
                                        <td><?= $produit ['id'] ?></td>
                                        <td><?= $produit ['produit'] ?></td>
                                        <td><?= $produit ['prix'] ?></td>
                                        <td><?= $produit ['nombre'] ?></td>
                                        <td><?= $produit ['actif'] ?></td>
                                        <td>
                                            <a href="disable.php?id=<?= $produit['id']?>" class="btn btn-primary">Activer/Désactiver</a>
                                            <a href="details.php?id=<?= $produit['id']?>" class="btn btn-primary">Voir</a>
                                            <a href="edit.php?id=<?= $produit['id']?>" class="btn btn-secondary">Modifier</a>
                                            <a href="delete.php?id=<?= $produit['id']?>" class="btn btn-danger">Supprimer</a> 
                                        </td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table> 
                <a href="add.php" class="btn btn-success"> Ajouter un produit</a>
            </section>
        </div>
    </main>
</body>
</html>
