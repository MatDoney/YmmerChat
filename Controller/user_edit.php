<?php
session_start();
include '../Model/Outil.php';

VerifyConnexion();
$user_id = $_SESSION["user_id"];
if (isset($_POST["confirm"])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $num = $_POST['num'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    
    if(UpdateUser($username,$email,$nom,$prenom,$num,$user_id,$password,$passwordConfirm)) {
        echo '<p>Utilisateur modifié</p>';
    }else {
        echo '<p>Une erreur est survenue</p>';
    }

}

$result = GetUserInfo($user_id);

$username = $result[0]['username'];
$email = $result[0]['email'];
$nom = $result[0]['nom'];
$prenom = $result[0]['prenom'];
$num = $result[0]['num'];

?>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="/style/styles.css">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
</head>

<body>
    <?php include '../View/Header.php'; ?>
    <div class="chat-container">
        <h2>Modifer votre profil :</h2>
        <div class="chat-window">
            <form method="post" id="form">
                <table>

                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                    <input type="hidden" name="confirm" value="true">
                    <tr>
                        <td><label>Nom d'utilisateur : </label></br><input type="text" name="username"
                                value="<?= $username ?>" placeholder="username" required></td>
                        <td><label>Adresse Email : </label></br><input type="text" name="email" value="<?= $email ?>"
                                placeholder="email" required></td>
                    </tr>

                    <tr>
                        <td><label>Nom : </label></br><input type="text" name="nom" value="<?= $nom ?>"
                                placeholder="nom" required>
                        <td><label>Prenom : </label></br><input type="text" name="prenom" value="<?= $prenom ?>"
                                placeholder="prenom" required></td>
                    </tr>

                    <tr>
                        <td colspan="2"><label>Numéro de téléphone : </label></br><input type="text" name="num"
                                value="<?= $num ?>" placeholder="numéro de téléphone" pattern="^\d{1,10}$" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Mot de passe : </label></br><input type="password" name="password" placeholder="Mot de passe">
                        </td>
                        <td><label>Confirmer Mot de passe : </label></br><input type="password" name="passwordConfirm" placeholder="Confirmer Mot de passe">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Confirmer"></td>
                    </tr>

                </table>
            </form>
        </div>

    </div>
    <?php include '../View/Footer.php'; ?>
</body>
<script src="<?= GetUrl() ?>/Model/js/user_edit.js"></script>
</html>