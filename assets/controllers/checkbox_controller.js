import { Controller } from '@hotwired/stimulus';


export default class extends Controller {
    connect() {

        let checkbox = document.querySelector(".checkmark")
       
        let hiddenCheckbox = checkbox.firstElementChild
        
        if (hiddenCheckbox.checked == false) {
            checkbox.classList.remove("checked")
        }else{
            checkbox.classList.add("checked")
        }
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
