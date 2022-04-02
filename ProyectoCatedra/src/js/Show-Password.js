document.addEventListener('DOMContentLoaded', function() {
    eventListener();
});

function eventListener() {
    const Visibity1 = document.querySelector('#Visibility1');
    const Visibity2 = document.querySelector('#Visibility2');
    
    //Eventos para el boton de menu
    Visibity1.addEventListener("click", Show_Password1);
    Visibity1.addEventListener("click", ChangeImage1);
    Visibity2.addEventListener("click", Show_Password2);
    Visibity2.addEventListener("click", ChangeImage2);
}

function Show_Password1() {
    const InputPass = document.querySelector('#PasswordUsuario');

    if(InputPass.type == "password"){
        InputPass.type = "text";
    }
    else {
        InputPass.type = "password";
    }
}

function Show_Password2() {
    const InputPass = document.querySelector('#Rpassword');

    if(InputPass.type == "password"){
        InputPass.type = "text";
    }
    else {
        InputPass.type = "password";
    }
}

function ChangeImage1() {
    const param = document.querySelector('#Visibility1');

    if(param.textContent == 'visibility') {
        param.textContent = 'visibility_off'
    }
    else {
        param.textContent = 'visibility'
    }
}

function ChangeImage2() {
    const param = document.querySelector('#Visibility2');

    if(param.textContent == 'visibility') {
        param.textContent = 'visibility_off'
    }
    else {
        param.textContent = 'visibility'
    }
}