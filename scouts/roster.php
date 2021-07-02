<?php
   if( $_REQUEST["count"] || $_REQUEST["lanes"] ) {
  	header('Content-type: text/plain');    
  	header('Content-Disposition: attachment; filename="roster.csv"');
      $count = $_REQUEST['count'];
      $lanes = $_REQUEST["lanes"];
      if ($count % $lanes) {
	$count = $count + ($lanes - ($count % $lanes));
      }
      
      $racers = range (1,$count);
      


      for ($j=0;$j<$lanes;$j++) {
	      shuffle($racers);

	      for ($i=0;$i<$count;$i++) {
	      	print $racers[$i];
	      	if ((($i+1)%$lanes)==0) {
	      		print "\n";
	      	}
	      	else {
	      		print ",";
	      	}
	      }
	      		print "\n\n";
      }      
      exit();
      
      
      
      
   }
?>
<html>
   <body>
      
      <form action = "<?php $_PHP_SELF ?>" method = "POST">
         Number of racers: <input type = "text" name = "count" />
         Number of lanes: <input type = "text" name = "lanes" />
         <input type = "submit" />
      </form>
      
   </body>
</html>