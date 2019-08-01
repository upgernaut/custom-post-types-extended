<?php 


class People extends cpt_post_types_parent {

public $cpt_name = "People";
public $cpt_id = "people";
public $cpt_dashicon = "dashicons-groups";
public $public = true;

function __construct(){

	$this->taxonomies = array(		
		"people_group" => array(
			"id" => "people_group",
			"name" => "Group"
		),		
	);	

	$this->options = array(
		"description" => array(
			"name" => "description",
			"std" => "",
			"type"=>"editor",
			"title" => "Description",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter customer description.</div>"),
	);	
	
	$this->meta_boxes = array(		
		"position" => array(
			"name" => "position",
			"std" => "",
			"type"=>"input",
			"title" => "Position",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter customer position.</div>"),		
		"email" => array(
			"name" => "email",
			"std" => "",
			"type"=>"input",
			"title" => "Email",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter customer email.</div>"),		
		"twitter" => array(
			"name" => "twitter",
			"std" => "",
			"type"=>"input",
			"title" => "Twitter",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter customer Twitter.</div>"),		
		"linkedin" => array(
			"name" => "linkedin",
			"std" => "",
			"type"=>"input",
			"title" => "LinkedIn",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter customer LinkedIn.</div>"),		
		"facebook" => array(
			"name" => "facebook",
			"std" => "",
			"type"=>"input",
			"title" => "Facebook",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter customer Facebook link.</div>"),
	);
	$this->cpt_init();

}



} // End class
new People;




