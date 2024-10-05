 <?php
 session_start();

require '../Model/Outil.php';
$pdo = PdoInit();


//$user_id = $_SESSION["user_id"];
if (isset($_GET["debug"])) {
    $user_id = 1;
    
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
                
            </div>
            <?php include '../View/Footer.php'; ?>
        </body>
    </html>
    <script src="<?= GetUrl()?>/Model/js/Outil.js"></script>
    <script>
        var domain = "<?= GetUrl() ?>";
        var chatwindow = document.getElementsByClassName("chat-window")[0];
        var data = new FormData();
        data.append("user_id", "<?= $user_id ?>");
        data.append("searchby", "user_id");

        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4 && xhr.status === 200) {

                var response = JSON.parse(this.responseText);
                chatwindow.innerHTML = "";
                response.forEach(function (item) {
                    
                    chatwindow.innerHTML += "<a href='"+domain+"/controller/chatting.php?conv_id="+item.conv_id+"&debug=1'><div class='chat-conversation' style='border:solid'>\n\
        <div style='display: flex; justify-content: space-between;'>\n\
        <span>" + item.name + "</span></div></a>";
                });

            }
        });

        
            xhr.open("GET", domain + "/Model/api/participant.php?user_id=<?=$user_id?>&searchby=user_id");
            xhr.send(data);
        
    </script>


    <?php
}