document.addEventListener('DOMContentLoaded', function() {

    document.querySelector('.success-message').style.display = 'block';

    setTimeout(function() {
        document.querySelector('.success-message').style.display = 'none';
    }, 3000);
});