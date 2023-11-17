import { Controller } from '@hotwired/stimulus';
    // import Swiper bundle with all modules installed
    import Swiper from 'swiper/bundle';
    // import styles bundle
    import 'swiper/css/bundle';

    // init Swiper:
    export default class extends Controller {
        connect() {
            // const swiper = new Swiper();
            console.log("swiper");
            
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 20,
            freeMode: true,
            pagination:false,
            breakpoints : {
                500 : {
                    spaceBetween: 40,
                },
                768 : {
                    spaceBetween: 80,
                },
                1700 : {
                    spaceBetween: 120,
                }
            }
        });
        
              
        }
    }