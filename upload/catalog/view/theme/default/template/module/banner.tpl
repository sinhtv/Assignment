<div id="banner<?php echo $module; ?>">
  <?php foreach ($banners as $banner) { ?>
  <div class="item">
    <center>
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
    </center>
  </div>
  <?php } ?>
</div>
