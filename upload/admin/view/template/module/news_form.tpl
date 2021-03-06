<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-option" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($error) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-option" class="form-horizontal">
          <ul class="nav nav-tabs" id="language">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <?php foreach ($languages as $language) { ?>
            <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?php echo $text_title; ?></label>
                <div class="col-sm-10">
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="news_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $text_title; ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_title[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-brief<?php echo $language['language_id']; ?>"><?php echo $text_brief; ?></label>
                <div class="col-sm-10">
                  <textarea name="news_description[<?php echo $language['language_id']; ?>][brief]" placeholder="<?php echo $text_brief; ?>" id="input-brief<?php echo $language['language_id']; ?>"><?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['brief'] : ''; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $text_description; ?></label>
                <div class="col-sm-10">
                  <textarea name="news_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $text_description; ?>" id="input-description<?php echo $language['language_id']; ?>"><?php echo isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['description'] : ''; ?></textarea>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>

          
          <div class="form-group"></div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image"><?php echo $text_image; ?></label>
            <div class="col-sm-10">
              <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="image" /></a>
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cat-id"><?php echo $text_category; ?></label>
            <div class="col-sm-10">
              <select name="cat_id" id="input-cat-id" class="form-control">
                <option value="0"><?php echo $text_none; ?></option>
                 <?php 
                  loopParent($listnews_parent,0,$cat_id,'');
                  function loopParent($listnews_parent,$id,$cat_id,$pre){
                     foreach($listnews_parent as $n):
                      if($n['parent_id']==$id):
                        echo '<option value="'.$n['id'].'" '.($cat_id==$n['id']?'selected':'').'>'.$pre.$n['title'].'</option>';
                        loopParent($listnews_parent,$n['id'],$cat_id,$pre.'— ');
                      endif;
                    endforeach;
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-posted-date"><?php echo $text_date; ?></label>
            <div class="col-sm-3">
              <div class="input-group date">
                <input type="text" name="posted_date" value="<?php echo $posted_date; ?>" placeholder="<?php echo $text_date; ?>" data-date-format="DD/MM/YYYY" id="input-posted-date" class="form-control" />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-hits"><?php echo $text_hits; ?></label>
            <div class="col-sm-10">
              <input type="text" name="hits" value="<?php echo $hits; ?>" placeholder="<?php echo $text_hits; ?>" id="input-hits" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $text_active; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($active) { ?>
                <input type="radio" name="active" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="active" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if (!$active) { ?>
                <input type="radio" name="active" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="active" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
              <?php if ($error_keyword) { ?>
              <div class="text-danger"><?php echo $error_keyword; ?></div>
              <?php } ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $('.date').datetimepicker({
    pickTime: false
  });

  <?php foreach ($languages as $language) { ?>
  CKEDITOR.config.jqueryOverrideVal = true;
  $('#input-description<?php echo $language['language_id']; ?>,#input-brief<?php echo $language['language_id']; ?>').ckeditor({
    height: 300
  });
  <?php } ?>

  $('#language a:first').tab('show');
</script>
</div>
<?php echo $footer; ?>