export const emailRegex = new RegExp(/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/);
export const passwordRegex = new RegExp(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/);

export function checkEmailAlreadyInUse(email) {
    return fetch(`/Totalitarian/src/auth/check_email.php?email=${email}`, {
        method: 'GET',
    })
    .then((response) => response.json())
    .then((json) => {
        if (json['status'] === 'error') {
            window.location.replace('/Totalitarian/src/error/error_page.php');
        }
        return json['exists'] === true;
    })
    .catch(e => alert('Something went wrong, Try Again'));
}

export function showFormError(field, msg) {
    const errElement = document.querySelector(`#err${field.id}`);
    const errorShown = errElement !== null;
    if(!errorShown){
        field.classList.add('form__input--error');
        field.setAttribute('aria-invalid', 'true');
        field.insertAdjacentHTML('afterend', `<div class="form__error-msg text-small" id="err${field.id}">${msg}</div>`);
        field.setAttribute('aria-describedby', `err${field.id}`);
    }else if(errElement.innerText !== msg){
        errElement.innerText = msg;
    }
}

export function removeFormError(field, msg) {
    const errElement = document.querySelector(`#err${field.id}`);
    const errorShown = errElement !== null && errElement.innerText === msg;
    if(errorShown){
        errElement.remove();
        field.classList.remove('form__input--error');
        field.removeAttribute('aria-invalid');
        field.removeAttribute('aria-describedby');
    }
}

export function showAriaError(){
    const msg = document.querySelector('.sr-only');
    const shown = msg !== null;
    if(!shown)
        document.querySelector('main').insertAdjacentHTML('afterbegin', 
            `<div aria-live="assertive" class="sr-only">Some error occured, please check your inputs for more details</div>`
        );
    else{
        const newMsg = msg.cloneNode(true);
        msg.remove();
        document.querySelector('main').appendChild(newMsg);
    }
}