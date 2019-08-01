<?php 


class Slider extends cpt_post_types_parent {

public $cpt_name = "Slider";
public $cpt_id = "slider";
public $cpt_dashicon = "dashicons-slides";
public $public = false;

function __construct(){

	$this->meta_boxes = array(	
		"slider_link" => array(
			"name" => "slider_link",
			"std" => "",
			"type"=>"input",
			"title" => "Link",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter slider link.</div>"),	
		"slider_link_text" => array(
			"name" => "slider_link_text",
			"std" => "",
			"type"=>"input",
			"title" => "Link text",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter slider slider link text.</div>"),		
		"slider_menu_item" => array(
			"name" => "slider_menu_item",
			"std" => "",
			"type"=>"input",
			"title" => "Menu item",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter slider slider menu item text.</div>"),	
	);
	$this->cpt_init();

}



} // End class
new Slider;

