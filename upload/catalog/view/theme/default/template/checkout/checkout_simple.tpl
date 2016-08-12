<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
      <?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <div class="panel-group" id="accordion">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_step_1; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-step-1">
            <div class="panel-body"></div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_step_2; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-step-2">
            <div class="panel-body">
              <div class="order-confirm"></div>
              <div class="row">
                <div class="col-md-6 shipping-method"></div>
                <div class="col-md-6 payment-method"></div>
                <div class="col-md-12">
                <p><strong><?php echo $text_comments; ?></strong></p>
                <p>
                  <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
                </p>
                </div>
              </div>
              <div class="buttons">
                <div class="pull-right">
                  <input type="button" value="<?php echo $button_order; ?>" id="button-submit" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript">
// Step 1 load
<?php if (!$logged) { ?>
  // Not logged yet
  $(document).ready(function() {
    $.ajax({
      url: 'index.php?route=checkout/customer',
      dataType: 'html',
      success: function(html) {
        $('#collapse-step-1 .panel-body').html(html);
        $('#collapse-step-1').parent().find('.panel-heading .panel-title').html('<a href="#collapse-step-1" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step_1; ?> <i class="fa fa-caret-down"></i></a>');
        $('a[href=\'#collapse-step-1\']').trigger('click');
      },
      error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  });
<?php } else { ?>
  // Logged in
  load_step_2( $('#button-guest') );
<?php } ?>

// Checkout as Login
$(document).delegate('#button-login', 'click', function() {
  $.ajax({
    url: 'index.php?route=checkout/customer/login_save',
    type: 'post',
    data: $('#returning_customer input[type=\'text\'], #returning_customer input[type=\'password\']'),
    dataType: 'json',
    beforeSend: function() {
      $('#button-login').button('loading');
    },
    success: function(json) {
      $('.alert, .text-danger').remove();

      if (json['redirect']) {
        location = json['redirect'];
      } 
      else if (json['error']) 
      {
        $('#button-login').button('reset');

        if (json['error']['warning']) {
          $('#collapse-step-1 .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        }

        for (i in json['error']) {
          var element = $('#input-payment-' + i.replace('_', '-'));

          if ($(element).parent().hasClass('input-group')) {
            $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
          } else {
            $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
          }
        }

        // Highlight any found errors
        $('.text-danger').parent().addClass('has-error');
      } 
      else 
      {
        load_step_2( $('#button-login') );
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

// Checkout as Guest
$(document).delegate('#button-guest', 'click', function() {
  $.ajax({
    url: 'index.php?route=checkout/customer/guest_save',
    type: 'post',
    data: $('#collapse-step-1 input[type=\'text\'], #collapse-step-1 input[type=\'password\'], #collapse-step-1 input[type=\'date\'], #collapse-step-1 input[type=\'datetime-local\'], #collapse-step-1 input[type=\'time\'], #collapse-step-1 input[type=\'checkbox\']:checked, #collapse-step-1 input[type=\'radio\']:checked, #collapse-step-1 input[type=\'hidden\'], #collapse-step-1 textarea, #collapse-step-1 select'),
    dataType: 'json',
    beforeSend: function() {
      $('#button-guest').button('loading');
    },
    success: function(json) {
      $('.alert, .text-danger').remove();

      if (json['redirect']) {
        location = json['redirect'];
      } 
      else if (json['error']) 
      {
        $('#button-guest').button('reset');

        if (json['error']['warning']) {
          $('#collapse-step-1 .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        }

        for (i in json['error']) {
          var element = $('#input-payment-' + i.replace('_', '-'));

          if ($(element).parent().hasClass('input-group')) {
            $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
          } else {
            $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
          }
        }

        // Highlight any found errors
        $('.text-danger').parent().addClass('has-error');
      } 
      else 
      {
       load_step_2( $('#button-guest') );
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});



/**
 * Submit order
 *
 * 
 */
$(document).delegate('#button-submit', 'click', function() {
  $.ajax({
    url: 'index.php?route=checkout/checkout_simple/place_order',
    type: 'post',
    data: $('#collapse-step-2 input[type=\'text\'], #collapse-step-2 input[type=\'checkbox\']:checked, #collapse-step-2 input[type=\'radio\']:checked, #collapse-step-2 input[type=\'hidden\'], #collapse-step-2 textarea, #collapse-step-2 select'),
    dataType: 'json',
    beforeSend: function() {
      $('#button-submit').button('loading');
    },
    success: function(json) {
      $('.alert, .text-danger').remove();

      if (json['redirect']) {
        location = json['redirect'];
      } 
      else if (json['error']) 
      {
        $('#button-submit').button('reset');

        if (json['error']['shipping_warning']) {
          $('#collapse-step-2 .panel-body .shipping-method').prepend('<div class="alert alert-warning">' + json['error']['shipping_warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        }
        if (json['error']['payment_warning']) {
          $('#collapse-step-2 .panel-body .payment-method').prepend('<div class="alert alert-warning">' + json['error']['payment_warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        }

        // Reload order confirm if shipping fee change
        $.ajax({
          url: 'index.php?route=checkout/confirm_simple',
          dataType: 'html',
          success: function(html) {
            $('#collapse-step-2 .panel-body .order-confirm').html(html);
          },
          error: function(xhr, ajaxOptions, thrownError) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
      }
      else
      {
        $('#button-confirm').click();
      } 
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });

});


/**
 * Load the step 2 action
 * 
 */
function load_step_2( ele ){
  $.ajax({
    url: 'index.php?route=checkout/confirm_simple',
    dataType: 'html',
    success: function(html) {
      $('#collapse-step-2 .panel-body .order-confirm').html(html);
      $.ajax({
        url: 'index.php?route=checkout/method_simple',
        dataType: 'html',
        complete: function() {
          ele.button('reset');
        },
        success: function(output) {
          var html = $.parseJSON( output );
          $('#collapse-step-2 .panel-body .payment-method').html(html.payment);
          $('#collapse-step-2 .panel-body .shipping-method').html(html.shipping);
          $('#collapse-step-2 .panel-body .payment-method').parent().parent().parent().parent().find('.panel-heading .panel-title').html('<a href="#collapse-step-2" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_step_2; ?> <i class="fa fa-caret-down"></i></a>');
          $('a[href=\'#collapse-step-2\']').trigger('click');
          
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    },
    error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });

}
</script>
<?php echo $footer; ?>