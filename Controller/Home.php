 <?php
 session_start();

require '../Model/Outil.php';
$pdo = PdoInit();

VerifyConnexion();

$user_id = $_SESSION["user_id"];
//if (isset($_GET["debug"])) {
//    $user_id = 2;
//    
//}

//if (VerifSession($pdo)) {
if (true) {
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
                <h2>Conversations :</h2>
                <div class="chat-window">
                    <!-- Fenêtre de discussion en temps réel -->
                    <!-- Affichage des messages -->
                </div>
                
            </div>

              <!-- créer une nouvelle conversation -->
              <div class="new-conversation">
                <a href="NewConversation.php">
                    <button type="button" class="btn btn-primary">Créer une nouvelle conversation</button>
                </a>
            </div>

            <?php include '../View/Footer.php'; ?>
        </body>
    </html>
    <script src="<?= GetUrl()?>/Model/js/Outil.js"></script>
    <script>
        var domain = "<?= GetUrl() ?>";
        var chatwindow = document.getElementsByClassName("chat-window")[0];
        var user_id = <?=$user_id?>;

        getConversationsByUserID(user_id, domain, chatwindow) 
        
    </script>


    <?php
}