<?php
session_start();

require '../Model/Outil.php';
$pdo = PdoInit();

$conv_id = $_REQUEST["conv_id"];
VerifyConnexion();

//if (VerifSession($pdo)) {
if (true) {
    ?>


<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Chat</title>
            <link rel="stylesheet" href="/style/styles.css">
            <link rel="stylesheet" href="/style/conversations.css">
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
                    <input type="HIDDEN" name="conv_id" value =<?= $conv_id ?>>

                    <button type="button" id="send">Envoyer</button>
                </form>
            </div>
            <?php include '../View/Footer.php'; ?>
        </body>
    </html>
    <script src="<?= GetUrl() ?>/Model/js/Outil.js"></script>
    <script>
        const conv_id = <?= $conv_id ?>;
        const user_id =<?=$user_id?>; //debug
        const domain = "<?= GetUrl() ?>";
    </script>
    <script src="<?= GetUrl() ?>/Model/js/Chatting.js"></script>


    <?php
}




