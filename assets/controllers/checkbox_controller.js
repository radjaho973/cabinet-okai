import { Controller } from '@hotwired/stimulus';


export default class extends Controller {
    connect() {

        let checkbox = document.querySelector(".checkmark")
       
        let hiddenCheckbox = checkbox.firstElementChild
        checkbox.addEventListener("click",toggleCheck)
       
       function toggleCheck() {
           if (checkbox.classList.contains("checked")){
               checkbox.classList.remove("checked")
               hiddenCheckbox.checked = false
           }else{
               checkbox.classList.add("checked")
               hiddenCheckbox.checked = true
               
           }
        }
    }
}
