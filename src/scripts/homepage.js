let lastPosition = 0;
let currentPosition = 0;
const header = document.querySelector('header');
const topBtn = document.querySelector('.top-btn');
topBtn.style.display = 'none';

window.onscroll = (e) => {
    currentPosition = window.scrollY;
    if(currentPosition > lastPosition)
        header.style.transform = 'translateY(-100%)';
    else
        header.style.transform = 'translateY(0)';

    if(currentPosition > 1000) 
        topBtn.style.display = 'block';
    else
        topBtn.style.display = 'none'; 
    
    lastPosition = currentPosition;
}