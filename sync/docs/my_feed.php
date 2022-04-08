<?php
function curl_call($url='') {
     $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://demo.belgiumwebnet.com/test",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 5000,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_POSTREDIR => 3, 
      CURLOPT_FOLLOWLOCATION => TRUE,


    //  CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "postman-token: 35a44445-246d-7c16-ab03-06ece4e4c991"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
       if($response!='')
echo $response;
    }

  }
curl_call();
?>
