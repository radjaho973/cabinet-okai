import { Controller } from '@hotwired/stimulus';


export default class extends Controller {
    connect() {
        
        let titlesContainer = document.querySelectorAll(".title-container")
        let titles = document.querySelectorAll(".anim-title")
        
        console.log(titles)
        
        titles.forEach(element => {
            element.addEventListener("mouseenter",(e)=>{addClass(element,e)})
            element.addEventListener("mouseleave",(e)=>{removeClass(element,e)})
            // element.addEventListener("click",redirect)
        })
        function addClass(title,e) {
            let container = title.parentElement;
            container.classList.add("title-container-active")
        }
        function removeClass(title,e) {
            let container = title.parentElement;
            container.classList.remove("title-container-active")
        }
        function redirect() {
            console.log(window)
            window.location.href = window.location.href+"expertise"
        }
    }
}
