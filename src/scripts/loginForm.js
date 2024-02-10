import { removeFormError, showFormError, emailRegex, showAriaError } from './formUtils.js';

const email = document.querySelector('#email');
const pass = document.querySelector('#pass');
const button = document.querySelector('#submit');

button.addEventListener('click', (event) => {
    let err = false;

    if(email.value === ''){
        showFormError(email, 'Field required');
        err = true;
    } 
    else
        removeFormError(email, 'Field required');

    if(!emailRegex.test(email.value)){
        showFormError(email, 'Invalid email');
        err = true;
    } 
    else
        removeFormError(email, 'Invalid email');
        
    if(pass.value === '') {
        showFormError(pass, 'Field required');
        err = true;
    } 
    else
        removeFormError(pass, 'Field required');

    if(err){
        event.preventDefault();
        showAriaError();
    }
})
