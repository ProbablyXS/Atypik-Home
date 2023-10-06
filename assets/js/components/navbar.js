document.addEventListener("DOMContentLoaded", function () {
    var btnHamb = document.querySelector(".btn-hamb");
    var menuEntryElements = document.querySelectorAll(".menu-entry");

    btnHamb.addEventListener("click", function () {
        menuEntryElements.forEach(function (element) {
            if (window.innerWidth <= 1120) {
                if (element.style.display === "") {
                    element.style.display = "flex";
                    return;
                }

                if (element.style.display === "none") {
                    element.style.display = "flex";
                } else {
                    element.style.display = "none";
                }
            }
        });
    });
});

function handleResize() {
    var menuEntryElements = document.querySelectorAll(".menu-entry");

    menuEntryElements.forEach(function (element) {
        if (window.innerWidth >= 1120) {
            if (element.style.display) {
                element.style.display = "";
            }
        }
    });
}

window.addEventListener('resize', handleResize);