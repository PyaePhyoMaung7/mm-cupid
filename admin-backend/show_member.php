<?php
    session_start();
    $auth_role = [1,2];
    require('../site-config/admin_require.php');

    
    $selected_status    = '';
    $where_status       = "";
    $url_status         = "";

    $current_page       = isset($_GET['page']) ? $_GET['page'] : 1;
    
    if(isset($_GET['status'])) {
        $selected_status = $_GET['status'];
        $where_status   = " WHERE status = " . $selected_status;
        $url_status     = "status=" . $selected_status  . '&';

    }

    if($selected_status != '' && ($selected_status < 0 || $selected_status > 6)) {
        $current_page       = 1;
    }

    $record_per_page    = 5;
    $total_sql          = "SELECT count(id) AS total FROM `members`" . $where_status;
    $total_result       = $mysqli->query($total_sql);
    $total_row          = $total_result->fetch_assoc();
    $total_members      = $total_row['total'];
    $total_pages        = ceil($total_members / $record_per_page);

    if($current_page < 1 || $current_page > $total_pages){
        $current_page = 1;
    }

    $offset = ($current_page - 1) * $record_per_page ;
    
    $title          = ": Member List";
    $next_page_url  = $admin_base_url . 'show_member.php?' . $url_status . 'page=' . $current_page+1 ;
    $prev_page_url  = $admin_base_url . 'show_member.php?' . $url_status . 'page=' . $current_page-1 ;
    $first_page_url = $admin_base_url . 'show_member.php?' . $url_status . 'page=1' ;
    $last_page_url  = $admin_base_url . 'show_member.php?' . $url_status . 'page=' . $total_pages ;

    $sql        = "SELECT 
                members.id AS id, username, email, phone, gender, status, CONCAT(date_of_birth,' (', TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()), ')') AS date_of_birth, thumbnail, city_id, city.name AS city_name,
                CASE 
                    WHEN gender = 0 THEN 'male'
                    WHEN gender = 1 THEN 'female'
                END AS gender
                FROM `members` 
                JOIN `city`
                ON members.city_id = city.id 
                " . $where_status . "
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
            <h3>Member List</h3>
        </div>
        <div class="title_right">
            <!-- <form id="status-filter-form" action="<?php echo $admin_base_url; ?>show_member.php" method="POST"> -->
                <select onchange="filterWithStatus()" class="form-control col-4 float-right" name="selected_status" id="selected-status">
                    <option value="" <?php if($selected_status == '') echo 'selected'; ?>>all</option>
                    <option value="0" <?php if($selected_status == 0) echo 'selected'; ?>>unverified</option>
                    <option value="1" <?php if($selected_status == 1) echo 'selected'; ?>>email_verified</option>
                    <option value="2" <?php if($selected_status == 2) echo 'selected'; ?>>pending</option>
                    <option value="3" <?php if($selected_status == 3) echo 'selected'; ?>>denied</option>
                    <option value="4" <?php if($selected_status == 4) echo 'selected'; ?>>approved</option>
                    <option value="5" <?php if($selected_status == 5) echo 'selected'; ?>>banned</option>
                    <option value="6" <?php if($selected_status == 6) echo 'selected'; ?>>partner_found</option>
                </select>

                <!-- <input type="hidden" name="form-sub" value="1"> -->
            <!-- </form> -->
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
                                $ban_unban_url      = $admin_base_url . 'ban_member.php?id=' . $id;
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
                                        <span class="badge badge-secondary" >unverified</span>
                                    <?php
                                    }else if($status == 1) {
                                    ?>
                                        <span class="badge badge-info">email verified</span>
                                    <?php
                                    }else if($status == 2) {
                                    ?>
                                        <span class="badge badge-warning" >pending</span>
                                    <?php
                                    }else if($status == 3) {
                                    ?>
                                        <span class="badge badge-dark" >declined</span>
                                    <?php  
                                    }else if($status == 4) {
                                    ?>
                                        <span class="badge badge-success">verified</span>
                                    <?php 
                                    }else if($status == 5) {
                                    ?>
                                        <span class="badge badge-danger">banned</span>
                                    <?php 
                                    }
                                    ?>
                                </td>
                                <td class="align-middle">
                                    <?php 
                                    if($status == 2) {
                                    ?>
                                        <a href="<?php echo $confirm_url; ?>" ><button type="button" class="btn btn-success shadow-sm py-0 d-flex justify-content-between align-items-center btn-sm w-100"><i class="fa fa-check"></i> <span>Confirm</span></button></a>
                                    <?php
                                    }
                                    ?>
                                    <a href="<?php echo $view_url; ?>" ><button type="button" class="btn btn-dark shadow-sm py-0 d-flex justify-content-between align-items-center btn-sm w-100"><i class="fa fa-eye"></i> <span>View</span></button></a>
                                    <a href="<?php echo $point_url; ?>" ><button type="button" class="btn btn-primary shadow-sm py-0 d-flex justify-content-between align-items-center btn-sm w-100"><i class="fa fa-diamond"></i> <span>Point</span></button></a>
                                    <?php 
                                    if($status == 5) {
                                    ?>
                                    <a href="javascript:void(0)" onclick="confirmBanOrUnban('<?php echo $ban_unban_url; ?>&status=2', <?php echo $status; ?>)" ><button type="button" class="btn btn-white text-danger shadow-sm py-0 d-flex justify-content-between align-items-center btn-sm w-100"><i class="fa fa-unlock"></i> <span>Release</span> </button></a>
                                    <?php
                                    } else {
                                    ?>
                                    <a href="javascript:void(0)" onclick="confirmBanOrUnban('<?php echo $ban_unban_url; ?>&status=5', <?php echo $status; ?>)" ><button type="button" class="btn btn-danger py-0 d-flex shadow-sm justify-content-between align-items-center btn-sm w-100"><i class="fa fa-ban"></i> <span>Ban</span> </button></a>
                                    <?php
                                    }
                                    ?>
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
    function confirmBanOrUnban (url, status) {
        let title, message, confirm_message;
        if (status == 5) {
            title           = "Release confirmation!"
            message         = "Are you sure to release this member!";
            confirm_message = "Yes, release him/her";
            console.log('hi');
        } else {
            title           = "Ban confirmation!"
            message         = "Are you sure to ban this member!";
            confirm_message = "Yes, ban him/her";
        }

        Swal.fire({
            title: title,
            text: message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: confirm_message
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
                
            }
        });
    }

    function filterWithStatus () {
        const status    = $('#selected-status').val();
        let location;
        
        if (status != '') {
            location  = "<?php echo $admin_base_url; ?>show_member.php?" + "status=" + status + "&page=1";
        } else {
            location  = "<?php echo $admin_base_url; ?>show_member.php?page=1";
        }
        window.location.href = location;
    }
    
</script>
<?php
    require('../templates/cp_template_html_end.php');
?>