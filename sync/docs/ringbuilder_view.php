<?php
  $host = "localhost";
  $user = "root";
  $pass = "123456";
  $db = "backend";
  $con = new mysqli($host, $user, $pass, $db);
  // Check connection
  if ($con->connect_errno){
    echo "Failed to connect to MySQL: " . $con->connect_error;
    exit();
  }
$viewSQL = "SELECT
   `p`.`product_id` AS `product_id`,
    `p`.`name` AS `product_name`,
    `p`.`group_id` AS `group_id`,
    `p`.`gem_group_id` AS `gem_group_id`,
    `p`.`gem_id` AS `gem_id`,
    `p`.`sku` AS `product_sku`,
    `p`.`fake_sku` AS `fake_sku`,
    `p`.`desp` AS `product_desp`,
    `p`.`short` AS `product_short`,
    `p`.`price` AS `product_price`,
    `p`.`sale_price` AS `product_sale_price`,
    (`p`.`price` - `p`.`sale_price`) AS `product_discount`,
    `p`.`status` AS `product_status`,
    `p`.`slug` AS `product_slug`,
    `p`.`meta_title` AS `product_meta_title`,
    `p`.`meta_keywords` AS `product_meta_keywords`,
    `p`.`meta_desp` AS `product_meta_desp`,
    `p`.`metal_color` AS `metal_type`,
    `p`.`category_id` AS `category_id`,
    `pc`.`name` AS `category_name`,
    `pc`.`slug` AS `category_slug`,
    `pc`.`parent` AS `category_parent`,
    `pc`.`status` AS `category_status`,";


$sql = "SELECT cat.category_id, cat.name AS cat_nam, atr.attribute_id, atr.name AS atr_name FROM attribute atr JOIN category cat ON cat.category_id = atr.category_id GROUP BY atr.attribute_id ORDER BY cat.category_id";
$res = mysqli_query($con, $sql);
while($row = mysqli_fetch_assoc($res)){
    $viewSQL .="( CASE WHEN(av.attribute_id = '".$row['attribute_id']."') THEN av.value END) AS 'at_".str_replace(" ", "_", $row['atr_name'])."_".$row['category_id']."',";
}

//$viewSQL = rtrim($viewSQL, ',');
$sql = "SELECT gem.gemstone_id, gem.name AS gem_name, gatr.gemstone_attribute_id, gatr.name AS gem_atr_name FROM gemstone_attribute gatr JOIN gemstone gem ON gem.gemstone_id = gatr.gemstone_id GROUP BY gatr.gemstone_attribute_id";
$res = mysqli_query($con, $sql);
while($row = mysqli_fetch_assoc($res)){
    $viewSQL .="( CASE WHEN(gv.gem_attr_id = '".$row['gemstone_attribute_id']."') THEN gv.value END) AS 'gs_".str_replace(" ", "_", $row['gem_atr_name'])."_".$row['gemstone_id']."',";
}

$viewSQL = rtrim($viewSQL, ',');
//$viewSQL .='CASE WHEN(md.sort_order = '0') THEN gv.value END )';

$viewSQL .='FROM products p

LEFT JOIN attribute_value av ON p.group_id = av.group_id
LEFT JOIN attribute attr ON av.attribute_id = attr.attribute_id

LEFT JOIN gemstone_attribute_value gv ON p.gem_group_id = gv.gem_group_id
LEFT JOIN gemstone_attribute gttr ON gv.gem_attr_id = gttr.gemstone_attribute_id
LEFT JOIN gemstone g ON gttr.gemstone_id = g.gemstone_id
LEFT JOIN category pc ON pc.category_id = attr.category_id
JOIN media md on p.product_id=md.element_id

GROUP BY p.product_id';

echo $viewSQL;

  
?>
