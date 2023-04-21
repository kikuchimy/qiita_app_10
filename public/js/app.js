function left_hamburger() {
    document.getElementById('left-line1').classList.toggle('left-line_1');
    document.getElementById('left-line2').classList.toggle('left-line_2');
    document.getElementById('left-line3').classList.toggle('left-line_3');
    document.getElementById('left-nav').classList.toggle('left-in');
}

function right_hamburger() {
    document.getElementById('right-line1').classList.toggle('right-line_1');
    document.getElementById('right-line2').classList.toggle('right-line_2');
    document.getElementById('right-line3').classList.toggle('right-line_3');
    document.getElementById('right-nav').classList.toggle('right-in');
}

document.getElementById('left-hamburger').addEventListener('click' , function () {
    left_hamburger();
} );

document.getElementById('right-hamburger').addEventListener('click' , function () {
    right_hamburger();
} );
