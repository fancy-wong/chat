<?php
header('Content-Type: text/event-stream'); 
header('Cache-Control: no-cache'); 

$conn=mysqli_connect("localhost","root","root","test");
$sql = "select * from user order by id desc limit 15";
$result = mysqli_query($conn, $sql);
while ($res = mysqli_fetch_assoc($result)) {
    $array[] = $res;
}
$data = json_encode($array);
echo "data: {$data}\n\n"; 
flush();
?>