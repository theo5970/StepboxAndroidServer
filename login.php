<?php
include('db_connect.php');

$output = array("result" => "");

session_start();
$id = $_POST['id'];
$pw = $_POST['pw'];
$pw_hash = hash("sha256", $pw);

$id_check = "SELECT * FROM members WHERE id='$id'";
$result = $conn->query($id_check);
if ($result->num_rows == 1) {
    $row = $result->fetch_array(MYSQLI_ASSOC);

    if (password_verify($pw, $row['pw'])) {
        $_SESSION['userid'] = $id;
        $_SESSION['isloggedin'] = true;

        if (isset($_SESSION['userid'])) {
            $output["result"] = "success";
            $output["sessionid"] = session_id();

            $mysqldatetime = date('Y-m-d H:i:s', time());
            $query = "update members set recentdatetime='$mysqldatetime' where id='$id'";
            $conn->query($query);
            
        } else {
            $output["result"] = "fail";
            $output["message"] = "session_error";
        }
    } else {
        $output["result"] = "fail";
        $output["message"] = "password_mismatch";
    }
} else {
    $output["result"] = "fail";
    $output["message"] = "id_mismatch";
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>