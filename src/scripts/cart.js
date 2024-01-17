document.querySelector('.empty-cart__msg').textContent = 'WHY IS YOUR CART EMPTY??';
let cart = localStorage.getItem('cart');

if(cart != null){
    document.querySelector('.empty-cart').remove();
    cart = JSON.parse(cart);
    checkProducts(cart).then(() => {
        const products = document.querySelector('.product-list');
        cart.forEach(product => {
            products.insertAdjacentHTML('beforeend', `
                <article class="product row" id="prod${product.id}">
                    <button class="product__remove" id="rm${product.id}"><span>&#10005;</span></button>
                    <img class="product__img" src="${product.imgSrc}" alt="${product.imgAlt}">
                    <div class="product__info row flex-center">
                        <div class="product__info__name text-small">${product.productName}</div>
                        <div class="product__info__price text-small">${product.price}</div>
                        <div class="product__info__quantity column flex-center text-small">
                            <button class="product__info__quantity__plus text-small" id="plus${product.id}"><span>&#43;</span></button>
                            <div class="product__info__quantity__value text-small" id="value${product.id}">1</div>
                            <button class="product__info__quantity__minus text-small" id="minus${product.id}"><span>&#8722;</span></button>
                        </div>
                    </div>
                </article>`
            );
            document.querySelector(`#plus${product.id}`).addEventListener('click', () => {
                let valueEl = document.querySelector(`#value${product.id}`);
                valueEl.textContent = parseInt(valueEl.textContent) + 1;
            });
            document.querySelector(`#minus${product.id}`).addEventListener('click', () => {
                let valueEl = document.querySelector(`#value${product.id}`);
                let value = parseInt(valueEl.textContent) - 1;
                valueEl.textContent = value < 1 ? 1 : value;
            });
            document.querySelector(`#rm${product.id}`).addEventListener('click', () => {
                document.querySelector(`#prod${product.id}`).remove();
                cart = cart.filter(p => p.id != product.id);
                cart.length === 0 ? localStorage.removeItem('cart') : localStorage.setItem('cart', JSON.stringify(cart));
            });
        });
    })
}

function checkProducts(cart){
    let productIds = [];
    cart.forEach(product => {
        productIds.push(product.id);
    });

    return fetch('/Totalitarian/src/pages/check_products.php', {
        method: 'POST',
        body: JSON.stringify(productIds),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(json => {
        if(json['status'] === 'error')
            window.location.replace('/Totalitarian/src/error/error_page.php')
        if(json['status'] === 'ok')
            return;
    })
    .catch(error => console.log(error));
}