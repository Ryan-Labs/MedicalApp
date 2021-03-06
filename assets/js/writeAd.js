
let currentTab = 0;
showTab(currentTab);

function showTab(n) {

    let x = document.getElementsByClassName("tab");
    x[n].style.display = "block";

    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Valider";
    } else {
        document.getElementById("nextBtn").innerHTML = "Suivant";
    }

    fixStepIndicator(n)
}

global.nextPrev = function nextPrev(n) {

    let x = document.getElementsByClassName("tab");

    if (n == 1 && !validateForm()) return false;

    x[currentTab].style.display = "none";
    currentTab = currentTab + n;

    if (currentTab >= x.length) {
        document.getElementById("regForm").submit();
        return false;
    }

    showTab(currentTab);
}

function validateForm() {

    let x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].querySelectorAll("input,select,textarea");

    for (i = 0; i < y.length; i++) {

        if ((y[i].required && y[i].value == "") || (y[i].type == "email" && y[i].value != "" && !y[i].value.match(/[a-z0-9_\-\.]+@[a-z0-9_\-\.]+\.[a-z]+/i))) {

            y[i].className += " invalid";
            valid = false;
        }
    }

    if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid;
}

function fixStepIndicator(n) {

    let i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }

    x[n].className += " active";
}


global.validation = function validation(){
    const fileInput = document.getElementById('fileInput');
    let value = fileInput.value;
    const extensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

    if (!extensions.exec(value)) {
        alert('Format de fichier non valide');
        fileInput.value = '';
        return false;
    }
};
