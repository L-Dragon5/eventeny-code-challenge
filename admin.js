$(document).ready(function() {
  getDiscountCodes();
  
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
      success: function (data) {
        console.log(data);
      }
    });
  })
});

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
  console.log(discountCodes);
  $('table.admin tbody').html('blah');
}

/*
  <?php if (empty($discountCodes)): ?>
          <tr id=>
            <td colspan="7" style="text-align: center;">No discount codes found.</td>
          </tr>
          <?php else: ?>
            <?php foreach ($discountCodes as $code): ?>
              <tr>
                <td><?php echo $code->name; ?></td>
                <td><?php echo ($code->type === 'P' ? 'Percentage' : 'Fixed Amount'); ?></td>
                <td><?php echo ($code->type === 'P' ? $code->amount . '%' : '$' . $code->amount); ?></td>
                <td><?php echo $code->start_date; ?></td>
                <td><?php echo $code->end_date; ?></td>
                <td><?php echo $code->num_uses; ?></td>
                <td>
                  <span class="button action edit" data-id="<?php echo $code->id; ?>">Edit</span>
                  <span class="button action delete" data-id="<?php echo $code->id; ?>">Delete</span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
*/