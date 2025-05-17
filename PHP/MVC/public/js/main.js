document.addEventListener('DOMContentLoaded', () => {
    let userButton = document.getElementById('userButton');
    let userDropdown = document.getElementById('userDropdown');
    let menuIcon = document.getElementById('menuIcon');
    let sidebar = document.getElementById('sidebar');
    let closeBtn = document.getElementById('closeBtn');
    let userIcon = document.querySelector('.user-icon');
    let commandeLink = document.getElementById('commandeLink');
    let horlogeLink = document.getElementById('horlogeLink');
    let commandeSubmenu = document.getElementById('commandeSubmenu');
    let horlogeSubmenu = document.getElementById('horlogeSubmenu');


    userButton.addEventListener('click',() => {
        userButton.parentElement.classList.toggle('active');
    });

    document.addEventListener('click',(event) => {
        if (!userButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userButton.parentElement.classList.remove('active');
        }
    });

    userButton.addEventListener('mouseenter', () => {
        userIcon.style.transform = 'rotate(360deg)';
    });

    userButton.addEventListener('mouseleave', () => {
        userIcon.style.transform = 'rotate(0deg)';
    });


    menuIcon.addEventListener('click', () => {
        sidebar.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('active');
    });


    document.addEventListener('click', (event) => {
        if (!sidebar.contains(event.target) && !menuIcon.contains(event.target) && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });


    let themeToggle = document.getElementById('themeToggle');
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
    });


    commandeLink.addEventListener('click', (event) => {
        event.preventDefault();
        if (commandeSubmenu.style.display === 'block') {
            commandeSubmenu.style.display = 'none';
        } else {
            commandeSubmenu.style.display = 'block';
            horlogeSubmenu.style.display = 'none'; 
        }
    });


    horlogeLink.addEventListener('click', (event) => {
        event.preventDefault();
        if (horlogeSubmenu.style.display === 'block') {
            horlogeSubmenu.style.display = 'none';
        } else {
            horlogeSubmenu.style.display = 'block';
            commandeSubmenu.style.display = 'none'; 
        }
    });
});