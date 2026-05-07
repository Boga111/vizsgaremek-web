@extends('Layouts.app')

@section('content')
<div class="container my-5">

    <h1 class="text-center fw-bold mb-3">Kapcsolat</h1>
    <p class="text-center mb-5">Vedd fel velünk a kapcsolatot vagy látogass el hozzánk!</p>

    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="card h-100 product-card text-center p-4">

                <h4 class="mb-4 text-white">Elérhetőségek</h4>
                <p class="text-white"><strong>Cím:</strong><br>Budapest, Üteg utca 15., 1139</p>
                <p class="text-white"><strong>Telefon:</strong><br>+36 1 234 5678</p>
                <p class="text-white"><strong>Email:</strong><br>turbotanyer@gmail.com</p>
                <p class="mb-0 text-white"><strong>Nyitvatartás:</strong><br>H–P: 10:00 – 22:00<br>Sz–V: 11:00 – 23:00</p>

            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card h-100 product-card p-3 text-white">

                <h4 class="text-center mb-3">Hol találsz minket?</h4>

                <div class="ratio ratio-16x9 rounded overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps?q=Budapest+Üteg+utca+15+1139&output=embed"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll('.product-card');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, {
        threshold: 0.2
    });

    cards.forEach(card => {
        observer.observe(card);
    });
});
</script>
