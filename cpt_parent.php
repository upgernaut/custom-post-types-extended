<?php 

class cpt_post_types_parent {

public $postId;
public $meta_boxes = array();
public $cpt_name;
public $cpt_id;
public $cpt_dashicon;

public $taxonomy_id;
public $taxonomy_name;

public $taxonomies = array();

public $public = true;

public function __construct() {
	
}

public function cpt_init() {
	add_action( 'init', array($this,'customPostType_cpt_cpt_post_types_parent'));
	add_action('admin_menu', array($this, 'create_meta_box'));	
	add_action('save_post', array($this, 'save_postdata'));	
	
	
	if(isset($this->taxonomies) && !empty($this->taxonomies)) {
		add_action( 'init', array($this, 'create_taxonomy'), 0 );
		// add_action( 'init', array($this, 'show_taxonomy'), 30 );
		add_action( 'restrict_manage_posts', array($this, 'filter_cars_by_taxonomies') , 10, 2);
	}


	if(isset($this->options) && !empty($this->options)) {
		add_action( 'admin_menu', array($this, 'cpt_submenu') );
	}	


}

public function filter_cars_by_taxonomies( $post_type, $which ) {

	// Apply this only on a specific post type
	if ( $this->cpt_id !== $post_type )
		return;

	// A list of taxonomy slugs to filter by

	$taxonomies = array_keys($this->taxonomies);

	foreach ( $taxonomies as $taxonomy_slug ) {

		// Retrieve taxonomy data
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );
		$taxonomy_name = $taxonomy_obj->labels->name;

		// Retrieve taxonomy terms
		$terms = get_terms( $taxonomy_slug );

		// Display filter HTML
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}

}

// Custom Post Type - cpt_post_types_parent
public function customPostType_cpt_cpt_post_types_parent() {
 
    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( $this->cpt_name, 'Post Type General Name', 'cpt' ),
            'singular_name'       => _x( $this->cpt_name, 'Post Type Singular Name', 'cpt' ),
            'menu_name'           => __( $this->cpt_name, 'cpt' ),
            'parent_item_colon'   => __( 'Parent', 'cpt' ),
            'all_items'           => __( 'All', 'cpt' ),
            'view_item'           => __( 'View', 'cpt' ),
            'add_new_item'        => __( 'Add New', 'cpt' ),
            'add_new'             => __( 'Add New', 'cpt' ),
            'edit_item'           => __( 'Edit', 'cpt' ),
            'update_item'         => __( 'Update', 'cpt' ),
            'search_items'        => __( 'Search', 'cpt' ),
            'not_found'           => __( 'Not Found', 'cpt' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'cpt' ),
        );
         
    // Set other options for Custom Post Type
        $args = array(
            'label'               => __( $this->cpt_name, 'cpt' ),
            'description'         => __( $this->cpt_name, 'cpt' ),
            'labels'              => $labels,
			'supports'            => array( 'title', 'custom-fields', 'editor', 'thumbnail' ),
            'taxonomies'          => array(),
            'hierarchical'        => false,
            'public'              => $this->public,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'show_in_rest'   	  => true,
            'menu_position'       => 5,
            'menu_icon'       => $this->cpt_dashicon,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
			// dashicons-admin-tools
        );
         
        // Registering the Custom Post Type
        register_post_type( $this->cpt_id, $args );
     
    }
    

//Setup Custom Fields Start
		 
public function new_meta_boxes() {
    global $post;
	
    foreach ($this->meta_boxes as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);
		
        if($meta_box_value == "") {
            $meta_box_value = $meta_box['std']; 
		}
		if(isset($meta_box['type']) && $meta_box['type'] == 'textarea')
		{
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
			echo'<table width="100%"><tbody>';
			echo'<tr><td align="right" style="width: 184px;"><strong>'.$meta_box['title'].' - </strong></td>';
			echo'<td><textarea style="width:100%;height:100px;border:1px solid black" name="'.$meta_box['name'].'">'.$meta_box_value.'</textarea></td></tr>';
			echo'</tbody></table>';
			echo'<label for="'.$meta_box['name'].'">'.$meta_box['description'].'</label>';		
		}
		else if(isset($meta_box['type']) && $meta_box['type'] == 'input')
		{
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
			echo'<table width="100%"><tbody>';
			echo'<tr><td align="right" style="width: 184px;"><strong>'.$meta_box['title'].' - </strong></td>';
			echo'<td><input type="text/number" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" style="width: 100%;" /></td></tr>';
			echo'</tbody></table>';
			echo'<label for="'.$meta_box['name'].'">'.$meta_box['description'].'</label>';
		}		
		else if(isset($meta_box['type']) && $meta_box['type'] == 'date')
		{
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
			echo'<table width="100%"><tbody>';
			echo'<tr><td align="right" style="width: 184px;"><strong>'.$meta_box['title'].' - </strong></td>';
			echo'<td><input type="date" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" style="width: 100%;" /></td></tr>';
			echo'</tbody></table>';
			echo'<label for="'.$meta_box['name'].'">'.$meta_box['description'].'</label>';
		}		
		else if(isset($meta_box['type']) && $meta_box['type'] == 'checkbox')
		{
			$checked = ($meta_box_value) ? 'checked="checked"' : "" ;
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
			echo'<table width="100%"><tbody>';
			echo'<tr><td align="right" style="width: 184px;"><strong>'.$meta_box['title'].' - </strong></td>';
			echo'<td><input type="checkbox" name="'.$meta_box['name'].'" value="1" '. $checked .' /></td></tr>';
			echo'</tbody></table>';
			echo'<label for="'.$meta_box['name'].'">'.$meta_box['description'].'</label>';		
		}
		else if(isset($meta_box['type']) && $meta_box['type'] == 'dropdown')
		{
			
			if(isset($meta_box['dropdown-qty']) && $meta_box['dropdown-qty'] == 'multiple') {
				
				$dropdown = "<select multiple name='{$meta_box[name]}[]'   style='width: 100%;'>";	
				
				foreach($meta_box['values'] as $key => $mbvalue)
				{
					if(is_array($meta_box_value)) {	
						$selected = (in_array($mbvalue,$meta_box_value)) ? 'selected="selected"' : "" ;
					}
					
					if(!is_numeric($key)) {
						$dropdown .= "<option value='{$mbvalue}' {$selected}>{$key}</option>";
					} else {
						$dropdown .= "<option {$selected}>{$mbvalue}</option>";
					}
					
				}			
			} else {

				$dropdown = "<select name='{$meta_box['name']}'   style='width: 100%;'>";
				foreach($meta_box['values'] as  $key => $mbvalue)
				{

					$selected = ($meta_box_value == $mbvalue) ? 'selected="selected"' : "" ;
					
					if(!is_numeric($key)) {
						$dropdown .= "<option value='{$mbvalue}' {$selected}>{$key}</option>";
					} else {
						$dropdown .= "<option {$selected}>{$mbvalue}</option>";
					}
				}				
			}
			

			$dropdown .= '</select>';
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
			echo'<table width="100%"><tbody>';
			echo'<tr><td align="right" style="width: 184px;"><strong>'.$meta_box['title'].' - </strong></td>';
			echo'<td>'.$dropdown.'</td></tr>';
			echo'</tbody></table>';
			echo'<label for="'.$meta_box['name'].'">'.$meta_box['description'].'</label>';		
		}

		else if(isset($meta_box['type']) && $meta_box['type'] == 'dropdown-table')
		{
			
			if(isset($meta_box['dropdown-qty']) && $meta_box['dropdown-qty'] == 'multiple') {
				
				$dropdown = "<select multiple name='{$meta_box[name]}[]'   style='width: 100%;'>";	
				
				foreach($meta_box['values'] as $key => $mbvalue)
				{
					if(is_array($meta_box_value)) {		
						$selected = (in_array($mbvalue['name'],$meta_box_value)) ? 'selected="selected"' : "" ;
					} else {
						$selected = "";
					}
					
					if(!is_numeric($key)) {
						$dropdown .= "<option value='{$mbvalue[name]}' {$selected}>{$key}</option>";
					} else {
						$dropdown .= "<option {$selected}>{$mbvalue[name]}</option>";
					}
					
				}

				$dropdown .= '</select>';
				echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
				echo'<table width="100%"><tbody>';
				echo'<tr><td align="right" style="width: 184px;"><strong>'.$meta_box['title'].' - </strong></td>';
				echo'<td>'.$dropdown.'</td></tr>';
				echo'</tbody></table>';
				
				
				echo'<table width="100%"><tbody>';	
					echo'<tr><td align="right" style="width: 184px;"><strong></strong></td>';
					echo'<td><ul style="list-style:none;">'; 				
					foreach($meta_box['values'] as $key => $mbvalue)
					{
						if(is_array($meta_box_value)) {	
							if(in_array($mbvalue['name'],$meta_box_value)) {
								if(!is_numeric($key)) {
									echo "<li>{$key}</li>";
								} else {
									echo "<li><a target='_blank' href='{$mbvalue[link]}'>{$mbvalue[name]}</a></li>";
								}
							}
						}
						
					}				
				echo'</ul></td></tr></tbody></table>';	
				echo'<label for="'.$meta_box['name'].'">'.$meta_box['description'].'</label>';	
				
			} else {
				$dropdown = "<select name='{$meta_box[name]}'   style='width: 100%;'>";
				foreach($meta_box['values'] as  $key => $mbvalue)
				{
					
					if(is_array($meta_box_value)) {	
						$selected = (in_array($mbvalue['name'],$meta_box_value)) ? 'selected="selected"' : "" ;
					} else {
						$selected = "";
					}

					
					if(!is_numeric($key)) {
						$dropdown .= "<option value='{$mbvalue[name]}' {$selected}>{$key}</option>";
					} else {
						$dropdown .= "<option {$selected}>{$mbvalue[name]}</option>";
					}
				}

				$dropdown .= '</select>';
				echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
				echo'<table width="100%"><tbody>';
				echo'<tr><td align="right" style="width: 184px;"><strong>'.$meta_box['title'].' - </strong></td>';
				echo'<td>'.$dropdown.'</td></tr>';
				echo'</tbody></table>';
				
				echo'<table width="100%"><tbody>';	
					echo'<tr><td align="right" style="width: 184px;"><strong></strong></td>';
					echo'<td><ul style="list-style:none;">'; 				
					foreach($meta_box['values'] as $key => $mbvalue)
					{
						if(is_array($meta_box_value)) {	
							if(in_array($mbvalue['name'],$meta_box_value)) {
								if(!is_numeric($key)) {
									echo "<li>{$key}</li>";
								} else {
									echo "<li><a target='_blank' href='{$mbvalue[link]}'>{$mbvalue[name]}</a></li>";
								}
							}
						}
						
					}				
				echo'</ul></td></tr></tbody></table>';	
				echo'<label for="'.$meta_box['name'].'">'.$meta_box['description'].'</label>';	
								
			}
			

	
		}		
    }
}

public function create_meta_box() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'new-meta-boxes', 'Details', array($this,'new_meta_boxes'), $this->cpt_id, 'normal', 'high' );
    }
}

public function save_postdata( $post_id ) {
	global $post;
	

	foreach($this->meta_boxes as $meta_box) 
	{
		// Verify
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
		return $post_id;
		}
 
        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ))
				return $post_id;
            } else {
				if ( !current_user_can( 'edit_post', $post_id ))
				return $post_id;
            }
 
            $data = $_POST[$meta_box['name']];
 
            if(get_post_meta($post_id, $meta_box['name']) == "")
				add_post_meta($post_id, $meta_box['name'], $data, true);
            elseif($data != get_post_meta($post_id, $meta_box['name'], true))
				update_post_meta($post_id, $meta_box['name'], $data);
            elseif($data == "")
				delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
	}
}

function show_taxonomy() {
	foreach($this->taxonomies as $single_taxonomy) {
		
		$taxonomy = get_taxonomy( $single_taxonomy['id']  );

		$taxonomy->show_in_rest = true;

	}
}



	public function create_taxonomy() {

		foreach($this->taxonomies as $single_taxonomy) {

		  $labels = array(
			'name' => _x( $single_taxonomy['name'], 'cpt' ),
			'singular_name' => _x( $single_taxonomy['name'], 'cpt' ),
			'search_items' =>  __( 'Search', 'cpt' ),
			'all_items' => __( 'All', 'cpt' ),
			'parent_item' => __( 'Parent', 'cpt' ),
			'parent_item_colon' => __( 'Parent:', 'cpt' ),
			'edit_item' => __( 'Edit', 'cpt' ), 
			'update_item' => __( 'Update', 'cpt' ),
			'add_new_item' => __( 'Add New', 'cpt' ),
			'new_item_name' => __( 'New', 'cpt' ),
			'menu_name' => __( '- ' . $single_taxonomy['name'], 'cpt' ),
		  ); 	

		// Now register the taxonomy

		  register_taxonomy($single_taxonomy['id'], array($this->cpt_id), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'show_in_rest' => true,
			// 'rest_base'    => 'category',
			// 'rest_controller_class' => 'WP_REST_Terms_Controller',	
			'rewrite' => array( 'slug' => $single_taxonomy['id'] ),
		  ));

		}
	}


	// Custom page for custom post type
	/**
	 * Register page settings submenu
	 */
	public function cpt_submenu() {
	 
	   // Add the menu to the existing tab
	   $page = add_submenu_page( 'edit.php?post_type='.$this->cpt_id, __( 'Content', 'theme' ), __( 'Content', 'theme' ), 'edit_posts', 'cpt-'.$this->cpt_id.'-content', array($this, 'cpt_content_page') );
	 
	   // For loading the page so the submitted data can be saved
	   add_action( 'load-' . $page, array($this, 'cpt_content_page_load')  );
	 
	}


	public function cpt_content_page() { 

		?>
	 
	    <div class="wrap">
	 
	        <h2><?php echo $this->cpt_name; ?> settings</h2>
	 
	        <?php
	        if ( isset( $_GET['updated'] ) && esc_attr( $_GET['updated'] ) == 'true' )
	            echo '<div class="updated"><p>' . __( 'Content updated successfully', 'theme' ) . '</p></div>';
	        ?>
	 
	        <form method="post" action="<?php admin_url( 'edit.php?post_type='.$this->cpt_id.'&page='.$this->cpt_id.'-page-content' ); ?>">
	 
	            <table class="form-table">

					<?php foreach($this->options as $option): ?>
						<?php if($option['type'] == 'input'): ?>
			                <tr>
			                    <th><label for="<?php echo $this->cpt_id; ?>_<?php echo $option['name']; ?>"><?php echo $option['title']; ?>:</label></th>
			                    <td><input type="text" name="data[<?php echo $option['name']; ?>]" id="<?php echo $this->cpt_id; ?>_<?php echo $option['name']; ?>" class="regular-text" value="<?php echo $this->cpt_custom_content( $this->cpt_id, $option['name']); ?>"></td>
			                </tr>							
						<?php elseif($option['type'] == 'editor'): ?>
			                <tr>
			                    <th><label for="<?php echo $this->cpt_id; ?>_<?php echo $option['name']; ?>"><?php echo $option['title']; ?>:</label></th>
			                    <td><?php wp_editor( $this->cpt_custom_content( $this->cpt_id, $option['name'] ), $this->cpt_id . '_' .$option['name'], ['textarea_name' => 'data['.$option['name'].']'] ); ?></td>
			                   
			                </tr>							
						<?php endif; ?>
					<?php endforeach;?> 	 

	            </table><!--End .form-table-->
	 
	            <?php submit_button( __( 'Save', 'theme' ), 'primary', 'submit', false ); ?>
	 
	        </form>
	 
	    </div><!--End .wrap-->
	 
	    <?php
	}

	/**
	 * Loads page content menu page
	 *
	 * Stores the post type data submitted by the form.
	 */
	public function cpt_content_page_load() {
	 
	   // If form submitted
	   if ( isset( $_POST['submit'] ) )  {
	 
	      if ( ! empty( $_POST['data'] ) ) {
	 
	         $data = [];
	 
	         // Loop trough the submitted field
	         foreach ( $_POST['data'] as $key => $value ) {
	            if ( ! empty( $_POST['data'][$key] ) ) {
	               if ( 'content' == $key ) {
	                  // Stripslashes because of the wp editor
	                  $data[$key] = stripslashes_deep( $_POST['data'][$key] );
	               } else {
	                  $data[$key] = $_POST['data'][$key];
	               }
	            }
	         }
	 
	         // Update option
	         if ( ! empty( $data ) )
	         update_option( 'cpt_'.$this->cpt_id.'_content', $data );
	      }
	 
	      // Redirect back to content page
	      $redirect = admin_url( 'edit.php?post_type='.$this->cpt_id.'&page=cpt-'.$this->cpt_id.'-content&updated=true' );
	      wp_redirect( $redirect );
	      exit;
	   }
	}


	/**
	 * Get custom post type custom content
	 */
	function cpt_custom_content( $post_type = '', $field = 'content' ) {
		$post_type = $this->cpt_id;

	   if ( isset( $post_type ) ) {
	      $data = get_option( 'cpt_' . $post_type . '_content' );
	      if ( ! empty( $data[$field] ) ) {
	         return $data[$field];
	      }
	   }
	   return false;
	}		
		


}

new cpt_post_types_parent;