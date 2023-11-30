import { Controller } from '@hotwired/stimulus';

// gère l'import et l'export du code css pour afficher / éditer les articles
export default class extends Controller {
    initialize() {
        let cssId = '#tinycss'
        if (document.getElementById(cssId) == null)
        {
            var head  = document.getElementsByTagName('head')[0];
            var link  = document.createElement('link');
            link.id   = cssId;
            link.rel  = 'stylesheet';
            link.type = 'text/css';
            link.href = `${window.origin}/tiny.css`;
            head.appendChild(link);
            this.linkRef = link
        }
    }
    linkRef = null
    disconnect(){
        this.linkRef.remove()
    }
}
