<?php 


class FAQ extends cpt_post_types_parent {

public $cpt_name = "FAQ";
public $cpt_id = "faq";
public $cpt_dashicon = "dashicons-editor-help";
public $public = false;




function __construct(){

	$this->supports = array( 'title');

	
	$this->meta_boxes = array(	
		"question" => array(
			"name" => "question",
			"std" => "",
			"type"=>"editor",
			"title" => "Question",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter faq question.</div>"),	
		"answer" => array(
			"name" => "answer",
			"std" => "",
			"type"=>"editor",
			"title" => "Answer",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter faq answer.</div>"),
	);
	$this->cpt_init();

}



} // End class
new FAQ;

