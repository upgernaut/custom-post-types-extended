<?php 


class Research extends cpt_post_types_parent {

public $cpt_name = "Research";
public $cpt_id = "research";
public $cpt_dashicon = "dashicons-clipboard";
public $public = true;


function __construct(){


	$this->taxonomies = array(		
		"research_category" => array(
			"id" => "research_category",
			"name" => "Category"
		),			
		"research_status" => array(
			"id" => "research_status",
			"name" => "Status"
		),		
	);		
	
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
			"type"=>"input",
			"title" => "Start Date",
			"description" => "<div style='padding:0 0 10px 190px;'>Format: {numeric month}-{year}, example: <strong>03-2019</strong></div>"),					
		"date_to" => array(
			"name" => "date_to",
			"std" => "",
			"type"=>"input",
			"title" => "Ending Date",
			"description" => "<div style='padding:0 0 10px 190px;'>Format: {numeric month}-{year}, example: <strong>03-2019</strong></div>"),

		// "publication_date" => array(
		// 	"name" => "publication_date",
		// 	"std" => "",
		// 	"type"=>"input",
		// 	"title" => "<hr><br>Research output year",
		// 	"description" => "<div style='padding:0 0 10px 190px;'>Enter research output year.</div>"),				
		// "publisher" => array(
		// 	"name" => "publisher",
		// 	"std" => "",
		// 	"type"=>"input",
		// 	"title" => "Research output publisher",
		// 	"description" => "<div style='padding:0 0 10px 190px;'>Enter research output publisher's name.</div>"),				
		// "file" => array(
		// 	"name" => "file",
		// 	"std" => "",
		// 	"type"=>"media",
		// 	"title" => "Research output file",
		// 	"description" => "<div style='padding:0 0 10px 190px;'>Enter resaearch output file.</div>"),				
		// "research_output_description" => array(
		// 	"name" => "research_output_description",
		// 	"std" => "",
		// 	"type"=>"editor",
		// 	"title" => "Research output description",
		// 	"description" => "<div style='padding:0 0 10px 190px;'>Enter resaearch output description.</div>"),					
		// "appear_in_publications" => array(
		// 	"name" => "appear_in_publications",
		// 	"std" => "",
		// 	"type"=>"checkbox",
		// 	"title" => "Appear in publications",
		// 	"description" => "<div style='padding:0 0 10px 190px;'>Check if you want it to appear in publications page.</div>"),			
	);
	$this->cpt_init();


	add_filter( 'query_vars', array($this, 'research_register_query_vars') );
	add_action('init', array($this, 'research_rewrite_tag_rule'), 10, 0);
	add_action( 'pre_get_posts', array($this, 'research_pre_get_posts'), 1 );

}


function research_register_query_vars( $vars ) {
	$vars[] = 'status';
	$vars[] = 'funder';
	$vars[] = 'country';
	$vars[] = 'research_category';
	$vars[] = 'research_year';
	return $vars;
}

function research_rewrite_tag_rule() {


	add_rewrite_tag( '%status%', '([^&]+)' );
	add_rewrite_rule( '^status/([^/]*)/?', 'index.php?status=$matches[1]','top' );

	add_rewrite_tag( '%funder%', '([^&]+)' );
	add_rewrite_rule( '^funder/([^/]*)/?', 'index.php?funder=$matches[1]','top' );

	add_rewrite_tag( '%country%', '([^&]+)' );
	add_rewrite_rule( '^country/([^/]*)/?', 'index.php?country=$matches[1]','top' );

	add_rewrite_tag( '%research_year%', '([^&]+)' );
	add_rewrite_rule( '^research_year/([^/]*)/?', 'index.php?research_year=$matches[1]','top' );

	add_rewrite_tag( '%r_category%', '([^&]+)' );
	add_rewrite_rule( '^r_category/([^/]*)/?', 'index.php?r_category=$matches[1]','top' );
}

function research_pre_get_posts( $query ) {
	// check if the user is requesting an admin page 
	// or current query is not the main query
	if ( is_admin() || ! $query->is_main_query() ){
		return;
	}

	if('research' != $query->query['post_type']) {
		return;
	}	
	
	$status = get_query_var( 'status' );
	$funder = get_query_var( 'funder' );
	$country = get_query_var( 'country' );
	$research_year = get_query_var( 'research_year' );
	$research_category = get_query_var( 'r_category' );

    $meta_query = array('relation' => 'AND');
    $tax_query = array('relation' => 'AND');

	// add meta_query elements
	if( !empty( $status ) ){
		// $query->set( 'order', 'ASC');
		$tax_query[] = array(
			'taxonomy' => 'research_status',
			'field'    => 'name',
			'terms'    => $status,	
		);
	}	

	// add meta_query elements
	if( !empty( $research_category ) ){
		// $query->set( 'order', 'ASC');
		$tax_query[] = array(
			'taxonomy' => 'research_category',
			'field'    => 'name',
			'terms'    => urldecode($research_category),	
		);
	}	

	// add meta_query elements
	if( !empty( $funder ) ){
		$meta_query[] = array(
			'key'=>'funder',
			'value'=>$funder,
			'compare'=>'LIKE',
		);		
	}

	// add meta_query elements
	if( !empty( $country ) ){
		$meta_query[] = array(
			'key'=>'country',
			'value'=>$country,
			'compare'=>'LIKE',
		);	
	}

	// add meta_query elements
	if( !empty( $research_year ) ){
		$meta_query[] = array(
			'key'=>'date_from',
			'value'=>$research_year,
			'compare'=>'LIKE',
		);
	}

	$query->set( 'meta_query', $meta_query);
	$query->set( 'tax_query', $tax_query);
}



} // End class
new Research;




