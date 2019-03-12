<?php 


class Barometer extends cpt_post_types_parent {

public $cpt_name = "Barometer";
public $cpt_id = "barometer";
public $cpt_dashicon = "dashicons-chart-line";
public $public = true;




function __construct(){

	$this->taxonomies = array(		
		"year" => array(
			"id" => "year",
			"name" => "Year"
		),			
		"doc_type" => array(
			"id" => "doc_type",
			"name" => "Type"
		),		
	);		

	$this->options = array(
		"description" => array(
			"name" => "description",
			"std" => "",
			"type"=>"editor",
			"title" => "Page description",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter page descripton.</div>"),
		"citation" => array(
			"name" => "citation",
			"std" => "",
			"type"=>"editor",
			"title" => "Citation",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter citation.</div>"),
	);	
	
	$this->meta_boxes = array(	
		"file" => array(
			"name" => "file",
			"std" => "",
			"type"=>"media",
			"title" => "File",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter barometer file.</div>"),			
		"filetype" => array(
			"name" => "filetype",
			"std" => "",
			"type"=>"dropdown",
			"title" => "File Type",      
			"values" => array("","PDF","DOC","DOCX","XLS","XLSX","JPG","PNG"),
			"description" => "<div style='padding:0 0 10px 190px;'>Please enter the file type in order to show it as an icon.</div>"),	
	);
	$this->cpt_init();

}



} // End class
new Barometer;

