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
          <input type="hidden" name="social_facebook[name]" value="<?php echo $social_facebook['name']; ?>" class="form-control" />
          <input type="hidden" name="social_google[name]" value="<?php echo $social_google['name']; ?>" class="form-control" />
          <input type="hidden" name="social_facebook[status]" value="<?php echo $social_facebook['status']; ?>" class="form-control" />
          <input type="hidden" name="social_google[status]" value="<?php echo $social_google['status']; ?>" class="form-control" />
          <div class="form-group">
            <div class="clearfix">
              <label class="col-sm-2 control-label" ><?php echo $text_facebook_page; ?></label>
              <div class="col-sm-10">
                <input type="text" name="social_facebook[page_url]" value="<?php echo $social_facebook['page_url']; ?>" placeholder="<?php echo $text_facebook_page; ?>" id="input-social_facebook_page" class="form-control" />
              </div>
            </div>
            <div class="clearfix" style="margin-top:5px;">
              <label class="col-sm-2 control-label" ></label>
              <div class="col-sm-10">
                <input type="text" name="social_facebook[appId]" value="<?php echo $social_facebook['appId']; ?>" placeholder="<?php echo $text_facebook_appId; ?>" id="input-social_facebook_appId" class="form-control" />
              </div>
            </div>
            <div class="clearfix" style="margin-top:5px;">
               <label class="col-sm-2 control-label" ></label>
               <div class="col-sm-10">
                <div class="col-sm-5" style="padding-left: 0;">
                  <input type="text" name="social_facebook[width]" value="<?php echo $social_facebook['width']; ?>" placeholder="<?php echo $text_facebook_width; ?>" id="input-social_facebook_width" class="form-control" />
                </div>
                <div class="col-sm-5">
                  <input type="text" name="social_facebook[height]" value="<?php echo $social_facebook['height']; ?>" placeholder="<?php echo $text_facebook_height; ?>" id="input-social_facebook_height" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="clearfix">
              <label class="col-sm-2 control-label" for="input-hits"><?php echo $text_google_page; ?></label>
              <div class="col-sm-10">
                <input type="text" name="social_google[page_url]" value="<?php echo $social_google['page_url']; ?>" placeholder="<?php echo $text_google_page; ?>" id="input-social_google_page" class="form-control" />
              </div>
            </div>
            <div class="clearfix" style="margin-top:5px;">
             <label class="col-sm-2 control-label" ></label>
              <div class="col-sm-10">
                <div class="col-sm-5" style="padding-left: 0;">
                  <input type="text" name="social_google[width]" value="<?php echo $social_google['width']; ?>" placeholder="<?php echo $text_facebook_width; ?>" id="input-social_google_width" class="form-control" />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>