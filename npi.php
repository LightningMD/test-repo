<?php

$city = $_GET['city'];
$state = $_GET['state'];
$zip = $_GET['zip'];
$taxonomy = $_GET['taxonomy'];

//echo "$city <br> $state <br> $zip <br> $taxonomy <br>";
//die;

$fields = "";
if($city){
    $fields .= "&city=$city";
}
if($state){
    $fields .= "&state=$state";
}
if($zip){
    $fields .= "&postal_code=$zip";
}
if($taxonomy){
    $fields .= "&taxonomy_description=$taxonomy";
}
$url = "https://npiregistry.cms.hhs.gov/api?version=2.1$fields&pretty=false";
//echo $url;
//die;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    
    //echo '<pre>' .$data.'</pre>';
    
    $data=json_decode($data);
    $data_array = [["FaxNumber", "To"]];

    foreach($data->results as $row){
        $npi_temp = $row->number;
        $fax_temp = $row->addresses[0]->fax_number;
        
        if($fax_temp == ''){
            
        }
        else{
        array_push($data_array, [$fax_temp, $npi_temp]);
        }
    }
  
function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');

    // open the "output" stream
    // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
    $f = fopen('php://output', 'w');

    foreach ($array as $line) {
        fputcsv($f, $line, $delimiter);
    }
} 


array_to_csv_download($data_array, "export.csv", ',');    
    


    
    
    

    
    
    
    ?>