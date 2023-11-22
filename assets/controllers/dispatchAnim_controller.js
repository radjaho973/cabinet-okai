import { Controller } from '@hotwired/stimulus';
// Ce script permet de décider i l'animation doit s'éxécuter ou non 
// permet également de la mettre en pause
export default class extends Controller {
    
    iconWrapper = document.querySelector('#anim-handle')
    icon = this.iconWrapper.firstElementChild
    citylinesController = document.querySelector('#canvas')
    isAnimating = true
    
    initialize(){
        // appel la fonction au chargement, au changement de page
        
        this.animDispatch()
       
        document.addEventListener('swup:contentReplaced', () => {
            this.animDispatch()
        });
        
        this.iconWrapper.addEventListener('click',()=>{
            this.isAnimating = !this.isAnimating
            this.toggleAnim()
        })
    }
    
    toggleAnim(){
        if (this.isAnimating) {
            this.icon.classList.replace("bi-play","bi-pause")
            this.citylinesController.setAttribute("data-controller","cityline")
            this.citylinesController.style.backgroundImage = ""
        }else{
            this.icon.classList.replace("bi-pause","bi-play")
            this.citylinesController.setAttribute("data-controller","")
            this.citylinesController.style.backgroundImage = `url('${window.origin}/images/ligne-bg.png')`
        }
    }
    
    // choisi si l'animation va être lancé ou non
    animDispatch(){
        let windowUrl = window.location.href

        // si l'url contient ces mots on affiche pas l'animation
        if (windowUrl.includes('post') || windowUrl.includes('guide')){
            
            this.iconWrapper.style.display = "none"
            // on déconnecte le controller qui gère l'animation
            this.citylinesController.setAttribute("data-controller","")
        }else{
            this.iconWrapper.style.display ="flex"
            this.toggleAnim()
        }
    }
}
