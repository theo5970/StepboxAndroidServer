<?
include('db_connect.php');


$query = "select * from members";
$result = mysqli_query($conn, $query);

$dbdata = array();
while ($row = $result->fetch_assoc()) {
    $dbdata[]=$row;
}

echo json_encode($dbdata, JSON_UNESCAPED_UNICODE);
?>