export const emailRegex = new RegExp(/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/, 'g');

export function showFormError(field, msg) {
    const errorShown = field.nextElementSibling.nodeName === 'DIV';
    if(!errorShown){
        field.classList.add('form__input--error');
        field.insertAdjacentHTML('afterend', `<div class="form__error-msg text-small">${msg}</div>`);
    }else if(field.nextElementSibling.innerText !== msg){
        field.nextElementSibling.innerText = msg;
    }
}

export function removeFormError(field, msg) {
    const errorShown = field.nextElementSibling.nodeName === 'DIV' && field.nextElementSibling.innerText === msg;
    if(errorShown){
        field.nextElementSibling.remove();
        field.classList.remove('form__input--error');
    }
}