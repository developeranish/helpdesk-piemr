 <?php
$dir = "tmp/";
// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){ $i=0;
    while (($file = readdir($dh)) !== false){		
		if((time()-18000)>filemtime($dir.$file)){echo $i++;
      echo "filename:" . $file . "-".filemtime($dir.$file)."-".time()."<br>";
	  unlink($dir.$file);
		}
    }
    closedir($dh);
  }
}
?> 