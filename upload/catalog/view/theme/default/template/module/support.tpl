<?php
  if( count($support) > 0 )
  {
?>
  <div class="list-group">
    <h4 href="javascript:;" class="list-group-item active">
      <?php echo $module_title ?>
    </h4>
    <?php
      foreach( $support as $sp )
        echo $sp;
    ?>
  </div>
<?php
  }
?>