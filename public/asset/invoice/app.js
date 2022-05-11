jQuery(function ($) {
    'use strict';
    loader();
    function loader() {
        $(".loader").delay(3600).fadeOut();
        $(".animationload").delay(3600).fadeOut("slow");
    }
});

// *********************** validation formulaire de connexion ********************
let pro_form = document.querySelector("#pro-login");
let btn_connexion = document.querySelector("#btn-connexion");
if (pro_form) {
    pro_form.email.addEventListener('change', function () {
        validEmail(this);
    });
    pro_form.password.addEventListener('change', function () {
        validPassword(this);
    });
}
const validEmail = function (inputEmailLogin) {
    // creation nouvelle expression reguilier
    let emailRegex = new RegExp('^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$', 'g');
    let testRegex = emailRegex.test(inputEmailLogin.value);
    // recuperation de la balise SMALL
    let small = document.querySelector("#message-small");
    if (testRegex) {
        small.innerHTML = "Adresse valide"
        small.classList.remove('text-danger');
        small.classList.add('text-success');
        return true;
    } else {
        small.innerHTML = "Adresse invalide";
        small.classList.remove('text-success');
        small.classList.add('text-danger');
        return false;
    }
}
const validPassword = function (inputPassword) {
    //variable message
    let msg;
    // validation
    let valid = false;
    let small = inputPassword.nextElementSibling;
    //au moins 8 caracteres
   
    if (inputPassword1.value < 9) {
        msg = "Mot de passe doit contenir au moins 8 caractères.";
    }
    //au moins 1 chiffre
    else if (!/[0-9]/.test(inputPassword1.value)) {
        msg = "Mot de passe doit contenir au moins un chiffre.";
    }
    // au moins 1 Maj
     else if (!/[A-Z]/.test(inputPassword.value)) {
         msg = "Mot de passe doit contenir au moins une lettre majuscule";
     }
    // au moin 1 min
    else if (!/[a-z]/.test(inputPassword1.value)) {
        msg = "Mot de passe doit contenir au moins une lettre minuscule";
    }
    // au moins 1 caractère spéciaux
    else if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(inputPassword.value )){
        msg = "Mot de passe doit contenir au moins un caractère spéciaux.";
    } else {
        msg = "Mot de passe valide!";
        valid = true;
    }
    if (valid) {
        small.innerHTML = 'valide format';
        small.classList.remove('text-danger');
        small.classList.add('text-success');
        btn_connexion.disabled = false;
    } else {
        small.innerHTML = msg;
        small.classList.remove('text-success');
        small.classList.add('text-danger');
    }
};
//*************************** validation registration ************************* */
let form_registre = document.querySelector("#form-register");
let emailRegistre = document.querySelector("#registration_form_email");
let emailPassword1 = document.querySelector("#registration_form_plainPassword_first");
let emailPassword2 = document.querySelector("#registration_form_plainPassword_second");
// ajout evenement sur input email
if (form_registre) {
    emailRegistre.addEventListener('change', function () {
        verifEmail(this);
    });
}
// ajout evenement sur input password1
if (form_registre) {
    emailPassword1.addEventListener('change', function () {
        verifPassword1(this);
    });
    emailPassword2.addEventListener('change', function () {
        verifPassword2(this);
    });
}
const verifEmail = function (inputEmailRegistre) {
    // creation nouvelle expression reguilier
    let emailRegex = new RegExp('^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$', 'g');
    let testRegex = emailRegex.test(inputEmailRegistre.value);
    // recuperation de la balise SMALL
    let small = document.querySelector("#message-small");
    if (testRegex) {
        small.innerHTML = "Adresse valide"
        small.classList.remove('text-danger');
        small.classList.add('text-success');
        return true;
    } else {
        small.innerHTML = "Adresse invalide";
        small.classList.remove('text-success');
        small.classList.add('text-danger');
        return false;
    }
}

const verifPassword1 = function (inputPassword1) {
    //variable message
    let msg;
    // validation
    let valid = false;
    let small = document.querySelector("#message-password");
    //au moins 8 caracteres
    if (inputPassword1.value < 9) {
        msg = "Mot de passe doit contenir au moins 8 caractères.";
    }
    //au moins 1 chiffre
    else if (!/[0-9]/.test(inputPassword1.value)) {
        msg = "Mot de passe doit contenir au moins un chiffre.";
    }
    // au moins 1 Maj
     else if (!/[A-Z]/.test(inputPassword.value)) {
         msg = "Mot de passe doit contenir au moins une lettre majuscule";
     }
    // au moin 1 min
    else if (!/[a-z]/.test(inputPassword1.value)) {
        msg = "Mot de passe doit contenir au moins une lettre minuscule";
    }
    // au moins 1 caractère spéciaux
    else if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(inputPassword.value )){
        msg = "Mot de passe doit contenir au moins un caractère spéciaux.";
    }
     else {
        msg = "Mot de passe valide";
        valid = true;       
    }
    if (valid) {
        small.innerHTML = 'Mot de passe valide';
        small.classList.remove('text-danger');
        small.classList.add('text-success');
    } else {
        small.innerHTML = msg;
        small.classList.remove('text-success');
        small.classList.add('text-danger');
    }
};
const verifPassword2 = function (inputPassword2) {
    //variable message
    let msg;
    // validation
    let valid = false;
    let small = document.querySelector("#message-password");
    //au moins 8 caracteres
    if (inputPassword2.value < 9) {
        msg = "le mot de passe doit contenir au moins 8 caracteres";
    }
    //au moins 1 chiffre
    else if (!/[0-9]/.test(inputPassword2.value)) {
        msg = "Mot de passe doit contenir au moins un chiffre";
    }
    // au moins 1 Maj
    else if (!/[A-Z]/.test(inputPassword.value)) {
        msg = "Mot de passe doit contenir au moins une lettre majuscule";
    }
     // au moin 1 min
     else if (!/[a-z]/.test(inputPassword1.value)) {
         msg = "Mot de passe doit contenir au moins une lettre minuscule";
     }
     // au moins 1 caractère spéciaux
     else if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(inputPassword.value )){
         msg = "Mot de passe doit contenir au moins un caractère spéciaux.";
     }

    else {
        msg = "Mot de passe valide";
        valid = true;
    }
    if (valid) {
        small.innerHTML = 'Mot de passe valide';
        small.classList.remove('text-danger');
        small.classList.add('text-success');
    } else {
        small.innerHTML = msg;
        small.classList.remove('text-success');
        small.classList.add('text-danger');
    }
};

//************************ multiple form pour parametre ************************* */
const btnPrev = document.querySelectorAll(".btn-prev");
const btnNext = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const formStep = document.querySelectorAll(".form-step");
const progressStep = document.querySelectorAll(".progress-step");
let formStepNum = 0;
btnNext.forEach((btn) => {
    btn.addEventListener('click', () => {
        formStepNum++;
        updateFormStep();
        updateProgressbar();
    });

});
btnPrev.forEach((btn) => {
    btn.addEventListener('click', () => {
        formStepNum--;
        updateFormStep();
        updateProgressbar();
    });

});
function updateFormStep() {
    formStep.forEach((formSteps) => {
        formSteps.classList.contains("form-step-active") &&
            formSteps.classList.remove("form-step-active");

    });
    formStep[formStepNum].classList.add("form-step-active");

};
function updateProgressbar() {
    progressStep.forEach((progressSteps, idx) => {
        if (idx < formStepNum + 1) {
            progressSteps.classList.add("progress-step-active");
        } else {
            progressSteps.classList.remove("progress-step-active");
        }
    });
    const progressActive = document.querySelectorAll(".progress-step-active");
    progress.style.width = ((progressActive.length - 1) / (progressStep.length - 1)) * 100 + "%";
}

///////PDF
var form = $('#invoice-box'),
    cache_width = form.width(),
    a4 = [595.28, 990.89]; // for a4 size paper width and height

var canvasImage,
    winHeight = a4[1],
    formHeight = form.height(),
    formWidth = form.width();

var imagePieces = [];

// on create pdf button click
$('#create_pdf').on('click', function () {
    $('body').scrollTop(0);
    imagePieces = [];
    imagePieces.length = 0;
    main();

});

// main code
function main() {
    getCanvas().then(function (canvas) {
        canvasImage = new Image();
        canvasImage.src = canvas.toDataURL('image/png');
        canvasImage.onload = splitImage;
    });
}

// create canvas object
function getCanvas() {
    form.width(a4[0] * 1.33333 - 80).css('max-width', 'none');
    return html2canvas(form, {
        imageTimeout: 2000,
        removeContainer: true,
    });
}

// chop image horizontally
function splitImage(e) {
    var totalImgs = Math.round(formHeight / winHeight);
    for (var i = 0; i < totalImgs; i++) {
        var canvas = document.createElement('canvas'),
            ctx = canvas.getContext('2d');
        canvas.width = formWidth;
        canvas.height = winHeight;
        //                    source region                   dest. region
        ctx.drawImage(
            canvasImage,
            0,
            i * winHeight,
            formWidth,
            winHeight,
            0,
            0,
            canvas.width,
            canvas.height,
        );

        imagePieces.push(canvas.toDataURL('image/png'));
    }
    console.log(imagePieces.length);
    createPDF();
}

// crete pdf using chopped images
function createPDF() {
    var totalPieces = imagePieces.length - 1;
    var doc = new jsPDF({
        unit: 'px',
        format: 'a4',
    });
    imagePieces.forEach(function (img) {
        doc.addImage(img, 'JPEG', 20, 40);
        if (totalPieces) doc.addPage();

        totalPieces--;
    });
    doc.save('techumber-html-to-pdf.pdf');
    form.width(cache_width);
}


