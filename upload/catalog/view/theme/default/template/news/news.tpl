
<meta property="og:title" content="<?php echo $heading_title; ?>" />
<meta property="og:description" content="<?php echo $metaDescription; ?>" />
<?php
  if( $image )
  {
    ?>
    <link rel="image_src" href="<?php echo $image ?>" />
    <meta property="og:image" content="<?php echo $image ?>" />
    <?php
  }
?>
<?php echo $header; ?>
<script>
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
    jQuery.getScript('http://connect.facebook.net/en_US/all.js#xfbml=1', function() {   FB.init({status: true, cookie: true, xfbml: true});   }); 
    
  })();
</script>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
      <a href="<?php echo $breadcrumb['href']; ?>" itemprop="url">
        <span itemprop="title"><?php echo $breadcrumb['text']; ?></span>
      </a>
    </div>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <div class="row">
        <div class="col-lg-6">
        <p><i class="fa fa-calendar"></i> <?php echo $text_published_at; ?> <strong class="text-primary"><?php echo date('H:i', strtotime($posted_date)); ?></strong> <?php echo $text_on; ?> <strong class="text-primary"><?php echo date('d/m/Y', strtotime($posted_date)); ?></strong></p>
        </div>
        <div class="col-lg-6">
        <p><i class="fa fa-eye"></i> <?php echo $text_views; ?> <strong class="text-primary"><?php echo $hits; ?></strong></p>
        </div>

        <div class="col-lg-12">
          <p>
          <div class="fb-like" data-href="<?php echo $url; ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="vertical-align:top;"></div>
          <div class="g-plus" data-action="share" data-annotation="bubble"></div>
          </p>
        </div>
      </div>
      <div class="row">
      <div class="col-lg-12">
      <?php echo html_entity_decode($brief); ?>
      </div>
      <div class="col-lg-12">
      <?php echo html_entity_decode($description); ?>
      </div>
     <div class="col-lg-12">
        <p>
        <div class="fb-like" data-href="<?php echo $url; ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="vertical-align:top;"></div>
        <div class="g-plus" data-action="share" data-annotation="bubble"></div>
        </p>
      </div>
      <div class="col-lg-12">

      <div class="fb-comments" data-href="<?php echo $url; ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
      </div>
      <?php echo $content_bottom; ?>
      </div>
    <?php echo $column_right; ?></div>
</div>
</div>
<?php echo $footer; ?>