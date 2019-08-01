<?php 


class Barometer extends cpt_post_types_parent {

public $cpt_name = "Barometer";
public $cpt_id = "barometer";
public $cpt_dashicon = "dashicons-chart-line";
public $public = true;




function __construct(){

	$this->taxonomies = array(		
		"year_barometer" => array(
			"id" => "year_barometer",
			"name" => "Year"
		),			
		"doc_type" => array(
			"id" => "doc_type",
			"name" => "Type"
		)				
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
	);
	$this->cpt_init();

	add_filter( 'query_vars', array($this, 'barometer_register_query_vars') );
	add_action('init', array($this, 'barometer_rewrite_tag_rule'), 10, 0);
	add_action( 'pre_get_posts', array($this, 'barometer_pre_get_posts'), 1 );		

}

function barometer_register_query_vars( $vars ) {
	$vars[] = 'ybar';
	$vars[] = 'btype';
	return $vars;
}

function barometer_rewrite_tag_rule() {

	add_rewrite_tag( '%ybar%', '([^&]+)' );
	add_rewrite_rule( '^ybar/([^/]*)/?', 'index.php?ybar=$matches[1]','top' );

	add_rewrite_tag( '%btype%', '([^&]+)' );
	add_rewrite_rule( '^btype/([^/]*)/?', 'index.php?btype=$matches[1]','top' );
}

function barometer_pre_get_posts( $query ) {
	// check if the user is requesting an admin page 
	// or current query is not the main query
	if ( is_admin() || ! $query->is_main_query() ){
		return;
	}

	if('barometer' != $query->query['post_type']) {
		return;
	}	

	$ybar = get_query_var( 'ybar' );
	$btype = get_query_var( 'btype' );

    $tax_query = array('relation' => 'AND');


	// add tax_query elements
	if( !empty( $ybar ) ){
		$tax_query[] = array(
			'taxonomy' => 'year_barometer',
			'field'    => 'slug',
			'terms'    => $ybar,	
		);
	}

	if( !empty( $btype ) ){
		$query->set( 'order', 'ASC');
		$tax_query[] = array(
			'taxonomy' => 'doc_type',
			'field'    => 'slug',
			'terms'    => $btype,	
		);
	}

	// add tax_query ele
	$query->set( 'tax_query', $tax_query);
}



} // End class
new Barometer;

