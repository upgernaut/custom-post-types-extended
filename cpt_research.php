<?php 


class Research extends cpt_post_types_parent {

public $cpt_name = "Research";
public $cpt_id = "research";
public $cpt_dashicon = "dashicons-clipboard";
public $public = true;




function __construct(){
	
	$this->meta_boxes = array(		
		"country" => array(
			"name" => "country",
			"std" => "",
			"type"=>"input",
			"title" => "Country",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter research country.</div>"),				
		"funder" => array(
			"name" => "funder",
			"std" => "",
			"type"=>"input",
			"title" => "Funder",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter research funder.</div>"),					
		"date_from" => array(
			"name" => "date_from",
			"std" => "",
			"type"=>"date",
			"title" => "Start Date",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter research date from.</div>"),					
		"date_to" => array(
			"name" => "date_to",
			"std" => "",
			"type"=>"date",
			"title" => "Ending Date",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter research date to.</div>"),		
		"research_status" => array(
			"name" => "research_status",
			"std" => "",
			"type"=>"dropdown",
			"title" => "Status",      
			"values" => array("","Ongoing","Completed"),
			"description" => ""),
	);
	$this->cpt_init();

}



} // End class
new Research;




