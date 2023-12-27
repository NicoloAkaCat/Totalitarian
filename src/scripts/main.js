const menu = document.querySelector('.menu')
const hamburger = document.querySelector('.menu__hamburger')
const nav = document.querySelector('.nav')

menu.addEventListener('click', () => {
    nav.classList.toggle('nav--visible')
    hamburger.classList.toggle('hamburger--animation')
})