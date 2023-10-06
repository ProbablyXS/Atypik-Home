// Get all the text fields with the class 'edit_form_account_info'
const textFields = document.querySelectorAll('.edit_form_account_info');
const radios = document.querySelectorAll('.edit_form_account_info_radio'); // Assuming you have a class for radio buttons
const imageFileInput = document.querySelector('.edit_form_account_info_image_file'); // Assuming you have a class for the image file input
const button = document.getElementById('account-info-btn-save');

// Create an object to store the initial values
const initialValues = {};

// Store the initial values of all text fields
textFields.forEach(textField => {
  initialValues[textField.id] = textField.value;
});

// Store the initial values of all radio buttons
radios.forEach(radio => {
  const checkedInput = radio.querySelector('input:checked');
  if (checkedInput) {
    initialValues[radio.id] = checkedInput.value; // Store the initial selected value of radios
  }
});

// Store the initial value of the image file input
const initialImageFileValue = imageFileInput.value;

// Function to check if imageFile is not empty
function isImageFileNotEmpty() {
  return imageFileInput.files && imageFileInput.files.length > 0;
}

// Function to update the button class based on input changes
function updateButtonClass() {
  const isModified = Array.from(textFields).some(textField => textField.value !== initialValues[textField.id]);

  const isRadioModified = Array.from(radios).some(radio => {
    const checkedInput = radio.querySelector('input:checked');
    return checkedInput && checkedInput.value !== initialValues[radio.id];
  });

  const isImageModified = imageFileInput.value !== initialImageFileValue || isImageFileNotEmpty();

  if (isModified || isRadioModified || isImageModified) {
    button.classList.remove('btn-disabled');
    button.classList.add('btn-enabled');
  } else {
    button.classList.remove('btn-enabled');
    button.classList.add('btn-disabled');
  }
}

// Add an 'input' event listener to each text field
textFields.forEach(textField => {
  textField.addEventListener('input', updateButtonClass);
});

// Add a 'change' event listener to each radio button
radios.forEach(radio => {
  radio.addEventListener('change', updateButtonClass);
});

// Add a 'change' event listener to the imageFile input
imageFileInput.addEventListener('change', updateButtonClass);

// Call the function initially to set the initial state
updateButtonClass();

// Get the image and file input elements
const imageContainer = document.getElementById('image-container');

// Add a click event listener to the image container
imageContainer.addEventListener('click', () => {
  // Trigger a click on the hidden file input
  imageFileInput.click();
});

// Add an event listener to the file input to handle file selection
imageFileInput.addEventListener('change', (event) => {
  // Display the selected image (assuming you want to display the selected image)
  const selectedFile = event.target.files[0];
  if (selectedFile) {
    const reader = new FileReader();
    reader.onload = (e) => {
      // Set the image source to the selected file
      imageContainer.querySelector('img').src = e.target.result;
    };
    reader.readAsDataURL(selectedFile);
  }
});