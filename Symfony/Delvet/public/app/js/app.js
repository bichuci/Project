/**
 * Codons un chat en HTML/CSS/Javascript avec nos amis PHP et MySQL
 */

/**
 * Il nous faut une fonction pour récupérer le JSON des
 * messages et les afficher correctement
 */
function pressEnter(event) {
  var code=event.which || event.keyCode; //Selon le navigateur c'est which ou keyCode
  if (code==13) { //le code de la touche Enter
      document.querySelector('form.chatform').submit();
  }
}
function checkvalue(){
  var check=document.querySelector('chatform');
  console.log(check);
  if(check != "null") {
    return true;
  }
  else {
    alert("Saisissez votre message");
    return false;
  }

}

function getMessages(){
  // 1. Elle doit créer une requête AJAX pour se connecter au serveur, et notamment au fichier handler.php
  const requeteAjax = new XMLHttpRequest();
  requeteAjax.open("GET","/messages");

  // 2. Quand elle reçoit les données, il faut qu'elle les traite (en exploitant le JSON) et il faut qu'elle affiche ces données au format HTML
  requeteAjax.onload = function(){
    const resultat = JSON.parse(requeteAjax.responseText);
    const html = resultat.map(function(message){
      return `
        <div class="message">
          <span class="date">${message.createdAt.substring(0, 16)}</span>
          <span class="author">${message.author}</span> : 
          <span class="content">${message.content}</span>
        </div>
      `
    }).join('');

    const messages = document.querySelector('.messages');

    messages.innerHTML = html;
    messages.scrollTop = messages.scrollHeight;
  }

  // 3. On envoie la requête
  
  requeteAjax.send();
}

/**
 * Il nous faut une fonction pour envoyer le nouveau
 * message au serveur et rafraichir les messages
 */
document.querySelector('form.chatform').addEventListener('submit', function(e){
  e.preventDefault();
  postMessage(e);
  checkvalue();
  });

function postMessage(event){
  // 1. Elle doit stoper le submit du formulaire

  // 2. Elle doit récupérer les données du formulaire
  const author = document.querySelector('#author');
  const content = document.querySelector('#content');

  // 3. Elle doit conditionner les données
  const data = new FormData();
  data.append('content', content.value);

  // 4. Elle doit configurer une requête ajax en POST et envoyer les données
  const requeteAjax = new XMLHttpRequest();
  requeteAjax.open('POST', '/addmessage');
  
  requeteAjax.onload = function(){
    content.value = '';
    content.focus();
    getMessages();
  }

  requeteAjax.send(data);
}



/**
 * Il nous faut une intervale qui demande le rafraichissement
 * des messages toutes les 3 secondes et qui donne 
 * l'illusion du temps réel.
 */
const interval = window.setInterval(getMessages, 3000);

getMessages();