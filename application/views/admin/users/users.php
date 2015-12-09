<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-xs-12">
            <div id="elevator_item"><a id="elevator" onclick="return false;" title="Back To Top"></a></div>
            <div class='row'>
                <div class= "col-xs-12 col-md-5">
                    <?php echo anchor('admin/users/add', $users_lang['create_user'], "class='btn btn-loading btn-primary'"); ?>
                </div>
                <div class= "col-xs-12 col-md-offset-2 col-md-5">
                    <?php echo form_open_multipart('admin/users/search'); ?>
                        <div class="col-xs-12">
                            <div class="input-group">
                                <?php
                                    $data = array(
                                        'name' => 'search',
                                        'class' => 'form-control',
                                        'placeholder' => $users_lang['search_name']);
                                    echo form_input($data, $this->session->userdata('search_name'));
                                ?>
                                <span class="input-group-btn">
                                    <?php echo form_submit('submit', $users_lang['search'], 'class = "btn btn-primary"'); ?>
                                </span>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php if (!empty($_SESSION['message'])) echo "<script type='text/javascript'>announcementMessage('".$_SESSION['message']."')</script>"; ?>
                <div class='table-responsive'>
                    <table class="table table-striped responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr class='heading'>
                                <?php
                                    echo "<th class='column-title'></th>";
                                    echo "<th class='column'>".$users_lang['email']."</th>";
                                    echo "<th class='column'>".$users_lang['first_name']."</th>";
                                    echo "<th class='column'>".$users_lang['last_name']."</th>";
                                    echo "<th class='column'>".$users_lang['what_taste']."</th>";
                                    echo "<th class='column'>".$users_lang['want_vegan_meal']."</th>";
                                    echo "<th class='column'>".$users_lang['role']."</th>";
                                    echo "<th class='column'></th>";
                                    echo "<th class='column'></th></thead>";
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($users != NULL)
                            {
                                foreach ($users as $key => $user)
                                {
                            ?>
                                    <tr id="user_<?php echo $user->id ?>">
                                        <td class="active"><?php echo (($page == 0 ? $page : ($page - 1))*10 + $key + 1) ?></td>
                                        <td class="active"><?php echo $user->email ?></td>
                                        <td class="active"><?php echo $user->first_name ?></td>
                                        <td class="active"><?php echo $user->last_name ?></td>
                                        <td class="active">
                                            <a href="#detail_text_modal" data-toggle="modal" data-target="#detail_text_modal" data-content="<?php echo $user->what_taste ?>" data-title="<?php echo $users_lang['title'] ?>" onclick="false;">
                                                <p class="detail-text"><?php echo (strlen($user->what_taste) > 10) ? substr($user->what_taste, 0, 10)."..." : $user->what_taste ?></p>
                                            </a>
                                        </td>
                                        <td class="active">
                                            <input type="checkbox" disabled class="text-center" <?php echo (($user->want_vegan_meal == 1) ? "checked" : "") ?> >
                                        </td>
                                        <td class="active"><?php echo (($user->admin == 0) ? $users_lang['user'] : $users_lang['admin']) ?></td>
                                        <td class="active"><?php echo anchor('admin/users/edit/'.$user->id, $users_lang['edit'], "class='label btn-loading label-info'") ?></td>
                                        <td class="active">
                                            <a href="#delete_user_modal" class="label label-warning" data-toggle="modal" data-target="#delete_user_modal" data-user-avatar-file-name="<?php echo $user->avatar_file_name ?>" data-user-id="<?php echo $user->id ?>" onclick="false;"><?php echo $users_lang["delete"] ?></a>
                                        </td>
                                    </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
<!-- /page content -->
<!-- Modal -->
<div class="modal fade" id="delete_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $users_lang['delete'] ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $users_lang['are_you_sure'] ?>
                <input type="hidden" name='user_id' value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $users_lang['cancel'] ?></button>
                <button type="button" id='delete_user' data-dismiss="modal" data-path="<?php echo base_url().'admin/users/delete/'; ?>" class="btn btn-primary"><?php echo $users_lang['yes'] ?></button>
            </div>
        </div>
    </div>
</div>