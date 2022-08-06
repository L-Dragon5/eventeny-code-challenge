$(document).ready(function() {
  /**
   * Attach event handlers for buttons.
   */
  function attachEventHandlers() {
    // Add discount code event handler.
    $('.add-discount-code').on('click', function(e) {
      e.preventDefault();
      const discountCode = {};
  
      // Open modal.
      openModal();

      // Set handler for form submission.
      $('#admin-discount-code-form').unbind('submit');
      $('#admin-discount-code-form').on('submit', function(e) {
        e.preventDefault();
        $.each($(this).serializeArray(), function(i, field) {
          discountCode[field.name] = field.value;
        });

        $.ajax({
          type: 'POST',
          data: {
            action: 'ADD',
            discountCode: discountCode,
          },
          url: 'php/DiscountCodeHandler.php',
          success: function(data) {
            console.log(data);
          }
        });
      });
    });
  
    // Edit discount code event handler.
    $('.action.edit').on('click', function(e) {
      e.preventDefault();
      const id = $(this).data('id');
      const discountCode = {id: id};
  
      // Open modal.
      openModal();

      // Set handler for form submission.
      $('#admin-discount-code-form').unbind('submit');
      $('#admin-discount-code-form').on('submit', function(e) {
        e.preventDefault();
        $.each($(this).serializeArray(), function(i, field) {
          discountCode[field.name] = field.value;
        });

        $.ajax({
          type: 'POST',
          data: {
            action: 'EDIT',
            id: id,
            discountCode: discountCode,
          },
          url: 'php/DiscountCodeHandler.php',
          success: function(data) {
            console.log(data);
          }
        });
      });
    });
  
    // Remove discount code event handler.
    $('.action.delete').on('click', function(e) {
      e.preventDefault();
      const id = $(this).data('id');
  
      $.ajax({
        type: 'POST',
        data: {
          action: 'REMOVE',
          id: id,
        },
        url: 'php/DiscountCodeHandler.php',
        success: function(data) {
          if (data) {
            getDiscountCodes();
          }
        }
      });
    });
  
    // Close modal when clicking outside the modal contents.
    $('.modal-screen').on('click', function() {
      closeModal();
    });
  
    // Modal close button.
    $('.close').on('click', function() {
      closeModal();
    });
  }
  
  /**
   * Retrieve discount codes from DB and display.
   */
  function getDiscountCodes() {
    $.ajax({
      type: 'POST',
      data: {
        action: 'LOAD',
      },
      url: 'php/DiscountCodeHandler.php',
      success: displayDiscountCodes
    })
  }
  
  /**
   * Display table body of discount codes and then attach handlers.
   * 
   * @param {*} data 
   */
  function displayDiscountCodes(data) {
    const discountCodes = JSON.parse(data);
    if (discountCodes.length) {
      $('table.admin tbody').html(discountCodes.map(code =>
        `<tr>
          <td>${code.name}</td>
          <td>${code.type === 'P' ? 'Percentage' : 'Fixed Amount'}</td>
          <td>${code.type === 'P' ? code.amount + '%' : '$' + code.amount}</td>
          <td>${code.start_date}</td>
          <td>${code.end_date}</td>
          <td>${code.num_uses}</td>
          <td>
            <button class="button action edit" data-id="${code.id}">Edit</button>
            <button class="button action delete" data-id="${code.id}">Delete</button>
          </td>
        </tr>`  
      ));
    } else {
      $('table.admin tbody').html('<tr><td>No discount codes found.</td></tr>');
    }
  
    attachEventHandlers();
  }
  
  /**
   * Open modal and screen.
   */
  function openModal() {
    $('.modal-screen').css({ display: 'block' });
    $('.modal').css({ display: 'flex' });
  }
  
  /**
   * Close modal and screen.
   */
  function closeModal() {
    $('.modal-screen').hide();
    $('.modal').hide();
  }

  // Get discount codes and display when ready.
  getDiscountCodes();
});

