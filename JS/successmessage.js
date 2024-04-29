setTimeout(function() {
    var updateMessage = document.getElementById("UpdateMessage");
    if (updateMessage) {
        updateMessage.parentNode.removeChild(updateMessage);
    }
}, 3000);