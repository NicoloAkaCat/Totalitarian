import { removeFormError, showFormError } from './formUtils.js';

const email = document.querySelector('#email');
const pass = document.querySelector('#pass');
const button = document.querySelector('#submit');

button.addEventListener('click', (event) => {
    if( email.value === ''){
        showFormError(email, 'Field required');
        event.preventDefault();
    } else
        removeFormError(email, 'Field required');
        
    if(pass.value === '') {
        showFormError(pass, 'Field required');
        event.preventDefault();
    } else
        removeFormError(pass, 'Field required');
})
