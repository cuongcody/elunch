<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-2 col-md-8'>
            <div class="panel panel-default">
                <div class="panel-body">
                <h2><?php echo $edit_user_lang['title'] ?></h2>
                    <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors(). '</div>'; ?>
                    <?php echo form_open_multipart( 'admin/users/edit/'.$user->id); ?>
                        <div class="form-group">
                            <label for="exampleInputFile"><?php echo $edit_user_lang[ 'avatar'] ?></label>
                            <div>
                                <img id='img' class="img-thumbnail" height="200" width="200" src="<?php echo (!isset($upload)) ? base_url('assets/images/users/default-avatar.png') : base_url('assets/images/users/'.$upload['file_name']); ?>" alt="">
                            </div>
                            <?php echo form_input(array( 'name'=> 'img', 'type' => 'file', 'onchange'=>'readURL(this)' )); ?>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <?php
                                $data=array(
                                    'name'=> 'first_name',
                                    'class' => 'form-control',
                                    'placeholder' => $edit_user_lang['first_name']);
                                echo form_input($data, set_value('first_name', $user->first_name)); ?>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <?php $data=array(
                                    'name'=> 'last_name',
                                    'class' => 'form-control',
                                    'placeholder' => $edit_user_lang['last_name']);
                                echo form_input($data, set_value('last_name', $user->last_name)); ?>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <?php
                                $data=array(
                                    'name'=> 'email',
                                    'class' => 'form-control',
                                    'placeholder' => $edit_user_lang['email']);
                                echo form_input($data, set_value('email', $user->email), 'disabled'); ?>
                        </div>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#change_password_modal" data-whatever="@mdo"><?php echo $edit_user_lang['change_password'] ?></button>
                        <div class="checkbox">
                            <label>
                            <?php
                                echo ($user->want_vegan_meal == 1) ? form_checkbox( 'want_vegan_meal', 'accept', TRUE) : form_checkbox( 'want_vegan_meal', TRUE);
                                echo $edit_user_lang[ 'want_vegan_meal']; ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="comment"><?php echo $edit_user_lang[ 'what_taste']; ?></label>
                            <?php
                                $data=array(
                                'name'=> 'what_taste',
                                'rows' => '5',
                                'cols' => '10',
                                'class' => 'form-control');
                                echo form_textarea($data, set_value('what_taste', $user->what_taste)); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo $edit_user_lang[ 'floor'];?>: </label>
                            <?php $options=array();
                            foreach ($floors as $temp)
                            { $options[$temp->id] = $temp->name; }
                            echo form_dropdown('floor', $options, set_value('floor', $user->floor_id),'class= "form-control"'); ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo $edit_user_lang[ 'role'];?>: </label>
                            <?php
                                $options=array(
                                    '0'=> $edit_user_lang['user'],
                                    '1' => $edit_user_lang['admin']);
                                $role = ($user->admin == 0) ? 0 : 1;
                            echo form_dropdown('role', $options, set_value('role', $role), 'class= "form-control"'); ?>
                        </div>
                        <div class="form-group text-center">
                            <?php echo form_submit( 'submit', $edit_user_lang[ 'edit'], 'class = "btn btn-primary"'); ?>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<!-- Modal -->
<div class="modal fade" id="change_password_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $edit_user_lang['change_password'] ?></h4>
            </div>
            <div class="modal-body change_password">
                <?php echo form_open_multipart( 'admin/users/edit/'.$user->id); ?>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <?php $data=array(
                            'name'=> 'password',
                            'class' => 'form-control',
                            'placeholder' => $edit_user_lang['password']);
                            echo form_password($data, set_value('password', '')); ?>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <?php $data=array(
                            'name'=> 'confirm_password',
                            'class' => 'form-control',
                            'placeholder' => $edit_user_lang['confirm_password']);
                            echo form_password($data, set_value('confirm_password', '')); ?>
                    </div>
                    <input type="hidden" name='user_id' value="">
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $edit_user_lang['cancel'] ?></button>
                <button type="button" id="change_password" class="btn btn-primary" data-path="<?php echo base_url().'admin/users/change_password/'.$user->id; ?>"><?php echo $edit_user_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>
