<?php
error_reporting(E_ALL);
//fucntion to get csv file from bassali url
function get_csv($download=true){
  //---------------database----------
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
  //---------------database----------

  $dir = 'bassali/';
  $file_name = "bassaliinventory.csv";
  $save_file_loc = $dir.$file_name;

  if($download){
        $url = 'http://www.bassalijewelry.com/export/bassaliinventory.csv'; 
        $ch = curl_init($url);
        if(!is_dir($dir)){
          mkdir($dir, 0777);
        }
        $fp = fopen($save_file_loc, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        chmod($save_file_loc, 0777);
  }

    $json_file = $dir.'/inventory.json';
    $json_data = csvToJson($save_file_loc);
    write_to_file($json_file, $json_data);
    $pArray = json_decode($json_data, true);
    foreach ($pArray as $prod) {
      print_r($prod);
      $metal = Materials_map($prod['Materials']);
      $sku = Materials_map_sku($metal, $prod['Stock Number']);
      
      $markup=30; //change it as per the client's requirement.
      $sale_price = $prod['Price'] + ($prod['Price']*($markup/100));
      $slug = create_slug($prod['Materials'], $prod['Department'], $prod['Item Type']);
      $name = $prod['Name'];
      if($name==''){
        $name = slug_to_name($slug);
      }

      echo $sql = "INSERT INTO `products` (`gender`, `category_id`, `group_id`, `gem_group_id`, `gem_id`, `name`, `metal_color`, `sku`, `fake_sku`, `desp`, `short`, `stones`, `shape`, `grade`, `color`, `clarity`, `weight`, `discount`, `price`, `sale_price`, `status`, `slug`, `meta_title`, `meta_keywords`, `meta_desp`, `updated_at`) VALUES ('".$prod['Gender']."', ".cat_map($prod['Department'], $prod['Item Type']).", '".md5("grp_bassali".$prod['Stock Number'])."', '".md5("gem_bassali".$prod['Stock Number'])."', 5, '".$name."', '".$metal."', '".$sku."', '".$sku."', '".$prod['Details']."', '".$prod['Description']."', '', '', '', '', '', '".$prod['Total Carat Weight']."', '0', '".$prod['Price']."', '".$sale_price."', 'active', '".$slug."', '".$slug."', '".$slug."', '".$slug."', '');";

      //database query to insert product in table
      $con->query($sql);
      $insert_id = $con->insert_id;
      $product_id_qry = "updte products set product_id = ".$insert_id." where new_primary = ".$insert_id;
      $con->query($product_id_qry);
      exit;
    }
}

// php function to convert csv to json format
function csvToJson($fname) {
    if (!($fp = fopen($fname, 'r'))) {
        die("Can't open file...");
    }

    $key = fgetcsv($fp, "1024",",");
    $json = array();
    while ($row = fgetcsv($fp,"1024",",")) {
        $json[] = array_combine($key, $row);
    }
    fclose($fp);
    return json_encode($json);
}

//function to write data in given file
function write_to_file($file, $data){
    $myfile = fopen( $file, "w") or die("Unable to open file!");
    if(fwrite($myfile, $data)){
      $status=true;  
    }
    else{
      $status=flase;
    }
    fclose($myfile);
    return $status;
}


function cat_map($department, $itemtype){
  $catArray = array(
        "Fashion"=>array("Bridal"=>2,"Earring"=>5,"Ring"=>1,"Necklace"=>4),
        "Bridal-engagement"=>array("Bridal"=>8,"Earring"=>5,"Ring"=>2,"Necklace"=>4)
  );
  return $catArray[$department][$itemtype];

}

function Materials_map($materials){
  $materials = str_replace("12K", "", $materials);
  $materials = str_replace("14K", "", $materials);
  $materials = str_replace("16K", "", $materials);
  $materials = str_replace("18K", "", $materials);
  $materials = str_replace("20K", "", $materials);
  $materials = str_replace("22K", "", $materials);
  $materials = trim(str_replace("24K", "", $materials));
  return strtolower(str_replace(" ", "-", $materials));
}

function Materials_map_sku($metal, $StockNumber){
  $tmp = explode("-", $metal);
  return strtoupper($StockNumber.$tmp[0][0].$tmp[1][0]);
}

function create_slug($Materials, $Department, $ItemType){
  $Materials = str_replace(" ", "-", $Materials);
  $Department = str_replace(" ", "-", $Department);
  $ItemType = str_replace(" ", "-", $ItemType);
  return strtolower($Materials."-".$Department."-".$ItemType);
}

function slug_to_name($slug){
  return ucwords(str_replace("-", " ", $slug));
}

function echo_pre(){
  echo "<pre>";
}
//script entry point
echo_pre();
get_csv(false);
?>
