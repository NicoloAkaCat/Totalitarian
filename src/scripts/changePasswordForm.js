import { showFormError, removeFormError, passwordRegex } from './formUtils.js';

const pass = document.querySelector('#pass');
const newPass = document.querySelector('#newPass');
const newPassConfirm = document.querySelector('#newPassConfirm');
const inputs = [pass, newPass, newPassConfirm];

const button = document.querySelector('#submit');

button.addEventListener('click', (event) => {
    let err = false;

    inputs.forEach(field => {
        if(field.value === ''){
            showFormError(field, 'Field required')
            err = true;
        }
        else
            removeFormError(field, 'Field required');
    });

    if(newPass.value !== newPassConfirm.value){
        showFormError(newPass, 'Passwords do not match');
        showFormError(newPassConfirm, 'Passwords do not match');
        err = true
    }
    else{
        removeFormError(newPass, 'Passwords do not match');
        removeFormError(newPassConfirm, 'Passwords do not match');
    }

    if(!passwordRegex.test(newPass.value)){
        showFormError(newPass, 'Password must contain at least 8 characters, one uppercase, one lowercase, one number and one special character');
        err = true;
    }
    else
        removeFormError(newPass, 'Password must contain at least 8 characters, one uppercase, one lowercase, one number and one special character');

    if(err)
        event.preventDefault();
})