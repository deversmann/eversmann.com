<?php 
        // create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, "http://maps.google.com/maps/api/geocode/json?latlng=".$_GET["lat"].",".$_GET["lon"]."&sensor=true"); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch); 
        
        echo $output;     
?>