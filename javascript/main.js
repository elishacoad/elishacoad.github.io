$(document).ready(function() {

    // window.sr = ScrollReveal();
    // sr.reveal('.tile', { duration: 1200, reset: true});
    //Included in tiles.js

    $(".slight-tilt").rotate({
        bind: {
            mouseover: function() {
                $(this).rotate({ animateTo: -10 })
            },
            mouseout: function() {
                $(this).rotate({ animateTo: 0 })
            }
        }
    });


// $('main').fadeIn(1000);

// window.onload = function() {
//     $('main').show();
// }

// $('.navbar a, .tile a').click(function(event) {
//     event.preventDefault();
//     newLocation = this.href;
//     $('main').fadeOut(300, newpage);
// });

function newpage() {
    window.location = newLocation;
}

// $(window).fancy_scroll({
//     animation: "bounce", // Options available are bounce (like on iOS), or glow (like on Android 4.0+)
//     bounceDistance: 50, // ONLY for bounce effect: The distance in pixels that page will overflow. Default is 50 pixels.
//     glowColor: "#02A1FA", // ONLY for glow effect: The colour of the glow effect. Default is #02A1FA (blueish).
//     animDuration: "0.3s", // The animation duration. Can take milliseconds (200ms) or seconds value (0.2s). Default is 0.2s
//     animEasing: "cubic-bezier(0.175, 0.885, 0.420, 1.310)", // This field accept css easing options. Options available are: linear, ease-in, ease-out, ease-in-out or you can generate it with the tool available here: http://matthewlein.com/ceaser/
// });


});

