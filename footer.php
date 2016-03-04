<?php

/*

	This code goes between your html code and the closing </html> tag.

*/

?>

<?php

	global $d3_shortcode_vis;
	//We only want to add this code if their actually is a visualization on the page, otherwise we donÄt need to load all this
	if(isset($d3_shortcode_vis) && (count($d3_shortcode_vis) >= 1)){

		//First we load all the libraries we need on every visualization page
		echo '<script src="http://d3js.org/d3.v3.min.js"></script>';

		//Again, you could do this with javascript, but here is an example how you can load additional libraries depending on vis type
		$d3_shortcode_vis_added = array();

		foreach ($d3_shortcode_vis as $vis) {
			switch ($vis["type"]) {
				case "vis_type_1":
		    		d3_shortcode_vis_addLibrary("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js", false);
		    	break;
		    	case "vis_type_2":
		    		d3_shortcode_vis_addLibrary("js/special_lib.js", true);
		    	break;
		    	default:
		    		//Add nothing
		    	break;
			}
		}

		//If you add comma separated library paths to your short code, you could also extract them easily:
		foreach ($d3_shortcode_vis as $vis) {
			$libs = explode(",", $vis["libs"]);
			foreach ($libs as $lib) {
				d3_shortcode_vis_addLibrary($lib, $lib, false);
			}
		}

		//Function which outputs the library and checks if it has been added before
		function d3_shortcode_vis_addLibrary($path, $local){
			global $d3_shortcode_vis_added;
			$found = false;
			foreach ($d3_shortcode_vis_added as $l) {
				if($l == $path){
					$found = true;
				}
			}
			if(!$found){
				array_push($d3_shortcode_vis_added, $path);
				echo '<script src="';
				if($local){
					echo esc_url( get_template_directory_uri() );
				}
				echo $path.'"></script>';
			}
		}

		//Now we have all the js magic we need, so we only need to initiate all the visualizations and pass along their container id
?>
		<script>
		//visualizations
		var d3_shortcode_vis = [], d3_shortcode_vis_temp;

		//You could also remove those lines here, as we are at the bottom of the page and everything should have been loaded, but well sometimes its good to be sure
		document.addEventListener("DOMContentLoaded", function(e) {

<?php

	foreach ($d3_shortcode_vis as $vis) {
		echo 'd3_shortcode_vis_temp = '.$vis["type"].'(); d3.select("#'.$vis['id'].'").call('.$vis["type"].'); d3_shortcode_vis.push(d3_shortcode_vis_temp);';
	}

?>

		});            
    </script>
<?php
	}
?>

