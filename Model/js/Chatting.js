//Declaration des variables

var chatwindow = document.getElementsByClassName("chat-window")[0];
var listparticipant = document.getElementsByClassName("list-participant")[0];
var send = document.getElementById("send");
var form = document.getElementById("form");
var input = document.getElementById("message");


var participant_id = GetParticipant_id(conv_id, user_id, domain);

// ----Récupération automatique des derniers messages de la conversation
getMessageContinu(conv_id, chatwindow, domain,participant_id);
// ---- FIN récupération automatique des messages
scrollToBottom(chatwindow);
// ---- Envoie de messages
send.addEventListener("click", function () {
    sendMessage(input, participant_id, domain);
    scrollToBottom(chatwindow);
});
form.addEventListener("submit", function (event) {
    event.preventDefault(); // Empêche le formulaire de se soumettre
    sendMessage(input, participant_id, domain);
});
// ---- Récupération des participants à la conversation
GetParticipantByConvID(conv_id,participant_id, listparticipant, domain);




