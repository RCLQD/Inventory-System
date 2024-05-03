setTimeout(function() {
    var LogoutMessage = document.getElementById("LogoutMessage");
    if (LogoutMessage) {
        LogoutMessage.parentNode.removeChild(LogoutMessage);
    }
}, 2000);