<?php
// On démarre une session => utilisation $_SESSION
session_start();

//On verifie que j'ai bien des données a envoyer
if($_POST)
{
    #die('Ca marche'); 
    //Je vérifie si j'ai des données dans mes champs du formulaire
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['produit']) && !empty($_POST['produit'])
    && isset($_POST['prix']) && !empty($_POST['prix'])
    && isset($_POST['nombre']) && !empty($_POST['nombre']))
    {
        // On inclut la connexion à la base ( require_once ne l'incult qu'une fois)
        require_once('connect.php');
        // On nettoie les données envoyées
        $id = strip_tags($_POST['id']);
        $produit = strip_tags($_POST['produit']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);

        $sql ='UPDATE `liste` SET `produit`=:produit,`prix`=:prix,`nombre`=:nombre WHERE `id`=:id';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':produit', $produit, PDO::PARAM_STR);
        $query->bindValue(':prix', $prix, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

        $query->execute();

        // Un message pour dire que produit ajouté
        $_SESSION['message'] = "Produit modifié avec succés";
       
        require_once('close.php');
       
        header('Location: index.php');
    }
    else
    {
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

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
    <title>Modifier un produit</title>

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
                <h1>Modifier le produit : <?= $produit['produit']?></h1>
                <form method ="post">
                    <div class="form-group">
                        <label for="produit">Produit</label>
                        <input type="text" id="produit" name="produit" class="form-control" value="<?= $produit['produit'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input type="text" id="prix" name="prix" class="form-control" value="<?= $produit['prix'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="number" id="nombre" name="nombre" class="form-control" value="<?= $produit['nombre'] ?>">
                    </div>
                    <!-- NE SURTOUT PAS OUBLIER DE METTRE UN INPUT HIDDEN POUR AJOUTER L'ID, SINON BUG -->
                    <input type="hidden" value="<?= $produit['id']?>" name="id">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
