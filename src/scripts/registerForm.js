import { showFormError, removeFormError, emailRegex } from './FormUtils.js';

const firstName = document.querySelector('#firstname');
const lastName = document.querySelector('#lastname');
const email = document.querySelector('#email');
const pass = document.querySelector('#pass');
const confirmPass = document.querySelector('#confirm');
const inputs = [firstName, lastName, email, pass, confirmPass];

const button = document.querySelector('#submit');

email.addEventListener('change', () => {
    fetch(`/Totalitarian/src/auth/check_email.php?email=${email.value}`,{
        method: 'GET',
    })
    .then((response) => response.json())
    .then((json) => {
        if(json['exists'] === true)
            showFormError(email, 'Email already in use');
        else
            removeFormError(email, 'Email already in use');
    })
    .catch((error) => console.log(error));

    if(!emailRegex.test(email.value))
        showFormError(email, 'Invalid email');
    else
        removeFormError(email, 'Invalid email');
})

button.addEventListener('click', (event) => {
    let err = false;
    for (let i = 0; i < inputs.length; i++) {
        const field = inputs[i];
        if(field.value === ''){
            showFormError(field, 'Field required')
            err = true;
        }
        else
            removeFormError(field, 'Field required');
    }

    if(pass.value !== confirmPass.value){
        showFormError(pass, 'Passwords do not match');
        showFormError(confirmPass, 'Passwords do not match');
        err = true
    }
    else{
        removeFormError(pass, 'Passwords do not match');
        removeFormError(confirmPass, 'Passwords do not match');
    }

    if(err)
        event.preventDefault();
})
