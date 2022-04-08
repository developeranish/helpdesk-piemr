<?php
//fucntion to get csv file from bassali url
function get_basslai_csv($download=true){
  
  $dir = $_SERVER['DOCUMENT_ROOT'].'/'.BASSALI_DATA;
  $file_name = "bassaliinventory.csv";
  $save_file_loc = $dir.$file_name;
  $CI = get_instance();

  if($download){
        $url = 'http://www.bassalijewelry.com/export/bassaliinventory.csv'; 
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        if(!is_dir($dir)){
          mkdir($dir, 0777);
        }
        $fp = fopen($save_file_loc, 'w+');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
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
      $metal = Materials_map($prod['Materials']);
      $sku = Materials_map_sku($metal, $prod['Stock Number']);
      $sku = clean_sku($sku);
      pr($sku);
      
      $markup=30; //change it as per the client's requirement.
      $sale_price = $prod['Price'] + ($prod['Price']*($markup/100));
      $slug = create_bslug($sku, $prod['Materials'], $prod['Department'], $prod['Item Type']);
      $name = $prod['Name'];
      if($name==''){
          $name = slug_to_name($slug);
      }
      if($prod['Gender']=="M")
          $prod['Gender']="male";
      else
        $prod['Gender']="Female";

      if(!is_dir($dir.$sku)){
          mkdir($dir.$sku, 0777);
      }

      $slug = $slug."-".$sku;
      //insert product record
      $sql = "INSERT INTO `products` (`gender`, `category_id`, `group_id`, `gem_group_id`, `gem_id`, `name`, `metal_color`, `sku`, `fake_sku`, `desp`, `short`, `stones`, `shape`, `grade`, `color`, `clarity`, `weight`, `discount`, `price`, `sale_price`, `status`, `slug`, `meta_title`, `meta_keywords`, `meta_desp`, `vendor_id`) VALUES ('".$prod['Gender']."', ".cat_map($prod['Department'], $prod['Item Type']).", '".md5("grp_bassali".$prod['Stock Number'])."', '".md5("gem_bassali".$prod['Stock Number'])."', 5, '".$name."', '".$metal."', '".$sku."', '".$sku."', '".$prod['Details']."', '".$prod['Description']."', '', '', '', '', '', '".$prod['Total Carat Weight']."', '0', '".$prod['Price']."', '".$sale_price."', 'active', '".$slug."', '".$slug."', '".$slug."', '".$slug."', 2);";
      $CI->db->query($sql);
      $insertId = $CI->db->insert_id();

      $mediaUrl = "../".download_bassali_image($prod['Image 1'], $sku);
      
      //insert media record
      $mediaSQL = "INSERT INTO `media`(`element_type`, `element_id`, `type`, `url`, `metal_type`, `gemstone`, `slug`, `sort_order`) VALUES ('product',".$insertId.",1,'".$mediaUrl."','".$metal."','diamond','".$slug."',0)";
      $CI->db->query($mediaSQL);
    }
}

function download_bassali_image($url, $sku){
        $serverroot = $_SERVER['DOCUMENT_ROOT'].'/';
        $file_name = BASSALI_DATA.$sku."/".pathinfo($url,PATHINFO_BASENAME);
        $ch = curl_init($url);
        $fp = fopen($serverroot.$file_name, 'w');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        chmod($serverroot.$file_name, 0777);
        return $file_name;
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

function create_bslug($sku, $Materials, $Department, $ItemType){
  $Materials = str_replace(" ", "-", $Materials);
  $Department = str_replace(" ", "-", $Department);
  $ItemType = str_replace(" ", "-", $ItemType);
  return strtolower($Materials."-".$Department."-".$ItemType.'-'.$sku);
}

function slug_to_name($slug){
  return ucwords(str_replace("-", " ", $slug));
}

function clean_sku($sku){
   $sku = str_replace(' ', '', $sku); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $sku); // Removes special chars.
}

?>