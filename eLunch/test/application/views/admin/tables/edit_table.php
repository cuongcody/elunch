<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-7 col-sm-7 col-xs-12'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2><?php echo $edit_table_lang['title'] ?></h2>
                    <?php if (NULL !=validation_errors()) echo "<div class='alert alert-warning'>".validation_errors(). '</div>'; ?>
                    <?php echo form_open('admin/tables/edit/'.$table->id); ?>
                    <div class="form-group">
                        <label><?php echo $edit_table_lang['table'] ?></label>
                        <?php
                            $data = array(
                                'name' => 'table',
                                'class' => 'form-control',
                                'placeholder' => $edit_table_lang['table']);
                            echo form_input($data, set_value('table', $table->name));
                        ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo $edit_table_lang['description'] ?></label>
                        <?php
                            $data = array(
                              'name' => 'description',
                              'rows' => '5',
                              'cols' => '10',
                              'class' => 'form-control'
                            );
                            echo form_textarea($data, set_value('description', $table->description));
                        ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo $edit_table_lang['seats'] ?></label>
                        <?php
                            $data = array(
                                'type' => 'number',
                                'name' => 'seats',
                                'class' => 'form-control',
                                'id' => 'number',
                                'placeholder' => $edit_table_lang['seats']);
                            echo form_input($data, set_value('seats', $table->seats));
                        ?>
                    </div>
                    <div class="checkbox">
                        <label>
                        <?php
                            echo ($table->for_vegans == 1) ? form_checkbox('for_vegans', 'accept', TRUE) : form_checkbox('for_vegans', TRUE);
                            echo $edit_table_lang['for_vegans'];
                        ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <label><?php echo $edit_table_lang[ 'shift'];?>: </label>
                        <?php
                            $options=array();
                            foreach ($shifts as $temp)
                            { $options[$temp->id] = $temp->name; }
                            echo form_dropdown('shift', $options, set_value('shift',$table->shift_id), 'class = "form-control"');
                        ?>
                    </div>
                    <div class="form-group text-center">
                        <?php echo form_submit( 'submit', $edit_table_lang[ 'edit'], 'class = "btn btn-primary"'); ?>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class= 'col-md-5 col-sm-5 col-xs-12'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2><?php echo $edit_table_lang['list_of_users'] ?></h2>
                     <table class="table table-striped responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr class="heading">
                                <th class="column-title"><?php echo $edit_table_lang['image'] ?></th>
                                <th class="column-title"><?php echo $edit_table_lang['name'] ?></th>
                                <th class="column-title"><?php echo $edit_table_lang['floor'] ?></th>
                                <th class="column-title"><?php echo $edit_table_lang['delete'] ?></th>
                            </tr>
                        </thead>
                        <tbody class="users_item">
                        <?php
                            foreach ($users as $user)
                            {
                                echo "<tr id='user_".$user->id."'>";
                                echo "<td class='column-title'><img class='img-thumbnail' width='50' height='50' src='".$user->avatar_content_file."' alt=''></td>";
                                echo "<td class='column-title'>".$user->first_name."</td>";
                                echo "<td class='column-title'>".$user->floor."</td>";
                                echo "<td class='column-title'><a href='#delete_user_in_table_modal' class='label label-warning' data-toggle='modal' data-target='#delete_user_in_table_modal' data-user-id={$user->id} onclick='false;'>".$edit_table_lang["delete"]."</a></td>";
                                echo "</tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<!-- Modal -->
<div class="modal fade" id="delete_user_in_table_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $edit_table_lang['delete'] ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $edit_table_lang['are_you_sure'] ?>
                <input type="hidden" name='user_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $edit_table_lang['cancel'] ?></button>
                <button type="button" id='delete_user_in_table' data-dismiss="modal" data-path="<?php echo base_url().'admin/tables/delete_user_in_table/'.$table->id.'/'; ?>" class="btn btn-primary"><?php echo $edit_table_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>