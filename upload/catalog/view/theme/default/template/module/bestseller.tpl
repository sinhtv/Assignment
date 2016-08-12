<div class="list-group list-style">
<h4 class="list-group-item active"><?php echo $heading_title; ?></h4>
<div class="row">
  <?php foreach ($products as $product) { ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <a href="<?php echo $product['href']; ?>" class="list-group-item" title="<?php echo $product['name']; ?>">
      <span class="image">
        <img src="<?php echo $product['thumb']; ?>" width="80px" alt="<?php echo $product['name']; ?>" />
      </span>
      <?php echo $product['name']; ?>
      <?php if ($product['price']) { ?>
        <p class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>
          <?php if ($product['tax']) { ?>
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
          <?php } ?>
        </p>
      <?php } ?>
    </a>
    </div>
  <?php } ?>
</div>
</div>