<footer>
  <div class="botmenu">
  <div class="container">
    <div class="row">
      <?php if ($informations) { ?>
      <div class="col-sm-3">
        <h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      <div class="col-sm-3">
        <h5><?php echo $text_service; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_extra; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_account; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>
    </div>
  </div>
  </div>
  <div class="container">
    <ul class="socials">
      <?php
        if(! empty($config_youtube_url) )
        {
          ?>
          <li><a href="<?php echo $config_youtube_url ?>" title="youtube"><i class="fa fa-youtube"></i></a></li>
          <?php
        }
      ?>
      <?php
        if(! empty($config_facebook_url) )
        {
          ?>
          <li><a href="<?php echo $config_facebook_url ?>" title="facebook"><i class="fa fa-facebook"></i></a></li>
          <?php
        }
      ?>
      <?php
        if(! empty($config_googleplus_url) )
        {
          ?>
          <li><a href="<?php echo $config_googleplus_url ?>" title="google plus"><i class="fa fa-google-plus"></i></a></li>
          <?php
        }
      ?>
      <?php
        if(! empty($config_twitter_url) )
        {
          ?>
          <li><a href="<?php echo $config_twitter_url ?>" title="twitter"><i class="fa fa-twitter"></i></a></li>
          <?php
        }
      ?>
    </ul>
    <p><?php echo $powered; ?></p>
  </div>
</footer>
</body></html>