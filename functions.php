<?php

//Add this section to your theme's functions.php file

/*------------------- CUSTOM D3 SHORTCODE -------------------*/

//This array will hold meta attributes about the visualizations embedded into a page/post
global $d3_shortcode_vis;
$d3_shortcode_vis = array();

function d3_shortcode_vis($atts){
	global $d3_shortcode_vis;

	$return = "";

	//extract attributes
	$a = shortcode_atts( array(
		'id' => 'd3_shortcode_vis_'.(count($vis)+1),
		'type' => '',
		'title' => ''
	), $atts );

	if(strlen($a["type"])>=1){

		array_push($d3_shortcode_vis, array(
			"id" => $a["id"],
			"type" => $a["type"]
		));

	//The following needs to be modified to fit your theme
	//You find two examples below:

	/*

	1. Bootstrap
	The normal content container looks like this:

	<div class="container">
		<div class="row">
			<div class="hidden-xs col-sm-1 	col-md-2 col-lg-3"></div>
			<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 content-col">
				HERE GOES THE CONTENT
			</div>
			<div class="hidden-xs col-sm-1 	col-md-2 col-lg-3"></div>	
		</div>
	</div>

	*/

	//If we just want a div container inside the main content column:

	$return .= '<div class="d3_shortcode_vis d3_shortcode_vis_'.$a["type"].'" id="'.$a["id"].'"></div>';

	//Using the standard shortcode structure we can send loads of variables to this script, we can simply add those as data attributes:

	$return .= '<div';
	foreach ($a as $key => $value) {
		$return .= ' data-'.$key.'="'.$value.'"';
	}
	$return .= ' class="d3_shortcode_vis d3_shortcode_vis_'.$a["type"].'" id="'.$a["id"].'"></div>';

	//Or we can add html elements

	$return .= '<div class="d3_shortcode_vis d3_shortcode_vis_'.$a["type"].'" id="'.$a["id"].'">';
	if(isset($a["title"]) && strlen($a["title"])>=1){
		$return .= '<h5>'.$a["title"].'</h5>';
	}
	$return .= '</div>';

	//But maybe we want to close the main container insert a special visualization container and then continue with the content by reopening the content column:

	$return .= '
		</div><!-- content-col -->
        <div class="hidden-xs col-sm-1 col-md-2 col-lg-3"></div>
      </div><!-- row -->
    </div><!-- container -->

    <div class="d3_shortcode_vis d3_shortcode_vis_'.$a["type"].'" id="'.$a["id"].'"></div>

	<div class="container">
		<div class="row">
			<div class="hidden-xs col-sm-1 	col-md-2 col-lg-3"></div>
			<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 content-col">';

	//Normally i would recommend keeping the php part as simple as that and keeping the rest inside the javascript files, but you could of course add some custom stuff that depends on the visualization type:

	$return .= '
		</div><!-- content-col -->
        <div class="hidden-xs col-sm-1 col-md-2 col-lg-3"></div>
      </div><!-- row -->
    </div><!-- container -->

    <div class="d3_shortcode_vis d3_shortcode_vis_'.$a["type"].'" id="'.$a["id"].'">';

    switch($a[$type]){
    	case "vis_type_1":
    		$return .= '<a class="btn">Button</a>';
    	break;
    	case "vis_type_2":
    		$return .= '<a class="btn">Button 1</a> <a class="btn">Button 2</a>';
    	break;
    	default:
    		//Add nothing
    	break;
    }

    $return .= '</div>

	<div class="container">
		<div class="row">
			<div class="hidden-xs col-sm-1 	col-md-2 col-lg-3"></div>
			<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 content-col">';


	//Return the visualization container

	return $return;
}

add_shortcode( 'd3.shortcode.vis', 'd3_shortcode_vis' );

?>