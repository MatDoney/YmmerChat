<?php
session_start();

require '../Model/Outil.php';
$pdo = PdoInit();

$conv_id = $_REQUEST["conv_id"];
//$user_id = $_SESSION["user_id"];
if (isset($_GET["debug"])) {
    $user_id = 4;
    $participant_id = 7;
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
                <form action="send_message.php" method="POST">
                    <input type="text" name="message" placeholder="Tapez votre message...">
                    <input type="HIDDEN" name="conv_id" value =<?= $conv_id ?>>
                    <input type="HIDDEN" name="participant_id" value =<?= $participant_id ?>>
                    <button type="submit">Envoyer</button>
                </form>
            </div>
            <?php include '../View/Footer.php'; ?>
        </body>
    </html>
    <script src="<?= GetUrl()?>/Model/js/Outil.js"></script>
    <script>
        var domain = "<?= GetUrl() ?>";
        var chatwindow = document.getElementsByClassName("chat-window")[0];
        var data = new FormData();
        var firstload = true;
        data.append("conv_id", "<?= $conv_id ?>");
        data.append("searchby", "conv_id");

        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4 && xhr.status === 200) {

                var response = JSON.parse(this.responseText);
                chatwindow.innerHTML = "";
                response.forEach(function (item) {
                    
                    chatwindow.innerHTML += "<div class='chat-message' style='border:solid'>\n\
        <div style='display: flex; justify-content: space-between;'>\n\
        <span>" + item.username + "</span><span>" + item.date + "</span></div>\n\
        </br><span>" + item.texte + "</span></div>";
                });
                if(firstload) {
                    scrollToBottom(chatwindow);
                    firstload = !firstload;
                }
                

            }
        });

        setInterval(function () {
            xhr.open("GET", domain + "/Model/api/message.php?conv_id=<?= $conv_id ?>&searchby=conv_id");
            xhr.send(data);
            
        }, 1000);
        

        
    </script>


    <?php
}




