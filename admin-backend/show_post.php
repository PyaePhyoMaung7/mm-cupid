<?php
    session_start();
    $auth_role = [1, 2];
    require('../site-config/admin_require.php');
    
    $title      = ": Knowledge Post List";
    
    $current_page   = isset($_GET['page']) ? $_GET['page'] : 1;

    $record_per_page= 5;
    $total_sql  = "SELECT count(id) AS total FROM `knowledge` WHERE deleted_at IS NULL";
    $total_result = $mysqli->query($total_sql);
    $total_row = $total_result->fetch_assoc();
    $total_posts = $total_row['total'];
    $total_pages = ceil($total_posts / $record_per_page);

    if($current_page < 1 || $current_page > $total_pages){
        $current_page = 1;
    }

    $offset = ($current_page - 1) * $record_per_page ;

    $next_page_url  = $admin_base_url . 'show_post.php?page=' . $current_page+1 ;
    $prev_page_url  = $admin_base_url . 'show_post.php?page=' . $current_page-1 ;
    $first_page_url = $admin_base_url . 'show_post.php?page=1' ;
    $last_page_url  = $admin_base_url . 'show_post.php?page=' . $total_pages ;
    $sql        = "SELECT id, title, description, thumbnail 
                    FROM `knowledge` 
                    WHERE deleted_at IS NULL
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
                    <th class="column-title">Title</th>
                    <th class="column-title">Description</th>
                    <th class="column-title">Image</th>
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
                            $title              = htmlspecialchars($row['title']);
                            $description        = htmlspecialchars($row['description']);
                            $image              = $base_url . 'assets/post_images/' . $id . '/thumb/' . $row['thumbnail'];
                            $edit_url           = $admin_base_url . 'edit_post.php?id=' . $id;
                            $delete_url         = $admin_base_url . 'delete_post.php?id=' . $id;
                    ?>
                        <tr class="even pointer">
                            <td class="align-middle a-center">
                                <input type="checkbox" class="flat" name="table_records">
                            </td>
                            <td class="align-middle  "><?php echo $id; ?></td>
                            <td class="align-middle col-3"><?php echo substr($title, 0, 100) . ' ...'; ?></td>
                            <td class="align-middle col-4"><?php echo substr($description, 0, 200) . ' ...'; ?></td>
                            <td class="align-middle  ">
                                <div style="width:120px; height: 90px;">
                                    <img class="w-100 h-100 object-fit-cover" src="<?php echo $image; ?>" alt="">
                                </div>
                            </td>
                            <td class="align-middle ">
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