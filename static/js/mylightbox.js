/********************************************************/
/* myLightbox by Mark Hoschek - http://mark-hoschek.de/ */
/********************************************************/
myLightboxSettings = new Object();
myLightboxSettings['vertical_align'] =      30; // 'center' or number of pixels from top
myLightboxSettings['next_link'] =           '[&raquo;]';
myLightboxSettings['next_link_title'] =     'next';
myLightboxSettings['previous_link']       = '[&laquo;]';
myLightboxSettings['previous_link_title'] = 'previous';
myLightboxSettings['close_link'] =          '[x]';
myLightboxSettings['close_link_title'] =    'close';
myLightboxSettings['html_box'] = '<div id="mylightbox">\
<div id="mylightbox-header">\
<div id="mylightbox-title"></div>\
<div id="mylightbox-controls"><a href="#" id="mylightbox-close" title="'+myLightboxSettings['close_link_title']+'" onclick="return false"><span>'+myLightboxSettings['close_link']+'</span></a></div>\
</div>\
<div id="mylightbox-photo"></div>\
<p id="mylightbox-subtitle"></p>\
<p id="mylightbox-description"></p>\
<p id="mylightbox-author"></p>\
</div>';
myLightboxSettings['html_background'] = '<div id="mylightbox-background"></div>';

// 0 means disabled; 1 means enabled;
var popupStatus = 0;

// loading popup with jQuery magic!
function loadPopup()
 {
  //loads popup only if it is disabled
  if(popupStatus==0)
   {
    $("body").append(myLightboxSettings['html_background']);
    $("body").append(myLightboxSettings['html_box']);
    
    $("#mylightbox-background").css({
	   "opacity": "0.7"
    });

    $("#mylightbox-background").fadeIn("fast");
    $("#mylightbox").fadeIn("fast");
		
    // center popup on window resize:
    $(window).bind('resize', function() {
     centerPopup($("#mylightbox").width(),$("#mylightbox").height());
    });
    
    // close on click on close button:
    $("#mylightbox-close").click(function(){
     disablePopup();
    });

    // close on click on background:
    $("#mylightbox-background").click(function(){
     disablePopup();
    });

    // close on ESC key
    $(document).keypress(function(e){
     if(e.keyCode==27 && popupStatus==1){
      disablePopup();
     }
    });    

    popupStatus = 1;
   }
 }

function disablePopup()
 {
  //if(popupStatus==1){
  $("#mylightbox").fadeOut("fast", remove);
  $("#mylightbox-background").fadeOut("fast", remove);
  popupStatus = 0;
  delete myLightboxCurrentWidth;
  //}
}

// callback function to remove box and background:
function remove()
 {
  $(this).remove();
 }

function centerPopup(width, height)
 {
 
  if(myLightboxSettings['vertical_align']=='center')
   {
    var top = $(window).scrollTop()+$(window).height()/2-height/2;
   }
  else
   {
    var top = $(window).scrollTop()+myLightboxSettings['vertical_align'];
   }
  var left = $(window).width()/2-width/2;

  if(top<0) top=0;
  if(left<0) left=0;

   $("#mylightbox").css({
   //"width":imgWidth+'px',
   //"width":imageWidth+'px',
   //"height":+'px',
   "position": "absolute",
   "top": top+'px',
   //"top": top+"px",
   "left": left+'px'
  });
  
  //only need force for IE6
  $("#mylightbox-background").css({
   "height": $(window).height()
  }); 
 }

function doit(e,t)
 {
  e.preventDefault();
  
  // get mylightbox links, image sources, titles (alt) and descriptions (title):
  var myLightboxLinks = new Array();
  var srcs = new Array();
  var titles = new Array();
  var subtitles = new Array();
  var descriptions = new Array();
  var authors = new Array();

  //$(".mylightbox").each(function(i) // get all links with class="mylightbox"
  $("a[data-lightbox]").each(function(i) // get all links with rel="mylightbox"
   {
    if($(this)[0] === $(t)[0]) mylightboxCurrent = i;
    myLightboxLinks.push($(this));
    srcs.push($(this).attr('href'));
    titles.push($(this).find('img').attr('title'));
    subtitles.push($(this).find('img').attr('data-subtitle'));
    descriptions.push($(this).find('img').attr('data-description'));
    authors.push($(this).find('img').attr('data-author'));
   });
  
  var numberOfImages = myLightboxLinks.length;
  var src = srcs[mylightboxCurrent];
  var title = titles[mylightboxCurrent];
  var subtitle = subtitles[mylightboxCurrent];
  var description = descriptions[mylightboxCurrent];
  var author = authors[mylightboxCurrent];

  // determine previous and next image:
  if(numberOfImages>1)
   {
    if(typeof(myLightboxLinks[mylightboxCurrent+1])!='undefined')
     {
      var next = myLightboxLinks[mylightboxCurrent+1];
     }
    else
     {
      var next = myLightboxLinks[0];
     }
    if(typeof(myLightboxLinks[mylightboxCurrent-1])!='undefined')
     {
      var prev = myLightboxLinks[mylightboxCurrent-1];
     }
    else
     {
      var prev = myLightboxLinks[numberOfImages-1];
     }   
   }

  loadPopup();

  if(typeof(myLightboxCurrentWidth)!='undefined') $("#mylightbox").css({"width":myLightboxCurrentWidth+'px'});
  
  $("#mylightbox #mylightbox-title").html('');
  $("#mylightbox-photo").html('<div id="mylightbox-throbber"></div>');
  $("#mylightbox-description").html('');
  
  if(typeof(myLightboxCurrentWidth)=='undefined') centerPopup($("#mylightbox").outerWidth(), $("#mylightbox").outerHeight());
  
  var objImagePreloader = new Image();
  objImagePreloader.onload = function() 
   {
    $("#mylightbox #mylightbox-title").html(title);
    $("#mylightbox-photo").hide();
    /*if(typeof(next)!='undefined')
     {
      $("#mylightbox-photo").html('<a id="mylightbox-next-img" href="'+$(next).attr('href')+'"><img src="'+src+'" /></a>');
      $("#mylightbox-next-img").click(function(e){ doit(e,next); });
     }  
    else
     {
      $("#mylightbox-photo").html('<img src="'+src+'" />');      
     }
    */
    $("#mylightbox-photo").html('<img src="'+src+'">');
     
  // previous and next buttons:
  if(typeof(prev)!='undefined' && typeof(next)!='undefined')
   {
    $("#mylightbox-photo").append('<a id="mylightbox-prev" href="'+$(prev).attr('href')+'" title="'+myLightboxSettings['previous_link_title']+'"><span>'+myLightboxSettings['previous_link']+'</span></a>');
    $("#mylightbox-photo").append('<a id="mylightbox-next" href="'+$(next).attr('href')+'" title="'+myLightboxSettings['next_link_title']+'"><span>'+myLightboxSettings['next_link']+'</span></a>');
    $("#mylightbox-prev").click(function(e) { doit(e,prev); });       
    $("#mylightbox-next").click(function(e) { doit(e,next); });  
    
    if(typeof Hammer == 'function')
     {
      var hammertime = $("#mylightbox-photo").hammer();
      hammertime.on("swipeleft", function(e) { doit(e,next); });  
      hammertime.on("swiperight", function(e) { doit(e,prev); });
     }
   }
  else
   {
    //$("#mylightbox-prev").remove();
    //$("#mylightbox-next").remove(); 
   }
    
    if(subtitle)
     {
      $("#mylightbox-subtitle").html(subtitle);
      $("#mylightbox-subtitle").show();
     }
    else
     {
      $("#mylightbox-subtitle").hide();
     }

    $("#mylightbox-description").html(description);

    if(author)
     {
      $("#mylightbox-author").html(author);
      $("#mylightbox-author").show();
     }
    else
     {
      $("#mylightbox-author").hide();
     }      

    $("#mylightbox-photo").fadeIn("fast");

    myLightboxCurrentWidth = objImagePreloader.width;
    $("#mylightbox").css({"width":myLightboxCurrentWidth+'px'}); 
    
    centerPopup($("#mylightbox").outerWidth(), $("#mylightbox").outerHeight());
   };
  
  objImagePreloader.src = src;
   
 }

$(function()
 {
  $("a[data-lightbox]").click(function(e){
  doit(e,this);
 });

});
