import { Controller } from '@hotwired/stimulus';


export default class extends Controller {
    connect() {

        //===SCRIPT CHANGEMENT DE TITRE=======

        let titles = document.querySelectorAll("#hero-title")
        ChangeTitles(titles)
        window.addEventListener('resize',()=>{
            ChangeTitles(titles)
        })
    }

    disconnect(){
        window.removeEventListener('load',()=>{
            ChangeTitles(titles)
        })
    }
}

function ChangeTitles(titles) {
    titles.forEach(title => {
        
        let pathname =window.location.pathname

        if (window.innerWidth <= 768) {

            switch (pathname) {
                case "/expertise":
                    title.innerHTML ="NOTRE EXPERTISE <br> <span class=\"lightblue\">VOS DÉCISIONS</span>"
                    break;
                case "/urbanisme":
                    title.innerHTML ="L’URBANISME SUR MESURE<br>NOUS CRÉONS,<br>VOUS RÉALISEZ !"
                    break;
            
                default:
                    break;
            }
        }else{

            switch (pathname) {
                case "/expertise":
                    title.innerHTML ="ÉCLAIRER LES DÉCISIONS <br>DE DEMAIN <br>AVEC NOTRE EXPERTISE <br>D’AUJOURD’HUI"
                    break;
                case "/urbanisme":
                    title.innerHTML ="L’URBANISME SUR MESURE<br>NOUS ÉLABORONS,<br>VOUS CONCRÉTISEZ !"
                    break;
            
                default:
                    break;
            }
            
        }
    })
}
