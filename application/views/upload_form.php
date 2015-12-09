<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
  </head>
  <body>
    <h1>Upload multiple files</h1>
    <?php echo form_open_multipart( 'admin/users/upload_image'); ?>
                    <div class="form-group">
                        <label for="exampleInputFile">Upload</label>
                       
                        <?php echo form_input(array( 'name'=> 'img', 'type' => 'file', 'onchange'=>'readURL(this)' )); ?>
                    </div>
                    <div class="form-group text-center">
                        <?php echo form_submit( 'submit', 'Save', 'class = "btn btn-primary"'); ?>
                    </div>
                    <?php echo form_close(); ?>
  </body>
</html>