$.fn.extend({
insertAtCaret: function(myValue){
var obj;
if( typeof this[0].name !='undefined' ) obj = this[0];
else obj = this;
var startPos = obj.selectionStart;
var endPos = obj.selectionEnd;
var scrollTop = obj.scrollTop;
obj.value = obj.value.substring(0, startPos)+myValue+obj.value.substring(endPos,obj.value.length);
obj.focus();
obj.selectionStart = startPos + myValue.length;
obj.selectionEnd = startPos + myValue.length;
obj.scrollTop = scrollTop;
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

//Ajax autocompleate
function split( val ) {
    return val.split( /,\s*/ );
}
function extractLast( term ) {
  return split( term ).pop();
}

    jQuery( 'input[name="page"],input[name="category"],input[name="link"]' ).autocomplete({
        source: function( request, response ) {
            var $list = this.element.attr("name");
                    if($list=='link') $list="page";
          jQuery.getJSON( "./index.php?mode=ajaxprocess&action=get&"+$list+"=1", {
          term: request.term
          }, response );
        }
      });

            jQuery( 'input[name="sections"]' ).autocomplete({
        source: function( request, response ) {
          var $list = this.element.attr("name");
                    jQuery.getJSON( "./index.php?mode=ajaxprocess&action=get&"+$list+"=1", {
            term: extractLast( request.term )
          }, response );
        },
        search: function() {
          // custom minLength
          var term = extractLast( this.value );
          if ( term.length < 2 ) {
            return false;
          }
        //console.log(term);
                },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        },
                create: function(){

                }
      });

});
