<?php
    session_start();
    $auth_role = [1, 2];
    require('../site-config/admin_require.php');
    
    $title      = ": Knowledge Post List";
    $sql        = "SELECT id, username, status, 
                    CASE
                        WHEN role = 1 THEN 'admin'
                        WHEN role = 2 THEN 'customer service'
                        WHEN role = 3 THEN 'editor'
                    END AS role_description FROM `user` WHERE deleted_at IS NULL";

    $result     = $mysqli->query($sql);
    $num_rows   = $result->num_rows;

    require('../templates/cp_template_header.php');
    require('../templates/cp_template_sidebar.php');
    require('../templates/cp_template_top_nav.php');
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
    <div class="page-title">
        <div class="title_left">
        <h3>Knowledge Post List</h3>
        </div>
    </div>

    <div class="row" style="display: block;">

        <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_content">

            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                    <th>
                        <input type="checkbox" id="check-all" class="flat">
                    </th>
                    <th class="column-title">Id</th>
                    <th class="column-title">Username</th>
                    <th class="column-title">Role</th>
                    <th class="column-title">Status</th>
                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    </th>
                    <th class="bulk-actions" colspan="7">
                        <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                    </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if($num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $id                 = (int) $row['id'];
                            $username           = htmlspecialchars($row['username']);
                            $role_description   = htmlspecialchars($row['role_description']);
                            $edit_url           = $admin_base_url . 'edit_post.php?id=' . $id;
                            $delete_url         = $admin_base_url . 'delete_post.php?id=' . $id;
                    ?>
                        <tr class="even pointer">
                            <td class="a-center ">
                                <input type="checkbox" class="flat" name="table_records">
                            </td>
                            <td class=" "><?php echo $id; ?></td>
                            <td class=" "><?php echo $username; ?></td>
                            <td class=" "><?php echo $role_description; ?></td>
                            <td class=" ">
                                <?php 
                                if($row['status'] == 0){
                                ?>
                                <span class="badge badge-success">active</span>
                                <?php
                                } else {
                                ?>
                                <span class="badge badge-danger">inactive</span>
                                <?php     
                                }
                                ?>
                            </td>
                            <td class="">
                                <a href="<?php echo $edit_url; ?>" ><button type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Edit</button></a>
                                <a href="javascript:void(0)" onclick="confirmDelete('<?php echo $delete_url; ?>')" style="color: white;" ><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button></a>
                            </td>
                        </tr>
                    <?php
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
<!-- /page content -->
<?php
    require('../templates/cp_template_footer.php');
?>
<!-- Custom javascript code goes here -->
<script>
    function confirmDelete(url){
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
    
</script>
<?php
    require('../templates/cp_template_html_end.php');
?>