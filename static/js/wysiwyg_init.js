tinymce.init({
   selector: "#content",
   menubar:false,
   statusbar: false,
   entity_encoding : "raw",
   plugins: [
        "advlist autolink lists link image anchor code"
    ],
   target_list:false,
    
   toolbar: "undo redo | styleselect | bold italic | bullist numlist | link unlink | image | code",
   content_css : "../static/css/wysiwyg.css"

});
