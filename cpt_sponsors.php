<?php 


class Sponsors extends cpt_post_types_parent {

public $cpt_name = "Sponsors";
public $cpt_id = "sponsors";
public $cpt_dashicon = "dashicons-businessman";
public $public = false; 




function __construct(){
	
	$this->meta_boxes = array(		
		"link" => array(
			"name" => "link",
			"std" => "",
			"type"=>"input",
			"title" => "Link",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter the link to sponsor's website.</div>"),
	);
	$this->cpt_init();

}



} // End class
new Sponsors;




