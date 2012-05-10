/*
* Project: PASTE
* Copyright 2000 SiteExperts.com/ InsideDHTML.com, LLC
* This code can be reused as long as the above copyright notice is not removed
*/

function checkTab(el) {
  // Run only in IE
  // and if tab key is pressed
  // and if the control key is pressed
  if ((document.all) && (9==event.keyCode)) {
    // Cache the selection
    el.selection=document.selection.createRange(); 
    setTimeout("processTab('" + el.id + "')",0)
  }
}

function processTab(id) {
  // Insert tab character in place of cached selection
  document.all[id].selection.text= "   " // String.fromCharCode(9)
  // Set the focus
  document.all[id].focus()
}


function setSelectionRange(input, selectionStart, selectionEnd) {
 if (input.setSelectionRange) {
   input.focus();
   input.setSelectionRange(selectionStart, selectionEnd);
 }
 else if (input.createTextRange) {
   var range = input.createTextRange();
   range.collapse(true);
   range.moveEnd('character', selectionEnd);
   range.moveStart('character', selectionStart);
   range.select();
 }
}


/* Code contributed by Paul Brennan */
   
// replace the text area contents with original plus our new TAB
function replaceSelection (input, replaceString) {
   if (input.setSelectionRange) {
       var selectionStart = input.selectionStart;
       var selectionEnd = input.selectionEnd;
       input.value = input.value.substring(0, selectionStart)+
replaceString + input.value.substring(selectionEnd);

       if (selectionStart != selectionEnd){
           setSelectionRange(input, selectionStart, selectionStart +
   replaceString.length);
       }else{
           setSelectionRange(input, selectionStart +
replaceString.length, selectionStart + replaceString.length);
       }

   }else if (document.selection) {
       var range = document.selection.createRange();

       if (range.parentElement() == input) {
           var isCollapsed = range.text == '';
           range.text = replaceString;

            if (!isCollapsed)  {
               range.moveStart('character', -replaceString.length);
               range.select();
           }
       }
   }
}

// We are going to catch the TAB key so that we can use it
function catchTab(item,e){
   if(navigator.userAgent.match("Gecko")){
       c=e.which;
   }else{
       c=e.keyCode;
   }
   if(c==9){
       replaceSelection(item,"   ");
       setTimeout("document.getElementById('"+item.id+"').focus();",0);
       return false;
   }

}