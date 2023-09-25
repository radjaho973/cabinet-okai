import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        
            // Récupérez tous les éléments de classe "accordion-toggle"
        const accordionToggles = document.querySelectorAll(".accordion-toggle");

        // Parcourez tous les titres de l'accordéon et ajoutez un gestionnaire d'événements clic
        accordionToggles.forEach((toggle) => {
            toggle.addEventListener("click", function () {
                // Récupérez le contenu de l'accordéon associé
                const content = this.nextElementSibling;
                
                // Basculer la classe "active" sur le titre pour le style
                this.classList.toggle("active");

                // Vérifiez si le contenu est visible ou caché
                if (content.style.display === "block") {
                    content.classList.toggle("active"); // Cacher le contenu
                } else {
                    content.classList.toggle("active");  // Afficher le contenu
                }
            });
        });
    }
}
