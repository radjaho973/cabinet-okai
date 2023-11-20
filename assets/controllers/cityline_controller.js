import { Controller } from '@hotwired/stimulus';
// import paper from 'paper';
export default class extends Controller {

isAnimating = true

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

        const rectangle = new Path.Rectangle({
        point: [0, 0],
        size: [window.innerWidth, window.innerHeight],
        });
        // rectangle.fullySelected = true


        // Promesse pour récupéré l'Item
        function importCitySVG() {
            return new Promise((resolve, reject) => {
                // fonction async qui transforme le SVG en objet Item de PaperJS
                // http://paperjs.org/reference/project/#importsvg-svg-onLoad
                paper.project.importSVG("/paperSVG/lignes.svg", function (item) {
                    if (item) {
                        // Opérations sur l'objet item
                        item.strokeColor = "white";
                        item.strokeWidth = 0.9;
                        item.removeChildren(0, 1)
                        setSize(rectangle,item)
                        
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

        view.onResize = function () {
            setSize(rectangle,lines)
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

        // place un object au centre du rectangle 
        function setSize(rectangle,itemObject) {
            rectangle.bounds.width = window.innerWidth
            rectangle.bounds.height = window.innerHeight

            if(window.innerWidth >= 1835){
                
                itemObject.fitBounds(rectangle.bounds)
                itemObject.scale(1.3)
            }
            itemObject.position = rectangle.bounds.center
            paper.view.draw()
        }

        // Enregistre la hauteur de base de chaque point        
        function registerBaseHeight(itemObject) {
                
            itemObject.children.forEach(itemChild =>{
                itemChild.segments.forEach(segment =>{
                    let point = segment.point
                    
                    point.baseHeight = point.y 
                })
            })
        }




        //?============================================
        //?               Listener 
        //?============================================

        //Applique un listener au movement de la souris
        function mouseEffect(event,item) {

            item.children.forEach(path => {
                
                let mousePosPoint = new Point(event.point)
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
                    
                    setTimeout(() => {
                        point.isMouseCloseEnough = false
                    }, 100);
                }else{
                    
                    point.isMouseCloseEnough = false
                }
            });
        }

        //?============================================
        //?               Animation 
        //?============================================

        function AnimationOnFrame(event,item) {
            
            let maxYdistance = 5
            item.children.forEach(itemChildren =>{

                for (let i = 0; i < itemChildren.segments.length; i++) {
                    
                    let segment = itemChildren.segments[i];
                    // A cylic value between -1 and 1
                    // console.log(event.time)
                    let sinus = Math.sin(event.time * 1.2 + i);
                    let point = segment.point
                    if (!point.isMouseCloseEnough) {
                        let relativeHeight = sinus * maxYdistance + point.baseHeight;
                        
                        // Change the y position of the segment point
                        // la hauteur est défini par la valeur sinus qui oscile entre négatif et positif
                        //maxY = hauteur max à laquel les point peuvent bouger et leur position de base (baseHeight)
                    
                        point.y += (relativeHeight - point.y) / 15    
                    }
                }
            })
        }


        // Draw the view now:
        paper.view.draw();
    }

    disconnect(){
        project.clear()
        // clear scope
        // paper.scope.remove();
        // remove element
        // paper.canvas.clear();

        // clear variables so they can be garbage collected
        // paper.canvas = null;
        // paper.scope  = null;
    }
}
