document.addEventListener('DOMContentLoaded', function() {
    var passwordInput = document.querySelector('input[type="password"]');
    var updateMessage = document.getElementById("UpdateMessage");

    function removeErrorMessage() {
        if (updateMessage) {
            updateMessage.parentNode.removeChild(updateMessage);
        }
        var parent = passwordInput.closest('.error');
        if (parent) {
            parent.classList.remove('error');
        }
    }

    if (updateMessage) {
        updateMessage.parentNode.classList.add('error');
        passwordInput.placeholder = "Invalid Access Key";
    }

    passwordInput.addEventListener('focus', function() {
        removeErrorMessage();
    });

    passwordInput.addEventListener('click', function() {
        passwordInput.placeholder = "Enter Accesskey";
        removeErrorMessage();
    });
});