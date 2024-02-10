const hamburger = document.querySelector('.menu-hamburger')
const nav = document.querySelector('.nav')

hamburger.addEventListener('click', () => {
    nav.classList.toggle('nav--visible')
    hamburger.classList.toggle('menu-hamburger--animation')
})

const duxBtn = document.querySelector('.dux');
duxBtn.addEventListener('click', () => {
    const main = document.querySelector('main');
    if(main.style.transform === 'rotate(180deg)') {
        main.style.transform = 'rotate(0deg)';
    } else {
        main.style.transform = 'rotate(180deg)';
    }
})