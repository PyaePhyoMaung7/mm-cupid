<?php
    session_start();
    require('../site-config/connect.php');
    require('../site-config/config.php');
    require('../site-config/include_functions.php');
    require('../site-config/check_member_auth.php');
    $response = [];
    $response['status'] = '500';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $request_data   = file_get_contents('php://input');
        $decoded_data   = json_decode($request_data,true);
        $today_dt       = date('Y-m-d H:i:s');
        $accept_id      = $decoded_data['id'];
        $member_id      = $_SESSION['uid'];

        $point_sql      = "SELECT point FROM `members` WHERE id = '$member_id'";
        $point_res      = $mysqli->query($point_sql);
        $point          = $point_res->fetch_assoc()['point'];

        if($point < $invitation_point) {
            $data               = ['error' => "A0010"];
            $response['data']   = $data;
            $response['status'] = '400';
        } else {
            $already_invited_sql = "SELECT status FROM `date_request`
                                    WHERE invite_id = '$member_id'
                                    AND accept_id   = '$accept_id'
                                    AND deleted_at IS NULL";

            $already_invited_res = $mysqli->query($already_invited_sql);

            if($already_invited_res->num_rows > 0) {
                $response['status'] = '400';

                while($already_invited_row = $already_invited_res->fetch_assoc()) {
                    $status = $already_invited_row['status'];
                }
                if($status == 0) {
                    $data               = ['error' => "A0011"];
                }else if($status == 1) {
                    $data               = ['error' => "A0012"];
                }
                $response['data']   = $data;
                
            } 
            else {
                $get_invited_sql    =  "SELECT status FROM `date_request`
                                        WHERE invite_id = '$accept_id'
                                        AND accept_id   = '$member_id'
                                        AND deleted_at IS NULL";

                $get_invited_res    = $mysqli->query($get_invited_sql);

                if($get_invited_res->num_rows > 0) {
                    $response['status'] = '400';

                    while($get_invited_row = $get_invited_res->fetch_assoc()) {
                        $status = $get_invited_row['status'];
                    }
                    if($status == 0) {
                        $data               = ['error' => "A0011"];
                    }else if($status == 1) {
                        $data               = ['error' => "A0012"];
                    }
                    $response['data']   = $data;
                }

                $insert_sql     = "INSERT INTO `date_request` 
                                    (invite_id, accept_id, status, created_at, created_by, updated_at, updated_by)
                                    VALUES('$member_id', '$accept_id' , 0, '$today_dt', '$member_id', '$today_dt', '$member_id')";
                $insert_res     = $mysqli->query($insert_sql);

                if($insert_res) {
                    $update_sql = "UPDATE `members`
                                    SET point   = (point - '$invitation_point')
                                    WHERE id    = '$member_id'";
                    $mysqli->query($update_sql);
                    
                    $remain_point = $point - $invitation_point; 
                    $_SESSION['upoint'] = $remain_point;

                    $response['data']   = ['point' => $remain_point, 'success' => 'Z0001'];
                    $response['status'] = '200';
                }
            }
            
        }

        echo json_encode($response);
    }
?>