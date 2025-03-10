document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNavigation = document.querySelector('.main-navigation');

    menuToggle.addEventListener('click', function () {
        mainNavigation.classList.toggle('active');
    });
});