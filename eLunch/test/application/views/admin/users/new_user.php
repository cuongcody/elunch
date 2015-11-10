<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-offset-2 col-md-8'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors(). '</div>'; ?>
                    <?php echo form_open_multipart( 'admin/users/add'); ?>
                    <div class="form-group">
                        <label for="exampleInputFile"><?php echo $new_user_lang[ 'avatar'] ?></label>
                        <div>
                            <img id='img' class="img-thumbnail" height="200" width="200" src="<?php echo (!isset($upload)) ? base_url('assets/images/users/default-avatar.png') : base_url('assets/images/users/'.$upload['file_name']); ?>" alt="">
                        </div>
                        <?php echo form_input(array( 'name'=> 'img', 'type' => 'file', 'onchange'=>'readURL(this)' )); ?>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <?php $data=array(
                            'name'=> 'first_name',
                            'class' => 'form-control',
                            'placeholder' => $new_user_lang['first_name']);
                            echo form_input($data, set_value('first_name', '')); ?>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <?php $data=array(
                            'name'=> 'last_name',
                            'class' => 'form-control',
                            'placeholder' => $new_user_lang['last_name']);
                            echo form_input($data, set_value('last_name', '')); ?>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <?php $data=array(
                            'name'=> 'email',
                            'class' => 'form-control',
                            'placeholder' => $new_user_lang['email']);
                            echo form_input($data, set_value('email', '')); ?>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                        <?php $data=array(
                            'name'=> 'password',
                            'class' => 'form-control',
                            'placeholder' => $new_user_lang['password']);
                            echo form_password($data); ?>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                        <?php $data=array(
                            'name'=> 'confirm_password',
                            'class' => 'form-control',
                            'placeholder' => $new_user_lang['confirm_password']);
                            echo form_password($data); ?>
                    </div>
                    <div class="checkbox">
                        <label>
                        <?php
                            echo form_checkbox( 'want_vegan_meal', 'accept', TRUE);
                            echo $new_user_lang[ 'want_vegan_meal']; ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="comment"><?php echo $new_user_lang[ 'what_taste']; ?></label>
                        <?php $data=array(
                            'name'=> 'what_taste',
                            'rows' => '5',
                            'cols' => '10',
                            'class' => 'form-control' );
                            echo form_textarea($data, set_value('what_taste','')); ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo $new_user_lang[ 'floor'];?>: </label>
                        <?php $options=array();
                        foreach ($floors as $temp)
                        { $options[$temp->id] = $temp->name; }
                        $select_floor = $this->input->post('floor');
                        echo form_dropdown('floor', $options, set_value('floor',( !empty($select_floor) ) ? "$select_floor" : $floors[0]->id),'class= "form-control"'); ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo $new_user_lang[ 'role'];?>: </label>
                        <?php $options=array(
                        '0'=> $new_user_lang['user'],
                        '1' => $new_user_lang['admin']);
                        $select_role = $this->input->post('role');
                        echo form_dropdown('role', $options, set_value('role',( !empty($select_role) ) ? "$select_role" : 0),'class= "form-control"'); ?>
                    </div>
                    <div class="form-group text-center">
                        <?php echo form_submit( 'submit', $new_user_lang[ 'save'], 'class = "btn btn-primary"'); ?>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->