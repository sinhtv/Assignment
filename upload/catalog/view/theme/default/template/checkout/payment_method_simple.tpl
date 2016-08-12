<legend><?php echo $text_payment_method_title; ?></legend>
<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<?php foreach ($payment_methods as $payment_method) { ?>
<div class="radio">
  <label>
    <?php if ($payment_method['code'] == $code || !$code) { ?>
    <?php $code = $payment_method['code']; ?>
    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" />
    <?php } else { ?>
    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" />
    <?php } ?>
    <?php echo $payment_method['title']; ?>
    <?php if ($payment_method['terms']) { ?>
    (<?php echo $payment_method['terms']; ?>)
    <?php } ?>
  </label>
</div>
<?php } ?>
<div class="payment_information"></div>
<?php } ?>
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="pull-right"><?php echo $text_agree; ?>
    <?php if ($agree) { ?>
    <input type="checkbox" name="agree" value="1" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="agree" value="1" />
    <?php } ?>
  </div>
</div>
<?php } ?>


<script type="text/javascript">
  // Customer group
  $('input[name=\'payment_method\']').on('change', function() {
    $.ajax({
      url: 'index.php?route=checkout/method_simple/load_payment',
      data: $('#collapse-step-2 .payment-method input[type=\'radio\']:checked'),
      dataType: 'text',
      type: 'post',
      success: function(html) {
        if( html )
        {
          $('#collapse-step-2 .payment-method .payment_information').html(html);
          $('#collapse-step-2 .payment-method .payment_information').find('.buttons').css('display','none');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  });
  function isEmpty( el ){
      return !$.trim(el.html())
  }
  $('input[name=\'payment_method\']:checked').trigger('change');

</script>