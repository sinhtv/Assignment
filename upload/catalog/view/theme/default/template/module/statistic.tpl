<div class="list-group">
  <h4 href="javascript:;" class="list-group-item active">
    <?=$module_title?>
  </h4>
  <?php if(isset($online_view)){ ?>
    <a href="javascript:;" class="list-group-item"><img src="image/statistic-online.png" /> <?php echo $entry_online; ?> <?php echo $online_view; ?></a>
  <?php } ?>
  <?php if(isset($today_view)){ ?>
    <a href="javascript:;" class="list-group-item"><img src="image/statistic-today.png" /> <?php echo $entry_today; ?> <?php echo $today_view; ?></a>
  <?php } ?>
  <?php if(isset($yesterday_view)){ ?>
    <a href="javascript:;" class="list-group-item"><img src="image/statistic-yesterday.png" /> <?php echo $entry_yesterday; ?> <?php echo $yesterday_view; ?></a>
  <?php } ?>
  <?php if(isset($lastmonth_view)){ ?>
    <a href="javascript:;" class="list-group-item"><img src="image/statistic-lastmonth.png" /> <?php echo $entry_lastmonth; ?> <?php echo $lastmonth_view; ?></a>
  <?php } ?>
  <?php if(isset($total_view)){ ?>
    <a href="javascript:;" class="list-group-item"><img src="image/statistic-total.png" /> <?php echo $entry_total; ?> <?php echo $total_view; ?></a>
  <?php } ?>
</div>
