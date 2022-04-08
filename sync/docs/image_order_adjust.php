<?php
$con = new mysqli("localhost","root","123456","backend");

// Check connection
if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $con -> connect_error;
  exit();
}
$master_arr = [];

$sql = "SELECT * FROM `products` group by `group_id`";
$res = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($res)){
	$sql1 = "SELECT * FROM `media` WHERE `element_type` = 'product' AND `element_id` = ".$row['product_id']." and type=1";
	$arr = [];
	$res1 = mysqli_query($con, $sql1);
	$counter=0;
	while($row1 = mysqli_fetch_array($res1)){
		if($row1['sort_order']==$counter){
			$counter++;
		}
		else{
			array_push($master_arr, $row['product_id']);
			break;
		}
	}
}

echo json_encode($master_arr);

/*$f = fopen("image-orders.json", "w");
fwrite(json_encode($master_arr, TRUE));
fclose($f);*/

?>