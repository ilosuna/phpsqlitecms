$(function() {

$('#menu-toggle-handle').click(function(e) { $('#nav').slideToggle('fast'); });

$('ul.nav.nav-pills > li').each(
    function(){
        var _sameSection = $('li[data-section*="'+$(this).data('section')+'"]');
        if(_sameSection.length > 1 && !_sameSection.hasClass('dropdown')){
            _sameSection.first().addClass('dropdown')
                .find('a:first')
                .append('<span class="caret"></span>');

            _sameSection.first().append(_sameSection.not(':first'));
            _sameSection.not(':first').removeClass('active')
            .wrapAll('<ul class="dropdown-menu dropdown-menu-right" role="menu"></ul>');
        }
    }
);


});
