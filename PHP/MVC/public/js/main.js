document.addEventListener('DOMContentLoaded', () => {
    let userButton = document.getElementById('userButton');
    let userDropdown = document.getElementById('userDropdown');
    let menuIcon = document.getElementById('menuIcon');
    let sidebar = document.getElementById('sidebar');
    let closeBtn = document.getElementById('closeBtn');
    let userIcon = document.querySelector('.user-icon');

    let commandeLink = document.getElementById('commandeLink');
    let commandeSubmenu = document.getElementById('commandeSubmenu');

    let adminLink = document.getElementById('adminLink');
    let adminSubmenu = document.getElementById('adminSubmenu');

    let horlogeLink = document.getElementById('horlogeLink');
    let horlogeSubmenu = document.getElementById('horlogeSubmenu');

    userButton.addEventListener('click', () => {
        userButton.parentElement.classList.toggle('active');
    });

    document.addEventListener('click', (event) => {
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
        commandeSubmenu.style.display = commandeSubmenu.style.display === 'block' ? 'none' : 'block';
        adminSubmenu.style.display = 'none';
        horlogeSubmenu.style.display = 'none';
    });

    adminLink.addEventListener('click', (event) => {
        event.preventDefault();
        adminSubmenu.style.display = adminSubmenu.style.display === 'block' ? 'none' : 'block';
        commandeSubmenu.style.display = 'none';
        horlogeSubmenu.style.display = 'none';
    });

    horlogeLink.addEventListener('click', (event) => {
        event.preventDefault();
        horlogeSubmenu.style.display = horlogeSubmenu.style.display === 'block' ? 'none' : 'block';
        commandeSubmenu.style.display = 'none';
        adminSubmenu.style.display = 'none';
    });
});
