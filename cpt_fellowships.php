<?php 


class Fellowships extends cpt_post_types_parent {

public $cpt_name = "Fellowships";
public $cpt_id = "fellowships";
public $cpt_dashicon = "dashicons-clipboard";
public $public = true;




function __construct(){

	
	$this->meta_boxes = array(		
		"country" => array(
			"name" => "country",
			"std" => "",
			"type"=>"input",
			"title" => "Country",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter fellowships country.</div>"),				
		"funder" => array(
			"name" => "funder",
			"std" => "",
			"type"=>"input",
			"title" => "Funder",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter fellowships funder.</div>"),					
		"date_from" => array(
			"name" => "date_from",
			"std" => "",
			"type"=>"date",
			"title" => "Start Date",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter fellowships date from.</div>"),					
		"date_to" => array(
			"name" => "date_to",
			"std" => "",
			"type"=>"date",
			"title" => "Ending Date",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter fellowships date to.</div>"),		
		"fellowships_status" => array(
			"name" => "fellowships_status",
			"std" => "",
			"type"=>"dropdown",
			"title" => "Status",      
			"values" => array("","Ongoing","Completed"),
			"description" => ""),
	);
	$this->cpt_init();

}



} // End class
new Fellowships;




