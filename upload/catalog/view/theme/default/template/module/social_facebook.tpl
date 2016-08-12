<?php
  if(! empty($page_url) )
  {
    ?>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=<?php echo (! empty($social_facebook_appId) ? $social_facebook_appId : '' ) ?>";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div class="fb-page" 
      data-href="<?php echo $page_url?>" 
      <?php
        if( !empty($width) && !empty($height) )
        {
          ?>
          data-width = "<?php echo $width?>"
          data-height = "<?php echo $height?>"
          data-adapt-container-width = "false" 
          <?php
        }
        else
        {
          ?>
          data-adapt-container-width = "false"
          <?php
        }
      ?>
      data-small-header="false" 
      data-hide-cover="false" 
      data-show-facepile="true">
        <blockquote cite="<?php echo $page_url?>" class="fb-xfbml-parse-ignore">
          <a href="<?php echo $page_url?>"></a>
        </blockquote>
    </div>
    <?php
  }
?>
