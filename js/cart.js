$(document).ready(function() {
  $('.apply-discount-code').on('submit', function(e) {
    e.preventDefault();
    const discountCodeValue = $('#discount-code-input').val();
    if (!discountCodeValue.length) {
      $('.discount-code-error').text('Discount code field cannot be blank.');
      $('.discount-code-error').show();
    } else {
      $('.discount-code-form').submit();
    }
  });
});
