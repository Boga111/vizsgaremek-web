document.getElementById('tel_szam').addEventListener('input', function() {
    let value = this.value;

    value = value.replace(/(?!^\+)[^\d]/g, '');

    if (value.startsWith('36') && !value.startsWith('+36')) {
        value = '+' + value;
    }

    this.value = value;
});