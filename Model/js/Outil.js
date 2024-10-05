/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

function scrollToBottom(div) {
    div.scrollTop = div.scrollHeight; // Fait défiler jusqu'en bas de la div
}

function sendMessage(input, participant_id, site_root) {
    if (input.value !== "" || input.value !== null) {
        var dataSend = new FormData();
        dataSend.append("texte", input.value);
        dataSend.append("participant_id", participant_id);

        var xhrSend = new XMLHttpRequest();
        xhrSend.withCredentials = true;

        xhrSend.open("POST", site_root + "/Model/api/message.php");

        xhrSend.send(dataSend);
        input.value = "";
    }
}

function getMessageContinu(conv_id, chatwindow, site_root) {
    var data = new FormData();
    var nbmessage = 0;
    data.append("conv_id", conv_id);
    data.append("searchby", "conv_id");
    var xhrGet = new XMLHttpRequest();
    xhrGet.withCredentials = true;
    xhrGet.addEventListener("readystatechange", function () {
        if (this.readyState === 4 && xhrGet.status === 200) {

            var response = JSON.parse(this.responseText);
            chatwindow.innerHTML = "";
            response.forEach(function (item) {
                chatwindow.innerHTML += "<div class='chat-message' style='border:solid'>\n\
        <div style='display: flex; justify-content: space-between;'>\n\
        <span>" + item.username + "</span><span>" + item.date + "</span></div>\n\
        </br><span>" + item.texte + "</span></div>";
            });
            if (nbmessage !== response.length) {
                scrollToBottom(chatwindow);
                nbmessage += response.length;
            }


        }
    });
    setInterval(function () {
        xhrGet.open("GET", site_root + "/Model/api/message.php?conv_id=" + conv_id + "&searchby=conv_id");
        xhrGet.send(data);
    }, 250);
}

function GetParticipant_id(conv_id, user_id, site_root) {
    var xhr = new XMLHttpRequest();

    // Ouvrir la requête en mode synchrone (false pour rendre la requête synchrone)
    xhr.open("GET", site_root + "/Model/api/participant.php?conv_id=" + conv_id + "&user_id=" + user_id + "&searchby=both", false);

    xhr.withCredentials = true;

    // Envoyer la requête
    xhr.send();

    // Vérifier l'état de la requête
    if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText)[0];
        
        return response.participant_id;  // Ici on peut retourner directement car la méthode est synchrone
        
    } else {
        
        return null;
    }

}
