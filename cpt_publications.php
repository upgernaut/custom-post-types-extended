<?php 


class Publications extends cpt_post_types_parent {

public $cpt_name = "Publications";
public $cpt_id = "publications";
public $cpt_dashicon = "dashicons-book-alt";
public $public = true;




function __construct(){

	$this->options = array(
		"hint" => array(
			"name" => "hint",
			"std" => "",
			"type"=>"textarea",
			"title" => "Hint for 'submit a publication'"),
	);		
	
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
			"description" => "<div style='padding:0 0 10px 190px;'>Enter publication file.</div>")	
	);
	$this->cpt_init();

	add_filter( 'query_vars', array($this, 'publications_register_query_vars') );
	add_action('init', array($this, 'publications_rewrite_tag_rule'), 10, 0);
	add_action( 'pre_get_posts', array($this, 'publications_pre_get_posts'), 1 );	

}

function publications_register_query_vars( $vars ) {
	$vars[] = 'publisher';
	$vars[] = 'publication_date';
	return $vars;
}

function publications_rewrite_tag_rule() {

	add_rewrite_tag( '%publisher%', '([^&]+)' );
	add_rewrite_rule( '^publisher/([^/]*)/?', 'index.php?publisher=$matches[1]','top' );

	add_rewrite_tag( '%publication_date%', '([^&]+)' );
	add_rewrite_rule( '^publication_date/([^/]*)/?', 'index.php?publication_date=$matches[1]','top' );
}

function publications_pre_get_posts( $query ) {
	// check if the user is requesting an admin page 
	// or current query is not the main query
	if ( is_admin() || ! $query->is_main_query() ){
		return;
	}

	if('publications' != $query->query['post_type']) {
		return;
	}	
	
	$publisher = get_query_var( 'publisher' );
	$publication_date = get_query_var( 'publication_date' );

    $meta_query = array('relation' => 'AND');
	// add meta_query elements
	if( !empty( $publisher ) ){
		$meta_query[] = array(
			'key'=>'publisher',
			'value'=>$publisher,
			'compare'=>'LIKE',

		);
	}

	// add meta_query elements
	if( !empty( $publication_date ) ){
		$meta_query[] = array(
			'key'=>'publication_date',
			'value'=>$publication_date,
			'compare'=>'LIKE',
		);
	}

	$query->set( 'meta_query', $meta_query);
}


} // End class
new Publications;




