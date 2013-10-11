$(function() {

$('#carousel').carousel({ interval:8000 });
$("#menu-toggle-handle").click(function(e) { $('#nav').slideToggle('fast', function() { /*$('#edit_page_image_box .handle').toggleClass('handle_active', $(this).is(':visible'));*/ } ); });

});
