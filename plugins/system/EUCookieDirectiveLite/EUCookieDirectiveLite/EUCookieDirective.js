// J3, V1.1.3 Lite
function SetCookie(cookieName,cookieValue,nDays) {
   var today = new Date();
   var expire = new Date();
   if (nDays==null || nDays==0) nDays=1;
   expire.setTime(today.getTime() + 3600000*24*nDays);
   document.cookie = cookieName+"="+escape(cookieValue) + ";expires="+expire.toGMTString()+"; path=/";
   document.getElementById("cookieMessageContainer").style.display="none";
   
   var href = window.location.href;
   if (href.indexOf('?') == -1)
   {
      href = href+"?jjj="+Date.now();
   } else
   {
      href = href+"&jjj="+Date.now();
   }

   window.location.href=href;
}
