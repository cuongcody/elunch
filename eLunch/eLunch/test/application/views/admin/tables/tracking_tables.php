<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class= 'col-md-12'>
            <div class="choose_day">
                <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
                <?php echo form_open_multipart( 'admin/tables/tracking'); ?>
                    <div class="form-group col-md-5 col-sm-5 col-xs-6">
                        <?php
                            $options=array();
                            if (!empty($shifts))
                            {
                                foreach ($shifts as $temp)
                                { $options[$temp->id] = $temp->name; }
                                $select_shift = $this->input->post('shift');
                                echo form_dropdown('shift', $options, set_value('shift', (!empty($select_shift) ) ? "$select_shift" : $shifts[0]->id), 'class= "form-control"');
                            }
                            else
                            {
                                echo form_dropdown('shift', $options, set_value('shift', ''), 'class= "form-control"');
                            }
                        ?>
                    </div>
                    <div class="form-group col-md-5 col-sm-5 col-xs-6">
                        <?php
                            $options=array(
                                '0' => $tracking_tables_lang['normal_day'],
                                '1' => $tracking_tables_lang['vegan_day']);
                            $select_day = $this->input->post('day');
                            echo form_dropdown('day', $options, set_value('day',( !empty($select_day) ) ? "$select_day" : 0),'class= "form-control"');
                        ?>
                    </div>
                    <div class="form-group col-md-2 col-sm-2 col-xs-3">
                        <?php echo form_submit( 'submit', $tracking_tables_lang['search'], 'class = "btn btn-primary"'); ?>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="x_panel">
                <div class="x_content">
                    <div class='col-md-4'>
                        <p class="lead"><strong><?php echo $tracking_tables_lang['tracking']?></strong></p>
                         <!-- Nav tabs -->
                        <ul class="nav nav-tabs tabs-left">
                            <?php
                                if (!empty($tables))
                                {
                                    foreach ($tables as $key => $table)
                                    {
                                       echo "<li id='table-tab_".$table->id."' class='".(($key == 0) ? 'active' : '')."'>";
                                       echo "<a href='#list_of_users' data-path='".base_url('admin/tables/list_users_from_table/')."' data-table-id={$table->id} data-day={$day} data-toggle='tab' aria-expanded='false'>".$table->name." ";
                                       echo "<span class='badge badge-info'><span class='occupied_seats'>".((is_null($table->occupied_seats)) ? 0 : $table->occupied_seats)."</span> / ".$table->seats."</span>";
                                       echo "</a></li>";
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div class='col-md-8'>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="list_of_users">
                                <p class="lead"><strong><?php echo $tracking_tables_lang['list_of_users']?></strong></p>
                                <p class="lead add-user">
                                    <?php
                                    if (!empty($tables))
                                    {
                                        echo $tracking_tables_lang['add_user'];
                                        echo "<a href='#add_user_modal' class='label label-success' data-toggle='modal' data-target='#add_user_modal' data-table-id='".$tables[0]->id."' onclick='false;'><i class='fa fa-plus'></i></a></td>";
                                    }
                                    ?>
                                </p>
                                <input type="hidden" name='table_id' value="">
                                <input type="hidden" name='user_id' value="">
                                <input type="hidden" name='day' value="<?php echo $day; ?>">
                                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                    <thead>
                                      <tr class="heading">
                                         <th class="column-title"></th>
                                         <th class="column-title"><?php echo $tracking_tables_lang['avatar'] ?></th>
                                         <th class="column-title"><?php echo $tracking_tables_lang['name'] ?></th>
                                         <th class="column-title"><?php echo $tracking_tables_lang['floor'] ?></th>
                                         <th class="column-title"><?php echo $tracking_tables_lang['leave'] ?></th>
                                      </tr>
                                    </thead>
                                    <tbody class="users_item">
                                        <?php
                                            if (!empty($tables))
                                            {
                                                $this->load->model('tables_model');
                                                $users_in_tables = $this->tables_model->get_users_in_table($tables[0]->id, $day);
                                                foreach ($users_in_tables as $user)
                                                {
                                                    echo "<tr id='user_".$user->id."' class='heading'><td class='column-title'></td>";
                                                    echo "<td class='column-title'><img class='img-thumbnail' width='50' height='50' src='" . $user->avatar_content_file . "'alt=''></td>";
                                                    echo "<td class='column-title'>".$user->first_name."</td>";
                                                    echo "<td class='column-title'>".$user->floor."</td>";
                                                    echo "<td class='column-title'><a href='#leave_table_modal' class='label label-warning' data-toggle='modal' data-target='#leave_table_modal' data-table-id='" . $tables[0]->id . "' data-user-id='" . $user->id . "' onclick='false;'><i class='fa fa-times'></i></a></td></tr>";
                                                }
                                            }
                                        ?>
                                   </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="leave_table_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $tracking_tables_lang['leave'] ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $tracking_tables_lang['are_you_sure'] ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tracking_tables_lang['cancel'] ?></button>
                <button type="button" id='leave_table' data-dismiss="modal" data-path="<?php echo base_url().'admin/tables/leave_table/'; ?>" class="btn btn-primary"><?php echo $tracking_tables_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $tracking_tables_lang['add_user'] ?></h4>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart( 'admin/tables/tracking'); ?>
                    <div class="form-group col-md-5 col-sm-5 col-xs-12 input-group">
                        <label><?php echo $tracking_tables_lang['add_user'] ?></label>
                        <?php
                            $options=array();
                            if (!empty($users))
                            {
                                foreach ($users as $temp)
                                { $options[$temp->id] = $temp->first_name; }
                                $select_user = $this->input->post('user');
                                echo form_dropdown('user', $options, set_value('user',(!empty($select_user) ) ? "$select_user" : $users[0]->id), 'class= "form-control" id= "user-choose"');
                            }
                            else
                            {
                                echo form_dropdown('user', $options, set_value('user', ''), 'class= "form-control" id= "user-choose" ');
                            }
                        ?>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tracking_tables_lang['cancel'] ?></button>
                <button type="button" id='add_user' data-dismiss="modal" data-path="<?php echo base_url().'admin/tables/add_user'; ?>" class="btn btn-primary"><?php echo $tracking_tables_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>
