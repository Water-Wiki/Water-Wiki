document.getElementById("openForm").addEventListener('click', x => {
    if (document.getElementById("forumOverlay").style.display == "none") {
        document.getElementById("forumOverlay").style.display = "block";
    } else {
        document.getElementById("forumOverlay").style.display = "none";
    };
});