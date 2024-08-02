// Product slider scroll

const scrollContainer = document.querySelectorAll(".products");

for (const item of scrollContainer) {
    item.addEventListener('wheel',(evt)=>{
        evt.preventDefault();
        item.scrollLeft += evt.deltaY;
    })
}

var sidebar = document.getElementById("sideid");
var xmark = document.getElementById("xmark");
var black = document.getElementById("black");

function Opensidebar(){
    sidebar.style.left = "0";
    xmark.style.left = "390px";
    black.style.width = "100%";
    black.style.height = "100%";
}
function CloseSidebar(){
    sidebar.style.left = "-360px";
    xmark.style.left = "";
    black.style.width = "0";
    black.style.height = "0";
}

// Account list and order

document.addEventListener("DOMContentLoaded", function() {
   
    var navTextElements = document.querySelectorAll('.nav-text');
    var triangle = document.getElementById('trainglem');
    var hiddenContent = document.getElementById('hdn-signm');

    
    function showHiddenContent() {
        
        triangle.style.display = 'block';
        hiddenContent.style.display = 'block';
        hiddenContent.style.transition = '5s';
    }

    
    function hideHiddenContent() {
        
        triangle.style.display = 'none';
        hiddenContent.style.display = 'none';
        hiddenContent.style.transition = '5s';
    }

    
    navTextElements.forEach(function(navTextElement) {
        navTextElement.addEventListener('mouseenter', showHiddenContent);
        navTextElement.addEventListener('mouseleave', hideHiddenContent);
    });

    
    hiddenContent.addEventListener('mouseenter', function() {
        triangle.style.display = 'block';
        hiddenContent.style.display = 'block';
        hiddenContent.style.transition = '5s';
    });

    
    hiddenContent.addEventListener('mouseleave', function(event) {
       
        var isMouseOverNavText = Array.from(navTextElements).some(function(navTextElement) {
            return navTextElement.contains(event.relatedTarget);
        });

        if (!isMouseOverNavText) {  
            triangle.style.display = 'none';
            hiddenContent.style.display = 'none';
        }
    });
});
