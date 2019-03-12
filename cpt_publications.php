<?php 


class Publications extends cpt_post_types_parent {

public $cpt_name = "Publications";
public $cpt_id = "publications";
public $cpt_dashicon = "dashicons-book-alt";
public $public = true;




function __construct(){
	
	$this->meta_boxes = array(			
		"publication_date" => array(
			"name" => "publication_date",
			"std" => "",
			"type"=>"date",
			"title" => "Published",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter publication date.</div>"),				
		"publisher" => array(
			"name" => "publisher",
			"std" => "",
			"type"=>"input",
			"title" => "Publisher",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter publisher's name.</div>"),				
		"file" => array(
			"name" => "file",
			"std" => "",
			"type"=>"media",
			"title" => "File",
			"description" => "<div style='padding:0 0 10px 190px;'>Enter publication file.</div>"),			
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
new Publications;




