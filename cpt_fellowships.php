<?php 


class Fellowships extends cpt_post_types_parent {

public $cpt_name = "Fellowships";
public $cpt_id = "fellowships";
public $cpt_dashicon = "dashicons-index-card";
public $public = true;




function __construct(){

	$this->taxonomies = array(		
		"felowship_category" => array(
			"id" => "felowship_category",
			"name" => "Category"
		),			
		"felowship_year" => array(
			"id" => "felowship_year",
			"name" => "Year"
		),		
	);		

	$this->meta_boxes = array(			
		"fellows" => array(
			"name" => "fellows",
			"std" => "",
			"type"=>"dropdown",
			"title" => "Fellows",      
			"dropdown-qty" => "multiple",      
			"values" => array(),
			"description" => "Choose participating fellows, press <strong><i>ctrl</i></strong> to choose multiple."),
	);
	add_action( 'admin_init', array($this,'get_fellows'));
	$this->cpt_init();


	add_filter( 'query_vars', array($this, 'fellowships_register_query_vars') );
	add_action('init', array($this, 'fellowships_rewrite_tag_rule'), 10, 0);
	add_action( 'pre_get_posts', array($this, 'fellowships_pre_get_posts'), 1 );

}



public function get_fellows() {
	$type = 'people';
	$args=array(
		'post_type' => $type,
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'order_by' => 'title',
		'order' => 'desc'

	);
	$my_query = null;
	$my_query = new WP_Query($args);
	if( $my_query->have_posts() ) {
		
		while ($my_query->have_posts()) : $my_query->the_post(); 
		
			$slug = get_post_field( 'post_name', get_the_ID() );
			$this->meta_boxes['fellows']['values'][get_the_title()] = $slug;
			
		endwhile;
	}

	$my_query->wp_reset_query();  
	$my_query->wp_reset_postdata();
}




function fellowships_register_query_vars( $vars ) {
	$vars[] = 'fellowships_cat';
	$vars[] = 'fellowships_year';
	return $vars;
}

function fellowships_rewrite_tag_rule() {

	add_rewrite_tag( '%fellowships_cat%', '([^&]+)' );
	add_rewrite_rule( '^fellowships_cat/([^/]*)/?', 'index.php?fellowships_cat=$matches[1]','top' );

	add_rewrite_tag( '%fellowships_year%', '([^&]+)' );
	add_rewrite_rule( '^fellowships_year/([^/]*)/?', 'index.php?fellowships_year=$matches[1]','top' );
}

function fellowships_pre_get_posts( $query ) {
	// check if the user is requesting an admin page 
	// or current query is not the main query
	if ( is_admin() || ! $query->is_main_query() ){
		return;
	}

	if('fellowships' != $query->query['post_type']) {
		return;
	}	
	
	$fellowships_cat = get_query_var( 'fellowships_cat' );
	$fellowships_year = get_query_var( 'fellowships_year' );

    $tax_query = array('relation' => 'AND');


	// add tax_query elements
	if( !empty( $fellowships_year ) ){
		$tax_query[] = array(
			'taxonomy' => 'felowship_year',
			'field'    => 'slug',
			'terms'    => $fellowships_year,	
		);
	}



	if( !empty( $fellowships_cat ) ){
		$query->set( 'order', 'ASC');
		$tax_query[] = array(
			'taxonomy' => 'felowship_category',
			'field'    => 'slug',
			'terms'    => $fellowships_cat,
		);
	}

	// add tax_query ele
	$query->set( 'tax_query', $tax_query);
}



} // End class
new Fellowships;


