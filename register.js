function checkName(event) {


    const input = document.getElementById('name');

    if (input.value == "") {
        const div = input.parentNode;

        div.classList.add('errore');
        div.querySelector(".hidden").classList.remove("hidden");
    }
    else {
        const div = input.parentNode;

        div.classList.remove('errore');
        div.querySelector(".mex").classList.add("hidden");
    }


}
function jsonCheckEmail(json) {
    const input = document.getElementById('email');
    // Controllo il campo exists ritornato dal JSON
    if (input.value != json.exists) {
        document.querySelector('.email').classList.remove('errore');
        document.querySelector(".email .mex").classList.add("hidden");

    } else {
        document.querySelector(".email .errore").classList.add('errore');
        document.querySelector(".email .mex").classList.remove("hidden");
    }

}

function jsonCheckUsername(json) {
    console.log(json);
    const input = document.getElementById('username');

    // Controllo il campo exists ritornato dal JSON
    if (input.value != json.exists) {
        document.querySelector(".username").classList.remove('errore');
        document.querySelector(".username .mex").classList.add("hidden");
    } else {
        document.querySelector(".username .box").classList.add('errore');
        document.querySelector(".username .mex").classList.remove("hidden");
    }
    console.log(input.value);
}

function fetchResponse(response) {
    if (!response.ok) return null;
    console.log(response);
    return response.json();
}

function checkUsername(event) {


    const input = document.getElementById('username');

    if (input.value > 0) {
        const div = input.parentNode;

        div.classList.remove('errore');
        div.querySelector(".hidden").classList.add("hidden");
    } else {

        fetch("ControllaUsername.php?q=" + encodeURIComponent(String(input.value))).then(fetchResponse).then(jsonCheckUsername);
    }

    /*else {
        const div = input.parentNode;

        div.classList.remove('errore');
        div.querySelector(".mex").classList.add("hidden");
    }*/

}

//SURNAME
function checkSurname(event) {
    const input = document.getElementById('surname');

    if (input.value == "") {
        const div = input.parentNode;

        div.classList.add('errore');
        div.querySelector(".hidden").classList.remove("hidden");
    }

    else {
        const div = input.parentNode;

        div.classList.remove('errore');
        div.querySelector(".mex").classList.add("hidden");
    }
}

//EMAIL
function checkEmail(event) {
    const input = document.getElementById('email');

    if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(input.value).toLowerCase())) {
        const div = input.parentNode;

        div.classList.add('errore');
        div.querySelector(".hidden").classList.remove("hidden");
    }

    else {
        fetch("ControllaEmail.php?q=" + encodeURIComponent(String(input.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }
}

function checkPassword(event) {
    const input = document.getElementById('password');

    if (input.value.length < 8) {
        const div = input.parentNode;

        div.classList.add('errore');
        div.querySelector(".hidden").classList.remove("hidden");
    }

    else {
        const div = input.parentNode;

        div.classList.remove('errore');
        div.querySelector(".mex").classList.add("hidden");
    }
}

function checkConfirmPassword(event) {
    const input = document.getElementById('confPass');
    const input2 = document.getElementById('password');

    if (input.value != input2.value) {
        const div = input.parentNode;

        div.classList.add('errore');
        div.querySelector(".hidden").classList.remove("hidden");
    }

    else {
        const div = input.parentNode;

        div.classList.remove('errore');
        div.querySelector(".mex").classList.add("hidden");
    }
}

function checkData(event) {


    const input = document.getElementById('data');
    var partiDellaData = input.value.split('/');

    var giornoNascita = parseInt(partiDellaData[2], 10);
    var meseNascita = parseInt(partiDellaData[1], 10);
    var annoNascita = parseInt(partiDellaData[0], 10);

    var current = new Date();

    var currentGiorno = current.getDay();
    var currentMese = current.getMonth() + 1;
    var currentAnno = current.getFullYear();

    var differenza = currentAnno - annoNascita;

    if (differenza < 18 || (differenza == 18 && meseNascita > currentMese) || (differenza == 18 && meseNascita == currentMese && giornoNascita > currentGiorno)) {
        const div = input.parentNode;

        div.classList.add('errore');
        div.querySelector(".hidden").classList.remove("hidden");
    }
    else {
        const div = input.parentNode;

        div.classList.remove('errore');
        div.querySelector(".mex").classList.add("hidden");
    }
}


console.log(document.getElementById('username'));

document.getElementById("name").addEventListener('blur', checkName);
document.getElementById("surname").addEventListener('blur', checkSurname);
document.getElementById("email").addEventListener('blur', checkEmail);
document.getElementById("password").addEventListener('blur', checkPassword);
document.getElementById("confPass").addEventListener('blur', checkConfirmPassword);
document.getElementById("username").addEventListener('blur', checkUsername);
document.getElementById("data").addEventListener('blur', checkData);
