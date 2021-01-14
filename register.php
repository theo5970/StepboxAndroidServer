<?php
include('db_connect.php');
$output = array("result" => "success");

$id = test_input($_POST['id']);                 // 아이디
$pw = test_input($_POST['pw']);                 // 비밀번호
$name = test_input($_POST['name']);             // 이름
$birthday = test_input($_POST['birthday']);     // 생년월일
$phone = test_input($_POST['phone']);           // 휴대폰 전화번호
$welfare = test_input($_POST['welfare']);       // 소속 복지관

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function build_error($reason) {
    global $output;

    if ($output["result"] != "fail") {
        $output["result"] = "fail";
    }

    if (!array_key_exists("reason", $output)) {
        $output["reason"] = array();
    }

    $output["reason"][] = $reason;
}

function check_id_overlap($conn, $id) {
    $query = "select * from members where id='$id'";
    $result_set = $conn->query($query);

    if ($result_set->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function check_password($password) {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    
    $condition = ($uppercase || $lowercase) && $number;
    return $condition;
}

// 아이디 확인 (조건: 소문자 또는 숫자 3글자에서 15글자)
if (!preg_match_all('/^[a-z0-9]{3,15}$/', $id)) {
    build_error("id_error");
}

// 비밀번호 문자 확인 (조건: 대소문자, 숫자 각각 1개 이상, 6글자에서 20글자)
if (!check_password($pw)) {
    build_error("pw_error");
}

// 이름 확인 (한글 2~4자)
if (!preg_match("/^[가-힣]{6,12}$/", $name)) {
    build_error("name_error");
}

// 생년월일 확인 (YYYY-mm-dd)
if (!preg_match("/^[12]\d{3}-(0[1-9]|1[0-2]|[1-9])-(0[1-9]|[12]\d|3[01]|[1-9])$/", $birthday)) {
    build_error("birthday_error");
}

// 휴대폰 번호 확인 (010-1234-5678)
if (!preg_match("/^(\d{3})-(\d{3,4})-(\d{4})$/", $phone)) {
    build_error("phone_error");
}

if ($output["result"] != "fail") {
    if (check_id_overlap($conn, $id)) {
        build_error("id_overlap");   
    } else {
        $query = "insert into members (id, name, pw, birth, phone, welfare, registerdatetime) ";

        $pw_hash = password_hash($pw, PASSWORD_BCRYPT);
        $mysqldatetime = date('Y-m-d H:i:s', time());
        $query .= "values('$id', '$name', '$pw_hash', '$birthday', '$phone', '$welfare', '$mysqldatetime')";
        $query_result = $conn->query($query);


        if (!$query_result) {
            build_error("db_error " . $conn->error);
        }
    }
    
}
echo json_encode($output);
exit();
?>