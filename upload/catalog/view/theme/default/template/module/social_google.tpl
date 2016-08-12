<?php
  if(! empty($page_url) )
  {
    ?>
    <!-- Đặt thẻ này vào nơi bạn muốn tiện ích con kết xuất. -->
    <div class="g-page" 
      <?php
        if(! empty($width) )
        {
        ?>
        data-width="<?php echo $width ?>" 
        <?php
        }
      ?>
      data-href="<?php echo $page_url ?>"
      data-rel="publisher"></div>

    <!-- Đặt thẻ này sau thẻ tiện ích con cuối cùng. -->
    <script type="text/javascript">
      window.___gcfg = {lang: 'vi'};

      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/platform.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    <?php
  }
?>
