<?php
session_start();

require '../Model/Outil.php';
$pdo = PdoInit();

$conv_id = $_REQUEST["conv_id"];
//$user_id = $_SESSION['user_id'];
$user_id = $_SESSION["user_id"];
VerifyConnexion();

IsParticipant($user_id, $conv_id);


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="/style/styles.css">
    <link rel="stylesheet" href="/style/conversations.css">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
</head>

<body>

    <?php include '../View/Header.php'; ?>
    


    <div class="chat-container">
        <h2>Bienvenue !</h2>
        <div class="chat-window">
            <!-- Fenêtre de discussion en temps réel -->
            <!-- Affichage des messages -->
        </div>

        <form id="form">
            <input type="text" name="message" id="message" placeholder="Tapez votre message...">
            <input type="HIDDEN" name="conv_id" value=<?= $conv_id ?>>

            <button type="button" id="send">Envoyer</button>
        </form>
    </div>
    <div class="chat-container">
    <td colspan="2"><h2>Participants : </h2></td>
    <table class="list-participant">

    </table>
    </div>

    <?php include '../View/Footer.php'; ?>
</body>

</html>
<script src="<?= GetUrl() ?>/Model/js/Outil.js"></script>
<script>
    const conv_id = <?= $conv_id ?>;
    const user_id = <?= $user_id ?>;
    const domain = "<?= GetUrl() ?>";
</script>
<script src="<?= GetUrl() ?>/Model/js/Chatting.js"></script>


<?php
