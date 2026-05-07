document.addEventListener("DOMContentLoaded", function () {

    const kereso = document.getElementById("kereso");
    const ajanlasok = document.getElementById("ajanlasok");
    const keresBtn = document.getElementById("keres-btn");

    kereso.addEventListener("keyup", function () {
        let szoveg = kereso.value;
        fetch("/autocomplete?keres=" + szoveg)
            .then(function (response) {
                return response.json();
            })
            .then(function (adatok) {
                let lista = "";
                adatok.forEach(function (elem) {
                    lista += '<li class="list-group-item ajanlat">' + elem + '</li>';
                });
                ajanlasok.innerHTML = lista;
                const elemek = document.querySelectorAll(".ajanlat");

                elemek.forEach(function (elem) {
                    elem.addEventListener("click", function () {
                        kereso.value = this.textContent;
                        ajanlasok.innerHTML = "";
                    });
                });

            });
    });
    keresBtn.addEventListener("click", function () {
        let szoveg = kereso.value;
        window.location.href = "/kereses?q=" + szoveg;
    });

});