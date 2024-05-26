<?php
    session_start();
    $auth_role = [1,2];
    require('../site-config/admin_require.php');

    $current_page   = isset($_GET['page']) ? $_GET['page'] : 1;

    $record_per_page= 5;
    $total_sql  = "SELECT count(id) AS total FROM `members`";
    $total_result = $mysqli->query($total_sql);
    $total_row = $total_result->fetch_assoc();
    $total_members = $total_row['total'];
    $total_pages = ceil($total_members / $record_per_page);

    if($current_page < 1 || $current_page > $total_pages){
        $current_page = 1;
    }

    $offset = ($current_page - 1) * $record_per_page ;
    
    $title          = ": Member List";
    $next_page_url  = $admin_base_url . 'show_member.php?page=' . $current_page+1 ;
    $prev_page_url  = $admin_base_url . 'show_member.php?page=' . $current_page-1 ;
    $first_page_url = $admin_base_url . 'show_member.php?page=1' ;
    $last_page_url  = $admin_base_url . 'show_member.php?page=' . $total_pages ;

    $sql        = "SELECT 
                members.id AS id, username, email, phone, gender, status, CONCAT(date_of_birth,' (', TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()), ')') AS date_of_birth, thumbnail, city_id, city.name AS city_name,
                CASE 
                    WHEN gender = 0 THEN 'male'
                    WHEN gender = 1 THEN 'female'
                END AS gender
                FROM `members` 
                JOIN `city`
                ON members.city_id = city.id
                ORDER BY id DESC
                LIMIT $offset, $record_per_page";
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
        <h3>Member List</h3><span>
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
                            <th class="column-title">Email</th>
                            <th class="column-title">Phone</th>
                            <th class="column-title">Gender</th>
                            <th class="column-title">Birthday</th>
                            <th class="column-title">Photo</th>
                            <th class="column-title">City</th>
                            <th class="column-title">Status</th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="10">
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
                                $email              = htmlspecialchars($row['email']);
                                $phone              = htmlspecialchars($row['phone']);
                                $gender             = htmlspecialchars($row['gender']);
                                $date_of_birth      = htmlspecialchars($row['date_of_birth']);
                                $thumb              = htmlspecialchars($row['thumbnail']);
                                $thumb_url          = $base_url . 'assets/uploads/' . $id . '/thumb/' . $thumb;
                                $city_name          = htmlspecialchars($row['city_name']);
                                $status             = htmlspecialchars($row['status']);
                                $delete_url         = $admin_base_url . 'delete_member.php?id=' . $id;
                                $confirm_url        = $admin_base_url . 'confirm_member.php?id=' . $id;
                                $view_url           = $admin_base_url . 'member_details.php?id=' . $id;
                                $point_url          = $admin_base_url . 'manage_point.php?id=' . $id;

                        ?>
                            <tr class="even pointer ">
                                <td class="a-center align-middle">
                                    <input type="checkbox" class="flat" name="table_records">
                                </td>
                                <td class="align-middle"><?php echo $id; ?></td>
                                <td class="align-middle "><?php echo $username; ?></td>
                                <td class="align-middle "><?php echo $email; ?></td>
                                <td class="align-middle "><?php echo $phone; ?></td>
                                <td class="align-middle "><?php echo $gender; ?></td>
                                <td class="align-middle "><?php echo $date_of_birth; ?></td>
                                <td class="align-middle "><div style="width: 80px;"><img class="w-100" src="<?php echo $thumb_url; ?>"></div></td>
                                <td class="align-middle "><?php echo $city_name; ?></td>
                                <td class="align-middle ">
                                    <?php 
                                    if($status == 0) {
                                    ?>
                                        <span class="badge badge-warning" >unverified</span>
                                    <?php
                                    }else if($status == 1) {
                                    ?>
                                        <span class="badge badge-info" >email verified</span>
                                    <?php  
                                    }else if($status == 2) {
                                    ?>
                                        <span class="badge badge-success">admin verified</span>
                                    <?php 
                                    }else if($status == 3) {
                                    ?>
                                        <span class="badge badge-danger">banned</span>
                                    <?php 
                                    }
                                    ?>
                                </td>
                                <td class="">
                                    <a href="<?php echo $delete_url; ?>" ><button type="button" class="btn btn-danger py-0 d-flex justify-content-between align-items-center btn-sm w-100"><i class="fa fa-trash"></i> <span>Delete</span> </button></a>
                                    <a href="<?php echo $confirm_url; ?>" ><button type="button" class="btn btn-success py-0 d-flex justify-content-between align-items-center btn-sm w-100"><i class="fa fa-check"></i> <span>Confirm</span></button></a>
                                    <a href="<?php echo $view_url; ?>" ><button type="button" class="btn btn-dark py-0 d-flex justify-content-between align-items-center btn-sm w-100"><i class="fa fa-eye"></i> <span>View</span></button></a>
                                    <a href="<?php echo $point_url; ?>" ><button type="button" class="btn btn-primary py-0 d-flex justify-content-between align-items-center btn-sm w-100"><i class="fa fa-diamond"></i> <span>Point</span></button></a>
                                </td>
                            </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                    <div class="d-flex justify-content-between">
                        <div id="page-indicator" class="" style="font-size: 16px; font-weight: bold;"><?php echo $current_page . ' of ' . $total_pages; ?></div>
                        <div id="pagination">
                            <a href="<?php echo $first_page_url ?>" ><button class="btn btn-sm btn-secondary mx-0" <?php if($current_page <= 1) {  echo "disabled"; } ; ?>><i class="fa fa-angle-double-left" aria-hidden="true"></i></button></a>
                            <a href="<?php echo $prev_page_url ?>"><button class="btn btn-sm btn-secondary mx-0" <?php if($current_page <= 1) {  echo "disabled"; } ; ?>><i class="fa fa-angle-left" aria-hidden="true"></i></button></a>
                            <span class="btn btn-sm btn-primary mx-0"><?php echo $current_page; ?></span>
                            <a href="<?php echo $next_page_url ?>"><button class="btn btn-sm btn-secondary mx-0" <?php if($current_page >= $total_pages) {  echo "disabled"; } ; ?>><i class="fa fa-angle-right" aria-hidden="true"></i></button></a>
                            <a href="<?php echo $last_page_url ?>"><button class="btn btn-sm btn-secondary mx-0" <?php if($current_page >= $total_pages) {  echo "disabled"; } ; ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i></button></a>
                        </div>
                    </div>
                </div>
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