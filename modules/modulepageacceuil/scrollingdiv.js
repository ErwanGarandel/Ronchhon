// fonction s'occuppant du scroll de la page d'acceuil, avec JQUERY

$(function scrolldown() { // 
    
    var introE1 = $('div.scrollblock'), 
    HeadH = introE1.find('h1').height(), // défini la taille du head
    windowH = $(window).height(); //défini la taille de la fenêtre
                
       introE1.css('padding', (windowH - HeadH)/2); //défini une taille à la div intro
                
        $(document).on('scroll', function (){
            introE1.slideUp(800, function() { $(document).off('scroll'); });//désactive le scroll retour
            });

})

