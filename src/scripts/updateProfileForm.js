import { showFormError, removeFormError, emailRegex, checkEmailAlreadyInUse } from './formUtils.js';

const firstName = document.querySelector('#firstname');
const lastName = document.querySelector('#lastname');
const email = document.querySelector('#email');
const inputs = [firstName, lastName, email];

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

    if(err || emailError)
        event.preventDefault();
})