
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
    <div id="content" class="<?php echo $class; ?> list-style"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php 
        echo $description;
        foreach ($news as $n) {
          echo "
            <div class='row'>
              <div class='col-sm-4 img-thumbnail'>
                <div><img src='image/{$n['image']}' alt='{$n['title']}' class='img-responsive' /></div>
              </div>
              <div class='col-sm-8'>
                <p class='title'><a href='{$n['href']}'><strong>{$n['title']}</strong></a></p>
                <p class='info'><i class='fa fa-calendar'></i> $text_published_at ". date('H:i', strtotime($n['posted_date'])) ."  $text_on 
                " . date('d/m/Y', strtotime($n['posted_date'])) . "
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class='fa fa-eye'></i>  $text_views   {$n['hits']}
                </p>
                ".strip_tags(html_entity_decode( $n['brief']))."
              </div>
            </div>
            <br/>
          ";
        }
      ?>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"></div>
      </div>
    
      <?php echo $content_bottom; ?>
      </div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>