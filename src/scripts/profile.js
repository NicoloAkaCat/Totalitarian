import {showNotification} from './notifications.js';

const shouldShow = document.querySelector('#js-notify');
if(shouldShow !== null){
    showNotification('#main-container', 'Update successfull!', true);
    shouldShow.remove();
}