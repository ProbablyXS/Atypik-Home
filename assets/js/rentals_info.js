//SCROLL BUTTON
document.addEventListener("DOMContentLoaded", function() {
    const scrollButton = document.getElementById("scrollButton");

    scrollButton.addEventListener("click", function() {
        const section = document.getElementById(`map`);
        
        if (section) {
            const sectionTop = section.offsetTop - 50;
            window.scrollTo({
                top: sectionTop,
                behavior: "smooth"
            });
        }
    });
});







var modal = document.getElementById("myModal");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
var currentIndex = 0;
var imgElements = document.querySelectorAll(".img-list-first img, .img-list-second img");

// Function to open the modal
function openModal(index) {
  currentIndex = index;
  modal.style.display = "flex";
  modalImg.src = imgElements[index].src;
  updateCaption();
}

// Function to close the modal
function closeModal() {
  modal.style.display = "none";
}

// Function to change the displayed image
function changeImage(direction) {
  currentIndex += direction;

  if (currentIndex < 0) {
    currentIndex = imgElements.length - 1;
  } else if (currentIndex >= imgElements.length) {
    currentIndex = 0;
  }

  modalImg.src = imgElements[currentIndex].src;
  updateCaption();
}

// Function to update the caption with image count
function updateCaption() {
  captionText.innerHTML = " (" + (currentIndex + 1) + " / " + imgElements.length + ")";
}

// Add click event listeners to all image elements
imgElements.forEach(function(img, index) {
  img.addEventListener("click", function() {
    openModal(index);
  });
});

// Get the <span> element that closes the modal and add click event listener
var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
  closeModal();
};

// Get the previous and next buttons and add click event listeners
var prevButton = document.getElementsByClassName("prev")[0];
var nextButton = document.getElementsByClassName("next")[0];

prevButton.onclick = function() {
  changeImage(-1);
};

nextButton.onclick = function() {
  changeImage(1);
};
