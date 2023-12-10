
// Affichage du menu déroulant au survol de la souris
const dropdownItems = document.querySelectorAll('.with-dropdown');

// On parcourt tous les éléments avec la classe .with-dropdown
dropdownItems.forEach(item => {
  item.addEventListener('mouseenter', () => {
    item.querySelector('.dropdown').style.display = 'block';
  });

  item.addEventListener('mouseleave', () => {
    item.querySelector('.dropdown').style.display = 'none';
  });
});


// Redirection des onglets

function Accueil(){
  window.location.href = "/"
}

function Historique(){
  window.location.href = "/page/harmonie/historique.php"
}

function Direction(){
  window.location.href = "/page/harmonie/direction.php"
}

function Commission(){
  window.location.href = "/page/harmonie/commission.php"
}

function Repetition(){
  window.location.href = "/page/harmonie/repetition.php"
}

function Calendrier(){
  window.location.href = "/page/harmonie/calendrier.php"
}

function Ecole(){
  window.location.href = "/page/ecole.php"
}

function Espace(){
  window.location.href = "/page/espace_membre/user_info.php"
}

function Contact(){
  window.location.href = "/page/contact.php"
}

function Instrument(){
  window.location.href = "/page/administration/instrument.php"
}

function Musicien(){
  window.location.href = "/page/administration/musicien.php"
}
function Ajout(){
  window.location.href = "/page/administration/ajout.php"
}
function Eleves(){
  window.location.href = "/page/administration/eleves.php"
}

function Sortie(){
  window.location.href = "/page/administration/sortie.php"
}

function sortieuser(){
  window.location.href = "/page/espace_membre/presence_sortie.php"
}