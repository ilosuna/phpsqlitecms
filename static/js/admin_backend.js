$.fn.extend({
insertAtCaret: function(myValue){
editor.insert(myValue);
}
});

$(function() {

$("a[data-confirm-link]").click(function(e) { e.preventDefault();
                                            message = $(this).data('confirm-link') ? decodeURIComponent($(this).data('confirm-link')) : 'Are you sure?';
                                            var confirmed = confirm(decodeURIComponent(message));
                                            if(confirmed) window.location.href = $(this).attr("href"); });

$("a[data-delete-confirm]").click(function(e) { e.preventDefault();
                                            message = $(this).data('delete-confirm') ? decodeURIComponent($(this).data('delete-confirm')) : 'Delete?';
                                            $(this).parents("tr").addClass('danger');
                                            $(this).parents("div .comment").addClass('comment-delete');
                                            var confirmed = confirm(decodeURIComponent(message));
                                            if(confirmed) window.location.href = $(this).attr("href") + '&confirmed=true';
                                            $(this).parents("tr").removeClass('danger');
                                            $(this).parents("div .comment").removeClass('comment-delete'); });

$("*[data-toggle-checkboxes]").click(function(e) { e.preventDefault();
                                            
                                            var checkboxClass = $(this).data('toggle-checkboxes');
                                            $('.'+checkboxClass).trigger('click'); });


$("*[data-sortable]").sortable({ start : function(e, ui) { ui.item.addClass("warning"); },
                          stop : function(e, ui) { ui.item.removeClass("warning"); },
                          
                          update : function () { var request = $(this).data('sortable');
                                                 var order = $(this).sortable('serialize');
                                                 $.ajax({ url:request, data:order }); },
                          
                          containment : "parent",
                          tolerance : "pointer",
                          helper : function(e, ui) { ui.children().each(function() { $(this).width($(this).width()); }); return ui; },
                          axis:"y",
                          handle:".sortable-handle" }).disableSelection();



$('.modal').on('show.bs.modal', function (e) {  
  $insertField = $(e.relatedTarget).data('insert');
});


});
