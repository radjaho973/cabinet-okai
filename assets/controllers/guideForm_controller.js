import { Controller } from '@hotwired/stimulus';


export default class extends Controller {
    //défini la taille de l'input description au chargement 
    initialize() {
        let description = document.querySelector("#guide_description") || document.querySelector('#contact_message')

        console.log(description.scrollHeight);
        description.addEventListener('input', () => {
            // hauteur min
            description.style.height = '60px';
        
            // Met à jour le texte area pour refléter la hauteur du contenu
            description.style.height = description.scrollHeight + 'px';
        });

        //change le label du champ fichier
        // inutile sur les formulaire de contact
        var input = document.querySelector( '#guide_image' );

        let label	 = document.querySelector('.custom-file-upload')
        let labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            
            if(this.files.length > 0){
                console.log(this.files);
                let file = this.files[0]
                label.innerHTML = file.name
                label.style.backgroundColor ="#26f07fcc"
            }else{
                label.innerHTML = labelVal
            }
        });
    }
}

