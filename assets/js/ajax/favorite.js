// Fonctionnalité: Favoris
var button = document.getElementById('change-color');
var svg = document.getElementById('heart-svg');
button.addEventListener('click', function(e) {
    e.preventDefault();
    svg.attr("src", "assets/svg/heart_bm_red.svg");
    $.post("controllers/favorite/add_favorite.php",{id: $(this).prev().val()});
});