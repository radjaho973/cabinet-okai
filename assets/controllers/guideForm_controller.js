import { Controller } from '@hotwired/stimulus';


export default class extends Controller {
    initialize() {
        //défini la taille de l'input description au chargement 
        let description = document.querySelector("#guide_description")
        description.style.height = ""
        description.style.height = description.scrollHeight + 3 + "px"
        description.addEventListener('input',()=>{
        //  console.log(description.scrollHeight);
            description.style.height = description.scrollHeight  + "px"
        })

        //change le label du champ fichier
        var input = document.querySelector( '#guide_image' );

        let label	 = document.querySelector('.custom-file-upload')
        let labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            console.log(this.files);
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

