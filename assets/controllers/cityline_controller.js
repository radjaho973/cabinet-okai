import { Controller } from '@hotwired/stimulus';
// import paper from 'paper';
export default class extends Controller {


initialize(){

}


connect() {
        // http://paperjs.org/
        paper.install(window)
        // Get a reference to the canvas object
        let canvas = document.getElementById('canvas');
        // Create an empty project and a view for the canvas:
        paper.setup(canvas);

        //Rectangle qui prend la dimension du canvas et sert à placer les lignes 


        // rectangle.strokeColor = "green";
        // rectangle.strokeWidth = 9;

        
        // Promesse pour récupéré l'Item
        function importCitySVG() {
            return new Promise((resolve, reject) => {
                // fonction async qui transforme le SVG en objet Item de PaperJS
                // http://paperjs.org/reference/project/#importsvg-svg-onLoad
                paper.project.importSVG("/paperSVG/lignes.svg", function (item) {
                    if (item) {
                        // Opérations sur l'objet item
                        // console.log('paper initialized');
                        item.strokeColor = "white";
                        item.strokeWidth = 0.9;
                        // item.fullySelected = true
                        // item.scale(.4)
                        item.position = new Point(paper.view.center)                        
                        resolve(item);
                    } else {
                        reject("Erreur lors de l'importation de l'élément SVG.");
                    }
                });
            });
        }
        
        // Opération sur l'item récupéré pour la clarté du code
        let lines;

        importCitySVG()
            .then((item) => {
            // sert à récupéré l'object Item hors de la promesse
            lines = item

                // on définie tool ici pour ne pas en créer un nvx à chaque function call
                let tool = new Tool

                InitalizeDrawing()
            })
            .catch((error) => {
                console.error(error);
            });

        const rectangle = new Path.Rectangle({
            point: [0, 0],
            size: [window.innerWidth, window.innerHeight],
            });
            rectangle.fullySelected = true

        view.onResize = function (event) {

            lines.position = new Point(paper.view.center)                        

            // console.log(event.delta.height);
            if (event.delta.height !== 0) {
                registerBaseHeight(lines,true)
            }
            if (window.innerWidth >=2310) {
                rectangle.bounds.width = window.innerWidth
                rectangle.bounds.height = window.innerHeight
                lines.fitBounds(rectangle.bounds,true)
            }
        }

        function InitalizeDrawing() {
                
            registerBaseHeight(lines)
            
            // redéssine le canva 60x par seconde
            view.onFrame = function (event) {
                AnimationOnFrame(event,lines)
            }
            // écoute les mouvement de souris
            tool.onMouseMove = function(event) {        
                mouseEffect(event,lines)
            }
            
        }

        // Enregistre la hauteur de base de chaque point        
        function registerBaseHeight(itemObject, isWindowResized = false) {
            let itemChildren = itemObject.children
            let itemHeight = itemObject.bounds.y

            // i = 1 car on cherche à éviter le premier enfant 
            // qui est le carré englobant le SVG
            for (let i = 1; i < itemChildren.length; i++) {
                itemChildren[i].segments.forEach(segment =>{
                    let point = segment.point
                    
                    // à l'initilisation du script 
                    if (!isWindowResized) {
                        point.distanceFromItemTop = point.y - itemHeight
                    }
                    // au rechargement de la page
                    if (isWindowResized) {
                        let newDistanceFromItemTop = point.y - itemHeight
                        // ici on cherche à remettre chaque point à sa distance initiale de l'Item
                        point.y = point.y + (point.distanceFromItemTop - newDistanceFromItemTop) 
                    }
                    point.baseHeight = point.y 
                })
            }
        }




        //?============================================
        //?               Listener 
        //?============================================
        
        //Va désigné si chaque point est proche de la souris ou non
        function mouseEffect(event,item) {
            
            let mousePosPoint = new Point(event.point)
            // i = 1 car on cherche à éviter le premier enfant 
            // qui est le carré englobant le SVG
            for (let i = 1; i < item.children.length; i++) {
                
                let path = item.children[i];
                let curveLocation = path.getNearestLocation(event.point);
                let segment = curveLocation.segment;
                let point = segment.point;
                
                
                //si la distance entre la souris et un point est inférieur à
                // 1/24ème du canva alors le point suit la souris
                if (curveLocation.distance <= canvas.clientHeight / 24) {
                    
                    //axe vertical de la souris
                    let mouseYPos = event.point.y
                    point.y += (mouseYPos - point.y) / 13
                    
                    //Le point est considéré comme proche de la souris
                    point.isMouseCloseEnough = true
                    
                    // est utilisé pour remettre le point à sa place
                    // après un laps de temps
                    setTimeout(() => {
                        point.isMouseCloseEnough = false
                    }, 100);
                }else{
                    
                    point.isMouseCloseEnough = false
                }
            };
        }
        
        //?============================================
        //?               Animation 
        //?============================================
        
        function AnimationOnFrame(event,item) {
            //maxY = hauteur max à laquel les point peuvent bouger 
            let maxYdistance = 5
            // première boucle pour éviter le rectangle englobant
            // et récupérer tous les enfant de l'Item
            for (let i = 1; i < item.children.length; i++) {
                
                let itemChildren = item.children[i]
                
                // Deuxième boucle pour assigner une hauteur à chaque point
                for (let i = 0; i < itemChildren.segments.length; i++) {
                    
                    let segment = itemChildren.segments[i];
                    // A cylic value between -1 and 1
                    let sinus = Math.sin(event.time * 1.2 + i);
                    
                    let point = segment.point
                    if (!point.isMouseCloseEnough) {
    
                        // la hauteur est défini par la valeur sinus qui oscille entre négatif et positif
                        let oscillatingHeight = sinus * maxYdistance + point.baseHeight;
                                      
                        point.y += (oscillatingHeight - point.y) / 15 
                    }
                }
            };

        }

        // Draw the view now:
        paper.view.draw();
    }

    disconnect(){
        project.clear()
    }
}
