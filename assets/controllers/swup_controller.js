// assets/controllers/myswup_controller.js

import { Controller } from '@hotwired/stimulus';
// import SwupProgressPlugin from '@swup/progress-plugin';
// import SwupScrollPlugin from '@swup/scroll-plugin';
import Swup from 'swup';

const swup = new Swup({
  /* options */
});



export default class extends Controller {
    connect() {
        this.element.addEventListener('swup:pre-connect', this._onPreConnect);
        this.element.addEventListener('swup:connect', this._onConnect);

        swup.on('contentReplaced', function () {
            window.scrollTo(0, 0);
        });
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side-effects
        this.element.removeEventListener('swup:pre-connect', this._onConnect);
        this.element.removeEventListener('swup:connect', this._onPreConnect);
    }

    _onPreConnect(event) {
        // Swup has not been initialized - options can be changed
        console.log(event.detail.options); // Options that will be used to initialize Swup
        event.detail.options.plugins.push(new SwupScrollPlugin()); // Adding the progress bar plugin
    }

    _onConnect(event) {
        // Swup has just been intialized and you can access details from the event
        console.log(event.detail.swup); // Swup instance
        console.log(event.detail.options); // Options used to initialize Swup
    }
}