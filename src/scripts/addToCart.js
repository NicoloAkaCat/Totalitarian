import { showNotification } from './notifications.js';
const btn = document.querySelector('.product__info__buy__btn');
const imgElement = document.querySelector('.product__image');

const id = window.location.search.substring(4);
const productName = document.querySelector('.product__info__name').textContent;
const price = document.querySelector('.product__info__buy__price').textContent;
const imgSrc = imgElement.getAttribute('src');
const imgAlt = imgElement.getAttribute('alt');

const toAdd = {
    id,
    productName,
    price,
    imgSrc,
    imgAlt
}

btn.addEventListener('click', (e) => {
    e.preventDefault();
    if(btn.textContent === 'Out of Stock'){
        showNotification('#main-container', 'Item out of stock', false);
        return;
    }
    let cart = localStorage.getItem('cart');
    if(cart === null)
        cart = [toAdd];
    else{
        cart = JSON.parse(cart);
        for(let i = 0; i < cart.length; i++){
            if(cart[i].id === toAdd.id){
                showNotification('#main-container', 'Item already in cart', false);
                return;
            }
        }
        cart.push(toAdd);
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    showNotification('#main-container', 'Item added to cart!', true);
})