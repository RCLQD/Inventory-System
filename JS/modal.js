let button = document.getElementById('btn');
    let closeBTN = document.getElementById('closeBTN');
    let modal = document.getElementById('modal');

    button.addEventListener('click', function() {
        modal.showModal();
    });

    closeBTN.addEventListener('click', function() {
        modal.close();
    });