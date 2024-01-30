import { showFormError, removeFormError, emailRegex, passwordRegex, checkEmailAlreadyInUse } from './formUtils.js';

const firstName = document.querySelector('#firstname');
const lastName = document.querySelector('#lastname');
const email = document.querySelector('#email');
const pass = document.querySelector('#pass');
const confirmPass = document.querySelector('#confirm');
const inputs = [firstName, lastName, email, pass, confirmPass];

const button = document.querySelector('#submit');

let emailError = false;
email.addEventListener('change', () => {
    let err = false;
    checkEmailAlreadyInUse(email.value)
    .then((exists) => {
        if(exists){
            showFormError(email, 'Email already in use');
            err = true;
        }
        else
            removeFormError(email, 'Email already in use');

        if(!emailRegex.test(email.value)){
            showFormError(email, 'Invalid email');
            err = true;
        }
        else
            removeFormError(email, 'Invalid email');
    
        emailError = err;
    })
})

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

    if(pass.value !== confirmPass.value){
        showFormError(pass, 'Passwords do not match');
        showFormError(confirmPass, 'Passwords do not match');
        err = true
    }
    else{
        removeFormError(pass, 'Passwords do not match');
        removeFormError(confirmPass, 'Passwords do not match');
    }

    if(!passwordRegex.test(pass.value)){
        showFormError(pass, 'Password must contain at least 8 characters, one uppercase, one lowercase, one number and one special character');
        err = true;
    }
    else
        removeFormError(pass, 'Password must contain at least 8 characters, one uppercase, one lowercase, one number and one special character');

    if(err || emailError)
        event.preventDefault();
})