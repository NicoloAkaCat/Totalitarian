export function showNotification(containerSelector, msg, success){
    const container = document.querySelector(`${containerSelector}`);
    container.insertAdjacentHTML('afterbegin', 
        `<div aria-live="assertive" class="notification ${success ? 'notification--success' : 'notification--failure'} text-small">${msg}</div>`
    );
    setTimeout(() => {
        document.querySelector('.notification').remove();
    }, 2000);
}