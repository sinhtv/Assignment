<div class="list-group list-style">
  <h4 href="javascript:;" class="list-group-item active">
    <?php echo $module_title ?>
  </h4>
  <?php foreach ($news as $n) { ?>
    <?php if ($n['news_id'] == $news_id) { ?>
      <a href="<?php echo $n['href']; ?>" class="list-group-item active">
      <span class="image"><img src="<?php echo $n['thumb']; ?>" width="80px" alt="<?php echo $n['name']; ?>" /></span>
      <?php echo $n['name']; ?>
      <p><i class='fa fa-calendar'></i> <?php echo date('d/m/Y', strtotime($n['posted_date'])) ?></p>
      </a>
    <?php } else { ?>
      <a href="<?php echo $n['href']; ?>" class="list-group-item">
      <span class="image"><img src="<?php echo $n['thumb']; ?>" width="80px" alt="<?php echo $n['name']; ?>" /></span>
      <?php echo $n['name']; ?>
      <p><i class='fa fa-calendar'></i> <?php echo date('d/m/Y', strtotime($n['posted_date'])) ?></p>
      </a>
    <?php } ?>
  <?php } ?>
</div>
