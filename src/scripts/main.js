const hamburger = document.querySelector('.menu-hamburger')
const nav = document.querySelector('.nav')

hamburger.addEventListener('click', () => {
    nav.classList.toggle('nav--visible')
    hamburger.classList.toggle('menu-hamburger--animation')
})