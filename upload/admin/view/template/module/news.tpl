<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $layout; ?>" data-toggle="tooltip" title="<?php echo $button_layout; ?>" class="btn btn-info"><i class="fa fa-desktop"></i></a>
        <a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-option').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-option">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td style="width: 60px;" class="text-center"><?php echo $text_image; ?></td>
                  <td class="text-left"><?php echo $text_title; ?></td>
                  <td style="width: 140px;" class="text-right"><?php echo $text_category; ?></td>
                  <td style="width: 140px;" class="text-right"><?php echo $text_date; ?></td>
                  <td style="width: 140px;" class="text-right"><?php echo $text_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($news) { ?>
                <?php foreach ($news as $n) { ?>
                  <tr>
                    <td width="1" style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $n['id']; ?>" /></td>
                    <td align="center"><img src="<?php echo $n['thumb']; ?>" width=48px height=48px /></td>
                    <td align="left"><?php echo $n['title']; ?></td>
                    <td align="center"><?php echo $n['cat']; ?></td>
                    <td align="center"><?php echo $n['posted_date']; ?></td>
                    <td class="right">[ <a href="<?php echo $n['edit']; ?>"><?php echo $text_edit; ?></a> ]</td>
                  </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>