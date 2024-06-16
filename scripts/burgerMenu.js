const burgerBtn = document.querySelector('.burger-menu-icon');

burgerBtn.addEventListener('click', () => {
    const menu = document.querySelector('.burger-menu');
    menu.classList.toggle('hidden');
})