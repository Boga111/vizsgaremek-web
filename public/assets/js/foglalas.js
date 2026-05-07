const labels = document.querySelectorAll('label[for]');
const display = document.getElementById('kivalasztottAsztal');

labels.forEach(label => {
    label.addEventListener('click', () => {
        labels.forEach(l => {
            if (!l.classList.contains('btn-danger')) {
                l.classList.remove('btn-warning');
                l.classList.add('btn-success');
            }
        });

        if (!label.classList.contains('btn-danger')) {
            label.classList.remove('btn-success');
            label.classList.add('btn-warning');
        }

        display.textContent = label.textContent;
    });
});