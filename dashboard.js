document.addEventListener("DOMContentLoaded", function () {
    const amisEnLigne = ["Alice", "Bob", "Charlie"];  // Exemple d'amis en ligne
    const amisEl = document.getElementById("amis-en-ligne");  // L'élément cliquable
    const modal = document.getElementById("modal-amis");  // La modale à afficher
    const closeModal = document.getElementById("close-modal");  // Bouton de fermeture de la modale
    const listeAmis = document.getElementById("liste-amis");  // Liste des amis dans la modale
  
    // Ajouter un écouteur d'événements pour l'élément "Amis en ligne"
    if (amisEl) {
      amisEl.addEventListener("click", function () {
        // Réinitialiser la liste des amis
        listeAmis.innerHTML = "";
        amisEnLigne.forEach(ami => {
          const li = document.createElement("li");
          li.textContent = ami;
          listeAmis.appendChild(li);
        });
        // Afficher la modale
        modal.style.display = "block";
      });
    }
  
    // Ajouter un écouteur d'événements pour fermer la modale
    closeModal.addEventListener("click", function () {
      modal.style.display = "none";
    });
  
    // Fermer la modale si on clique en dehors de celle-ci
    window.addEventListener("click", function (event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });
  });