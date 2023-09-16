import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        let selector = this.element

        let selectorDisplay = selector.children[0]
        let selectorLinkContainer = selector.children[1]
        // transforme l'HTMLCollection en tableau
        let links = Array.from(selectorLinkContainer.children)
        let cards = Array.from(selectorDisplay.children)
        
        let cardsArray = []

        cards.forEach(card =>{
            //On récupère l'id de chaque carte et on le stocke dans un objet
            let cardId = parseInt(card.getAttribute("id"))
            let cardObject = { id : cardId, card : card}
            cardsArray.push(cardObject)
        })
    
        links.forEach(link =>{
            link.addEventListener('click',displayCard)
        })


        function displayCard() {
            let idNumber = parseInt(this.getAttribute("id"))
            //si l'id demandé est dans le tableau des cartes
            //alors on l'affiche
            cardsArray.forEach(cardObject =>{
               
                if (idNumber == cardObject.id) {

                    cardObject.card.classList.add("sel-card-show")

                }else{

                    cardObject.card.classList.replace("sel-card-show","sel-card-hidden")
                    cardObject.card.classList.add("sel-card-hidden")
                }
            })

        }
    }
}
