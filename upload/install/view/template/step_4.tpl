<?php echo $header; ?>
<div class="container">
  <header>
    <div class="row">
      <div class="col-sm-6">
        <h1 class="pull-left">4<small>/4</small></h1>
        <h3><?php echo $heading_step_4; ?><br>
          <small><?php echo $heading_step_4_small; ?></small></h3>
      </div>
      <div class="col-sm-6">
        <div id="logo" class="pull-right hidden-xs"> <img src="view/image/logo.png" alt="OpenCart" title="OpenCart" /> </div>
      </div>
    </div>
  </header>
  <?php if ($success) { ?>
  <div class="alert alert-success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="alert alert-danger"><?php echo $text_forget; ?></div>
  <div class="visit">
    <div class="row">
      <div class="col-sm-5 col-sm-offset-1 text-center"> <img src="view/image/icon-store.png"> <a class="btn btn-secondary" href="../"><?php echo $text_shop; ?></a> </div>
      <div class="col-sm-5 text-center"> <img src="view/image/icon-admin.png"> <a class="btn btn-secondary" href="../admin/"><?php echo $text_login; ?></a> </div>
    </div>
  </div>
  <div class="language" id="module-language" style="display:none;"></div>
  <div class="mailing-list">
    <div class="row">
      <div class="col-sm-12"> <img src="view/image/icon-mail.png">
        <h3><?php echo $text_mail_list; ?><br>
          <small><?php echo $text_mail_list_small; ?></small></h3>
        <a class="btn btn-secondary" href="http://newsletter.opencart.com/h/r/B660EBBE4980C85C" target="_BLANK"><?php echo $button_join; ?></a> </div>
    </div>
  </div>
  <div class="support text-center">
    <div class="row">
      <div class="col-sm-4"> <a href="https://www.facebook.com/pages/OpenCart/477182382328323" class="icon transition"> <i class="fa fa-facebook fa-4x"></i> </a>
        <h3><?php echo $text_facebook; ?></h3>
        <p><?php echo $text_facebook_info; ?></p>
        <a href="https://www.facebook.com/pages/OpenCart/477182382328323"><?php echo $text_facebook_link; ?></a> </div>
      <div class="col-sm-4"> <a href="http://forum.opencart.com/?utm_source=opencart_install&utm_medium=forum_link&utm_campaign=opencart_install" class="icon transition"> <i class="fa fa-comments fa-4x"></i> </a>
        <h3><?php echo $text_forum; ?></h3>
        <p><?php echo $text_forum_info; ?></p>
        <a href="http://forum.opencart.com/?utm_source=opencart_install&utm_medium=forum_link&utm_campaign=opencart_install"><?php echo $text_forum_link; ?></a> </div>
      <div class="col-sm-4"> <a href="http://www.opencart.com/index.php?route=partner/partner&utm_source=opencart_install&utm_medium=partner_link&utm_campaign=opencart_install" class="icon transition"> <i class="fa fa-user fa-4x"></i> </a>
        <h3><?php echo $text_commercial; ?></h3>
        <p><?php echo $text_commercial_info; ?></p>
        <a href="http://www.opencart.com/index.php?route=partner/partner&utm_source=opencart_install&utm_medium=partner_link&utm_campaign=opencart_install" target="_BLANK"><?php echo $text_commercial_link; ?></a> </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 