function checkPasswordStrength() {
    let password = document.getElementById("password").value;
    let strength = 0;

    if (password.length >= 8) {
        document.getElementById("length").innerHTML = "✅ Minimum 8 karakter";
        document.getElementById("length").className = "text-success";
        strength++;
    } else {
        document.getElementById("length").innerHTML = "❌ Minimum 8 karakter";
        document.getElementById("length").className = "text-danger";
    }

    if (/[a-z]/.test(password)) {
        document.getElementById("lower").innerHTML = "✅ Kisbetű";
        document.getElementById("lower").className = "text-success";
        strength++;
    } else {
        document.getElementById("lower").innerHTML = "❌ Kisbetű";
        document.getElementById("lower").className = "text-danger";
    }

    if (/[A-Z]/.test(password)) {
        document.getElementById("upper").innerHTML = "✅ Nagybetű";
        document.getElementById("upper").className = "text-success";
        strength++;
    } else {
        document.getElementById("upper").innerHTML = "❌ Nagybetű";
        document.getElementById("upper").className = "text-danger";
    }

    if (/[0-9]/.test(password)) {
        document.getElementById("number").innerHTML = "✅ Szám";
        document.getElementById("number").className = "text-success";
        strength++;
    } else {
        document.getElementById("number").innerHTML = "❌ Szám";
        document.getElementById("number").className = "text-danger";
    }

    if (/[^A-Za-z0-9]/.test(password)) {
        document.getElementById("symbol").innerHTML = "✅ Speciális karakter";
        document.getElementById("symbol").className = "text-success";
        strength++;
    } else {
        document.getElementById("symbol").innerHTML = "❌ Speciális karakter";
        document.getElementById("symbol").className = "text-danger";
    }

    let percent = (strength / 5) * 100;
    let bar = document.getElementById("strengthBar");

    bar.style.width = percent + "%";

    if (percent <= 40) {
        bar.className = "progress-bar bg-danger";
    } else if (percent <= 80) {
        bar.className = "progress-bar bg-warning";
    } else {
        bar.className = "progress-bar bg-success";
    }
}

function togglePassword(inputId) {
    let input = document.getElementById(inputId);

    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}