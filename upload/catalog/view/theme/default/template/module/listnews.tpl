<div class="list-group">
  <h4 href="javascript:;" class="list-group-item active">
    <?=$module_title?>
  </h4>
  <?php
      build_listnews(0,$listnews,$listnews_id,'');
      function build_listnews($id,$listnews,$listnews_id,$pre){
        foreach ($listnews as $n) { 
          if($n['parent_id']==$id){
            echo '<a href="'.$n['href'].'" class="list-group-item '.($n['listnews_id'] == $listnews_id?'active':'').'">'.$pre.$n['name'].'</a>';
            build_listnews($n['listnews_id'],$listnews,$listnews_id,$pre.'— ');
          }
        }
      }
    ?>
</div>
