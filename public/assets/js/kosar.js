document.querySelectorAll('.kosar-gomb').forEach(gomb => {
    gomb.addEventListener('click', function () {
        const termekNev = this.dataset.termek;
        const kartya = this.closest('.card');
        const darab = parseInt(kartya.querySelector('.termek-db').value) || 1;

        fetch("/kosarba-ajax", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                termek_nev: termekNev,
                darab: darab
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.siker) {
                const modal = new bootstrap.Modal(document.getElementById('kosarModal'));
                modal.show();
            } else {
                alert(data.hiba ?? 'Hiba történt');
            }
        })
        .catch(() => {
            alert('Hiba történt a kosárba rakásnál');
        });
    });
});
