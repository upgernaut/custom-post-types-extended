<?php 


class Careers extends cpt_post_types_parent {

public $cpt_name = "Careers";
public $cpt_id = "careers";
public $cpt_dashicon = "dashicons-id-alt";
public $public = true;




function __construct(){

	$this->taxonomies = array(		
		"position_type" => array(
			"id" => "position_type",
			"name" => "Position type"
		),	
	);		


	$this->meta_boxes = array(	
		"location" => array(
			"name" => "location",
			"std" => "",
			"type"=>"input",
			"title" => "Location",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter careers location.</div>"),			
		"deadline" => array(
			"name" => "deadline",
			"std" => "",
			"type"=>"date",
			"title" => "Deadline",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter careers deadline.</div>"),		
		"employment" => array(
			"name" => "employment",
			"std" => "",
			"type"=>"dropdown",
			"title" => "Employment type",      
			"values" => array("","Part-time","Full-time"),
			"description" => ""),
	);
	$this->cpt_init();

}



} // End class
new Careers;

