<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-support" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-support" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input name="name" id="input-name" class="form-control" type="text" value="<?php echo $name ?>" placeholder="<?php echo $entry_name; ?>" />
            </div>
          </div>
          <div id="support-item">
          <?php
            $max = 0;
            if( $support )
            {
              foreach( $support as $k => $sp )
              {
                ?>
                <div id="support-row<?php echo $k ?>" class="form-group">
                  <div class="col-sm-2">
                  </div>
                  <div class="col-sm-2">
                    <select name="support[<?php echo $k ?>][type]" class="form-control">
                      <option value="0"><?php echo $entry_none; ?></option>
                      <option value="1" <?php echo ( $sp['type'] == 1 ? 'selected' : '' ) ?>><?php echo $entry_call; ?></option>
                      <option value="2" <?php echo ( $sp['type'] == 2 ? 'selected' : '' ) ?>><?php echo $entry_email; ?></option>
                      <option value="3" <?php echo ( $sp['type'] == 3 ? 'selected' : '' ) ?>><?php echo $entry_yahoo; ?></option>
                      <option value="4" <?php echo ( $sp['type'] == 4 ? 'selected' : '' ) ?>><?php echo $entry_skype; ?></option>
                      <option value="5" <?php echo ( $sp['type'] == 5 ? 'selected' : '' ) ?>><?php echo $entry_facebook; ?></option>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="support[<?php echo $k ?>][name]" value="<?php echo $sp['name']; ?>" placeholder="<?php echo $entry_value; ?>" class="form-control" />
                  </div>
                  <div class="col-sm-2">
                    <button type="button" onclick="$('#support-row<?php echo $k ?>').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Hủy"><i class="fa fa-minus-circle"></i></button>
                  </div>
                </div>

                <?php

                if( $max < $k )
                  $max = $k;
              }
            }
          ?>
          </div>

          
          <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-2"></div>
            <div class="col-sm-6"></div>
            <div class="col-sm-2">
              <button id="add-support" type="button" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Thêm support">
                <i class="fa fa-plus-circle"></i>
              </button>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  row = <?php echo $max ?>;
  $('document').ready(function(){
    $('#add-support').on('click', function(){
      var result = '';
      row++;

      result += '<div id="support-row'+row+'" class="form-group">';
      result += ' <div class="col-sm-2">';
      result += ' </div>';
      result += ' <div class="col-sm-2">';
      result += '  <select name="support['+row+'][type]" class="form-control">';
      result += '    <option value="0"><?php echo $entry_none; ?></option>';
      result += '    <option value="1"><?php echo $entry_call; ?></option>';
      result += '    <option value="2"><?php echo $entry_email; ?></option>';
      result += '    <option value="3"><?php echo $entry_yahoo; ?></option>';
      result += '    <option value="4"><?php echo $entry_skype; ?></option>';
      result += '    <option value="5"><?php echo $entry_facebook; ?></option>';
      result += '  </select>';
      result += ' </div>';
      result += ' <div class="col-sm-6">';
      result += '  <input type="text" name="support['+row+'][name]" value="" placeholder="<?php echo $entry_value; ?>" class="form-control" />';
      result += ' </div>';
      result += ' <div class="col-sm-2">';
      result += '   <button type="button" onclick="$(\'#support-row'+row+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Hủy"><i class="fa fa-minus-circle"></i></button>';
      result += ' </div>';
      result += '</div>';
      
      $('#support-item').append(result);
    });
  });
</script>
<?php echo $footer; ?>