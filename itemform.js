const dropZone = document.querySelector('.drop-zone');
const imageInput = document.querySelector('#image-input');
const imagePreview = document.querySelector('.image-preview');
const fileText = document.querySelector('.file-text');

// Drag & Drop functionality
dropZone.addEventListener('dragover', (event) => {
  event.preventDefault();
  dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
  dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (event) => {
  event.preventDefault();
  dropZone.classList.remove('dragover');
  const files = event.dataTransfer.files;
  displayImages(files);
  hideFileText();
});

// File selection from input element
imageInput.addEventListener('change', (event) => {
  const files = event.target.files;
  displayImages(files);
  hideFileText();
});

function displayImages(files) {
  imagePreview.innerHTML = '';
  for (const file of files) {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (event) {
      const image = document.createElement('img');
      image.src = event.target.result; // Set image source to the base64-encoded data URL
      imagePreview.appendChild(image); // Append the image to the preview area
    };
  }
}

function hideFileText() {
  fileText.classList.add('hidden');
}