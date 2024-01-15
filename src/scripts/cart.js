let cart = localStorage.getItem('cart');
if(cart != null){
    cart = JSON.parse(cart);
    let productIds = [];
    cart.forEach(product => {
        productIds.push(product.id);
    });

    fetch('/Totalitarian/src/pages/check_products.php', {
        method: 'POST',
        body: JSON.stringify(productIds),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(json => {
        if(json['status'] === 'error'){
            window.location.replace('/Totalitarian/src/error/error_page.php')
        }
        if(json['status'] === 'ok'){
            const products = document.querySelector('.product-list');
            //TODO insert products
        }
    })
    .catch(error => console.log(error));
}