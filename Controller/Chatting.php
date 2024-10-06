<?php
session_start();

require '../Model/Outil.php';
$pdo = PdoInit();

$conv_id = $_REQUEST["conv_id"];
//$user_id = $_SESSION["user_id"];
if (isset($_GET["debug"])) {
    $user_id = 2;
}

//if (VerifSession($pdo)) {
if (true) {
    ?>



    <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Chat</title>
            <link rel="stylesheet" href="/style/styles.css">
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
        //Declaration des variables
        const domain = "<?= GetUrl() ?>";
        var chatwindow = document.getElementsByClassName("chat-window")[0];
        var send = document.getElementById("send");
        var form = document.getElementById("form");
        var input = document.getElementById("message");
        const conv_id = <?= $conv_id ?>;
        const user_id =<?=$user_id?>; //debug
        var participant_id = GetParticipant_id(conv_id, user_id, domain);

        // ----Récupération automatique des derniers messages de la conversation
        getMessageContinu(conv_id, chatwindow, domain,participant_id);
        // ---- FIN récupération automatique des messages

        // ---- Envoie de messages
        send.addEventListener("click", function () {
            sendMessage(input, participant_id, domain);
        });
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Empêche le formulaire de se soumettre
            sendMessage(input, participant_id, domain);
        });

    </script>


    <?php
}




