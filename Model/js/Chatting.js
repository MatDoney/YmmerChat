//Declaration des variables

var chatwindow = document.getElementsByClassName("chat-window")[0];
var listparticipant = document.getElementsByClassName("list-participant")[0];
var send = document.getElementById("send");
var form = document.getElementById("form");
var input = document.getElementById("message");
var AddUser = document.getElementById("AddUser");
var searchbar = document.getElementById("searchbar");
var titre = document.getElementById("titre");
var titrechange = document.getElementById("titre-change");;
var editTitre = document.getElementById("edit-titre");


var participant_id = GetParticipant_id(conv_id, user_id, domain);

// ----Récupération automatique des derniers messages de la conversation
getMessageContinu(conv_id, chatwindow, domain,participant_id,titre);
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

AddUser.addEventListener("click", function() {
    AddParticipant(conv_id, searchbar.value,domain);
    searchbar.value = "";
})

editTitre.addEventListener("click", (event) => {
    
    if (titre.style.display !== 'none') {
        // Passer en mode édition
        titre.style.display = 'none';  // Cacher le titre non éditable
        titrechange.style.display = 'flex';  // Afficher l'input éditable
        titrechange.removeAttribute('readonly');  // Permettre l'édition
        titrechange.value = titre.innerHTML;  // Remplir l'input avec la valeur du titre
        editTitre.innerHTML = "💾";  // Changer le bouton en icône de sauvegarde
    } else {
        // Sauvegarder le titre et revenir en mode lecture
        titrechange.setAttribute('readonly', true);  // Désactiver l'édition
        titre.innerHTML = titrechange.value;  // Mettre à jour le titre non éditable avec la nouvelle valeur
        editTitle(conv_id, titrechange.value, domain);
        titre.style.display = 'flex';  // Afficher le titre non éditable
        titrechange.style.display = 'none';  // Cacher l'input éditable
        editTitre.innerHTML = "✏️";  // Revenir à l'icône d'édition
    }
    
});


