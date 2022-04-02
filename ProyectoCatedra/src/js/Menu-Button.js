document.addEventListener('DOMContentLoaded', function() {
    eventListener();
});

function eventListener() {
    const MenuButton = document.querySelector('.Button-Menu');
    

    //Eventos para el boton de menu
    MenuButton.addEventListener("click", Menu_Button);
    MenuButton.addEventListener("click", Menu_Sidebar);
}

function Menu_Button() {
    const topLine = document.querySelector('.top-line');
    const midLine = document.querySelector('.mid-line');
    const botLine = document.querySelector('.bot-line');

    topLine.classList.toggle('active');
    midLine.classList.toggle('active');
    botLine.classList.toggle('active');
}

function Menu_Sidebar() {
    const Sidebar = document.querySelector('.Sidebar');

    Sidebar.classList.toggle('active');
}
