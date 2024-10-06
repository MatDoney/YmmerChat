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

function getMessageContinu(conv_id, chatwindow, site_root, participant_id) {

    var nbmessage = 0;

    var xhrGet = new XMLHttpRequest();
    xhrGet.withCredentials = true;
    xhrGet.addEventListener("readystatechange", function () {
        if (this.readyState === 4 && xhrGet.status === 200) {

            var response = JSON.parse(this.responseText);
            chatwindow.innerHTML = "";
            response.forEach(function (item) {
                chatmessage = "<div class='chat-message' style='border:solid'>\n\
        <div style='display: flex; justify-content: space-between;'>\n\
        <span>" + item.username + "</span><span>" + item.date + "</span>\n";

                if (item.participant_id === participant_id) {
                    chatmessage += "<button class='deleteMessage' id='" + item.id + "'>🗑</button>";
                }
                chatmessage += "</div>\n\
        </br><span>" + item.texte + "</span></div>";
                chatwindow.innerHTML += chatmessage;
            });
            if (nbmessage !== response.length) {
                scrollToBottom(chatwindow);
                nbmessage += response.length;
            }
            var deleteMessage = document.getElementsByClassName("deleteMessage");
            Array.from(deleteMessage).forEach(function (element) {
                element.addEventListener("click", function () {

                    DeleteMessageById(element.id, site_root);
                });
            });


        }
    });
    setInterval(function () {
        xhrGet.open("GET", site_root + "/Model/api/message.php?conv_id=" + conv_id + "&searchby=conv_id");
        xhrGet.send();
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


function getConversationsByUserID(user_id, site_root, chatwindow) {
    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4 && xhr.status === 200) {

            var response = JSON.parse(this.responseText);
            chatwindow.innerHTML = "";
            response.forEach(function (item) {

                chatwindow.innerHTML += "<a href='" + site_root + "/controller/chatting.php?conv_id=" + item.conv_id + "&debug=1'><div class='chat-conversation' style='border:solid'>\n\
        <div style='display: flex; justify-content: space-between;'>\n\
        <span>" + item.name + "</span></div></a>";
            });

        }
    });

    setInterval(function () {
        xhr.open("GET", site_root + "/Model/api/participant.php?user_id=" + user_id + "&searchby=user_id");
        xhr.send();
    }, 250);

}

function DeleteMessageById(message_id, site_root) {
    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {

        }
    });

    xhr.open("DELETE", site_root + "/Model/api/message.php?message_id=" + message_id);

    xhr.send();
}
