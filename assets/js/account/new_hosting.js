// Get the image container and file input elements
const imageContainer = document.getElementById('new_hosting_form_imageFilesBtn');
const imageFilesInput = document.querySelector('.edit_form_account_info_image_file'); // Assuming you have a class for the image file input

// Add a click event listener to the image container
imageContainer.addEventListener('click', () => {
  // Trigger a click on the hidden file input
  imageFilesInput.click();
});

// Add an event listener to the file input to handle file selection
imageFilesInput.addEventListener('change', (event) => {
  // Get the container where you want to display the selected images
  const imageListContainer = document.getElementById('image-container');

  // Clear the existing images in the container
  imageListContainer.innerHTML = '';

  // Loop through all selected files
  for (const file of event.target.files) {

    if (event.target.files.length > 8) {
      window.confirm("Vous ne pouvez pas dépasser 8 images");
      return;
    }

    if (file) {

      const reader = new FileReader();
      reader.onload = (e) => {
        // Create an image element for each selected file
        const imgElement = document.createElement('img');
        imgElement.src = e.target.result;

        if (event.target.files.length == 1) {
          imageListContainer.classList.add('center-single-image');
          imageListContainer.classList.remove('center-double-image');
        } else if (event.target.files.length == 2) {
          imageListContainer.classList.remove('center-single-image');
          imageListContainer.classList.add('center-double-image');
        } else {
          imageListContainer.classList.remove('center-single-image');
          imageListContainer.classList.remove('center-double-image');
        }

        if (event.target.files[0] == file) {
          imgElement.classList.add('favorite');
        }

        imgElement.classList.add('selected-image'); // Add a class for styling, if needed

        // Append the image to the image list container
        imageListContainer.appendChild(imgElement);

      };
      reader.readAsDataURL(file);
    }
  }
});