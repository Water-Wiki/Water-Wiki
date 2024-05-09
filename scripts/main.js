document.getElementById("openForm").addEventListener('click', x => {
    if (document.getElementById("overlay").style.display == "none") {
        document.getElementById("overlay").style.display = "block";
    } else {
        document.getElementById("overlay").style.display = "none";
    };
});

document.getElementById("openReply").addEventListener('click', x => {
    if (document.getElementById("replyOverlay").style.display == "none") {
        document.getElementById("replyOverlay").style.display = "block";
    } else {
        document.getElementById("replyOverlay").style.display = "none";
    };
});