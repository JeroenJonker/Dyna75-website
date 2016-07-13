$(document).ready(function(e) {
    $(window).resize(e, function(){
        handleStageResize();
    });
    handleStageResize();
});

function handleStageResize(){
    var videoWidth = $('.verzinmaarwat > p > iframe').width();
    var aspectRatio = 16/9;
    var videoHeight = videoWidth / aspectRatio;
    $('iframe').css({height: videoHeight+"px"});
};

//var slideIndex = 0;
//carousel();
//
//function carousel() {
//    var i;
//    var x = document.getElementsByClassName("mySlides");
//    for (i = 0; i < x.length; i++) {
//      x[i].style.display = "none"; 
//    }
//    slideIndex++;
//    if (slideIndex > x.length) {slideIndex = 1} 
//    x[slideIndex-1].style.display = "block"; 
//    setTimeout(carousel, 2000); // Change image every 2 seconds
//};
