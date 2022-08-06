$(document).ready(function() {
  getDiscountCodes();
});

function attachEventHandlers() {
  // Add discount code event handler.
  $('.action.add').on('click', function(e) {
    e.preventDefault();
    const discountCode = {};

    // Open modal.

    /*
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
    */
  });

  // Edit discount code event handler.
  $('.action.edit').on('click', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    // Open modal.

    // Submit on save.
    /*
    $.ajax({
      type: 'POST',
      data: {
        action: 'EDIT',
        id: id,
      },
      url: 'php/DiscountCodeHandler.php',
      success: function(data) {
        console.log(data);
      }
    });
    */
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
}

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
          <span class="button action edit" data-id="${code.id}">Edit</span>
          <span class="button action delete" data-id="${code.id}">Delete</span>
        </td>
      </tr>`  
    ));
  } else {
    $('table.admin tbody').html('<tr><td>No discount codes found.</td></tr>');
  }

  attachEventHandlers();
}
