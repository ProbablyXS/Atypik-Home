//SCROLL BUTTON
document.addEventListener("DOMContentLoaded", function() {
    const scrollButton = document.getElementById("scrollButton");

    scrollButton.addEventListener("click", function() {
        const section = document.getElementById(`section1`);
        
        if (section) {
            const sectionTop = section.offsetTop;
            window.scrollTo({
                top: sectionTop,
                behavior: "smooth"
            });
        }
    });
});