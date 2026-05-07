document.addEventListener("DOMContentLoaded", function () {
   const gomb = document.getElementById("cimSzerkesztesGomb");
   const form = document.getElementById("cimForm");
   if (!gomb || !form) return;
   function setCookie(name, value, days = 1) {
       const date = new Date();
       date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
       document.cookie = name + "=" + value + "; expires=" + date.toUTCString() + "; path=/";
   }
   function getCookie(name) {
       const cookieName = name + "=";
       const decodedCookie = decodeURIComponent(document.cookie);
       const cookies = decodedCookie.split(";");
       for (let i = 0; i < cookies.length; i++) {
           let c = cookies[i].trim();
           if (c.indexOf(cookieName) === 0) {
               return c.substring(cookieName.length, c.length);
           }
       }
       return "";
   }
   function openForm() {
       form.style.display = "block";
       setCookie("cimFormNyitva", "1");
   }
   function closeForm() {
       form.style.display = "none";
       setCookie("cimFormNyitva", "0");
   }
   if (getCookie("cimFormNyitva") === "1") {
       openForm();
   } else {
       closeForm();
   }
   gomb.addEventListener("click", function () {
       if (form.style.display === "none") {
           openForm();
       } else {
           closeForm();
       }
   });
   const cimModositoForm = form.querySelector("form");
   if (cimModositoForm) {
       cimModositoForm.addEventListener("submit", function () {
           setCookie("cimFormNyitva", "1");
       });
   }
});
