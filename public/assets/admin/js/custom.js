/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 * ---------------------------------------------------------------------------- */
$(document).ready(function() {
  // Initialize tokenfield bootstrap component
  $('.tokenfield').tokenfield({
    delimiter: ',',
    createTokensOnBlur: true
  });
});
