<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <?php if ($name) { ?>
                <input name="name" id="input-name" class="form-control" value="<?php echo $name ?>" />
              <?php } else { ?>
                <input name="name" id="input-name" class="form-control" value="" />
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-category_id"><?php echo $entry_category; ?></label>
            <div class="col-sm-10">
              <select name="category_id" id="input-category_id" class="form-control">
                <?php
                  echoCategories( $categories, 0, $category_id );

                  function echoCategories( $categories, $parent, $category_id )
                  {
                    foreach( $categories as $c )
                    {
                      if( $c['parent_id'] == $parent )
                      {
                        echo '<option value="'.$c['category_id'].'" ' . ( $category_id == $c['category_id'] ? 'selected' : '' ) . '>'.$c['name'].'</option>';
                        echoCategories( $categories, $c['category_id'], $category_id );
                      }
                    }
                  }

                ?>
              </select>
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

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
            <div class="col-sm-10">
                <?php if ($category_limit) { ?>
                  <input name="category_limit" id="input-limit" class="form-control" value="<?php echo $category_limit ?>" />
                <?php } else { ?>
                  <input name="category_limit" id="input-limit" class="form-control" value="8" />
                <?php } ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>