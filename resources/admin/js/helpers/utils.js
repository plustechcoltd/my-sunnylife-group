export function previewFile(fileInput, previewElement = $('#preview')) {
  const file = fileInput.get(0).files[0];
  const reader = new FileReader();

  reader.onloadend = function () {
    previewElement.attr('src', reader.result);
  }

  if (file) {
    reader.readAsDataURL(file);
    previewElement.parent().removeClass('d-none');
  } else {
    previewElement.attr('src', "");
  }
}