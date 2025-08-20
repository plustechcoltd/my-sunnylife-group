import { swalInit } from '../../index.js';

window.deleteConfirm = function(url, id) {
  swalInit.fire({
    title: 'Are you sure?',
    text: 'You won\'t be able to revert this!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
  }).then((result) => {
    if (result.isConfirmed) {
      const forms = Array.from(document.getElementsByClassName('delete-form'));
      const form = forms.find(form => form.dataset.id == id);
      if (form) {
        form.action = url;
        form.submit();
      }
    }
  });
};
