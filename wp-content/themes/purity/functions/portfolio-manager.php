<?php

// Thumbnails

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 280, 210, true ); // Normal post thumbnails
	add_image_size( 'screen-shot', 720, 540 ); // Full size screen
}

// New Post Type

add_action('init', 'portfolio_register');  

function portfolio_register() {
    $args = array(
        'label' => __('Portfolio'),
        'singular_label' => __('Project'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array('title', 'editor')
       );  

    register_post_type( 'portfolio' , $args );
}

add_action('admin_menu', 'remove_niggly_bits');
function remove_niggly_bits() {
    global $submenu;
   unset($submenu['edit.php?post_type=page'][15]);

}

register_taxonomy(
	"project-type", 
	array("portfolio","page"), 
	array(
		"hierarchical" => true, 
		"context" => "normal", 
		'show_ui' => true,
		"label" => "Portfolio Categories", 
		"singular_label" => "Portfolio Category", 
		"rewrite" => true
	)
);

// Portfolio Description

add_action("admin_init", "portfolio_meta_box");   

function portfolio_meta_box(){
    add_meta_box("projInfo-meta", "Portfolio Post Settings", "portfolio_meta_options", "portfolio", "normal", "high");
}   

function portfolio_meta_options(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $layout = $custom["projLayout"][0];
		$desc = $custom["projDesc"][0];
?>
    <table class="form-table">
    <tr>
    	<td style="width:10%">Layout:</td>
    	<td>
    		<input type="radio" name="projLayout" value="sidebar-right" <?php if($layout == "sidebar-right" || !$layout) echo "checked"; ?>>Sidebar Right<br>
			<input type="radio" name="projLayout" value="sidebar-left" <?php if($layout == "sidebar-left") echo "checked"; ?>>Sidebar Left<br>
			<input type="radio" name="projLayout" value="fullwidth" <?php if($layout == "fullwidth") echo "checked"; ?>>Fullwidth
    	</td>
    </tr>
    <tr>
    	<td style="width:10%">Project description:</td>
    	<td ><textarea type="text" name="projDesc" cols="60" rows="4" /><?php echo $desc; ?></textarea></td>
    </tr>
    </table>
<?php
    }
	
// Portfolio Video

add_action("admin_init", "portfolio_video_box");   

function portfolio_video_box(){
    add_meta_box("projVideo-meta", "Video", "portfolio_video_options", "portfolio", "side", "low");
}   

function portfolio_video_options(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
		$video_youtube = $custom["video_youtube"][0];
		$video_vimeo = $custom["video_vimeo"][0];
		$vlightbox_width = $custom["vlightbox_width"][0];
		$vlightbox_height = $custom["vlightbox_height"][0];
?>
	<table class="form-table">
	<td>Pasting a video ID in one of the following fields will replace the images on the portfolio post page. <br /> Vimeo replaces the YouTube video if both filled.</td>
    </table>
    <table class="form-table">
    <tr>
    <td style="width:10%"><label for="video_youtube">YouTube ID:</label></td>
    <td><input type="text" name="video_youtube" value="<?php echo $video_youtube; ?>" size="30" style="width:60%" /></td>
    </tr>
    <tr>
    <td style="width:10%"><label for="video_youtube">Vimeo ID:</label></td>
    <td><input type="text" name="video_vimeo" value="<?php echo $video_vimeo; ?>" size="30" style="width:60%" /></td>
    </tr>
    <table class="form-table">
	<td>Settings below concern a size of the video opened in a lightbox (Direct Lightbox).</td>
    </table>
    <table class="form-table">
    <tr>
    <td style="width:10%"><label for="vlightbox_width">Lightbox Video Width:</label></td>
    <td><input type="text" name="vlightbox_width" value="<?php echo $vlightbox_width; ?>" size="30" style="width:60%" /></td>
    </tr>
    <tr>
    <td style="width:10%"><label for="vlightbox_height">Lightbox Video Height:</label></td>
    <td><input type="text" name="vlightbox_height" value="<?php echo $vlightbox_height; ?>" size="30" style="width:60%" /></td>
    </tr>
   
    </table>
<?php
    }

// Page Tagline

add_action("admin_init", "page_tagline_box");   

function page_tagline_box(){
    add_meta_box("pageInfo-meta", "Additional Page Attributes", "page_tagline_options", "page", "normal", "low");
}

function page_tagline_options(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
		$tagline = $custom["page-tagline"][0];
?>	
    <table class="form-table">
    <tr>
    <td style="width:20%"><label for="page-tagline">Optional page tagline:</label></td>
    <td><input type="text" name="page-tagline" value="<?php echo $tagline; ?>" size="30" style="width:60%" /></td>    
    </tr>
    </table>  
<?php
    }
	
// Saving the Custom Data

add_action('save_post', 'save_project_link'); 

function save_project_link(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
		update_post_meta($post->ID, "projLayout", $_POST["projLayout"]);
		update_post_meta($post->ID, "projDesc", $_POST["projDesc"]);
		update_post_meta($post->ID, "video_vimeo", $_POST["video_vimeo"]);	
		update_post_meta($post->ID, "video_youtube", $_POST["video_youtube"]);		
		update_post_meta($post->ID, "vlightbox_width", $_POST["vlightbox_width"]);
		update_post_meta($post->ID, "vlightbox_height", $_POST["vlightbox_height"]);
		update_post_meta($post->ID, "page-tagline", $_POST["page-tagline"]);
    }

}	

	
$prefix = 'pp_';

$meta_box = array(
    'id' => 'my-meta-box',
    'title' => 'Images',
    'page' => 'portfolio',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Gallery Type',
            'id' => $prefix . 'gallery_type',
            'type' => 'radio',
            'options' => array(
                array('name' => 'Direct Lightbox', 'value' => 'direct'),
                array('name' => 'Lightbox', 'value' => 'lightbox'),
                array('name' => 'Slider', 'value' => 'slider'),
                array('name' => 'Images List', 'value' => 'list'),
            ),
            'std' => 'lightbox'
        ),
        array(
            'name' => 'Image 1: <span>(Thumb)</span>',
            'id' => $prefix . 'image-1',
            'type' => 'upload',
			'std' => ''
        ),
        array(
            'name' => 'Just thumbnail?',
            'id' => $prefix . 'just_thumb',
            'type' => 'checkbox',
            'std' => '0'
        ),
        array(
            'name' => 'Image 2:',
            'id' => $prefix . 'image-2',
            'type' => 'upload',
			'std' => ''
        ),
        array(
            'name' => 'Image 3:',
            'id' => $prefix . 'image-3',
            'type' => 'upload',
			'std' => ''
        ),
        array(
            'name' => 'Image 4:',
            'id' => $prefix . 'image-4',
            'type' => 'upload',
			'std' => ''
        ),
        array(
            'name' => 'Image 5:',
            'id' => $prefix . 'image-5',
            'type' => 'upload',
			'std' => ''
        ),
        array(
            'name' => 'Image 6:',
            'id' => $prefix . 'image-6',
            'type' => 'upload',
			'std' => ''
        ),
        array(
            'name' => 'Image 7:',
            'id' => $prefix . 'image-7',
            'type' => 'upload',
			'std' => ''
        ),
		array(
            'name' => 'Image 8:',
            'id' => $prefix . 'image-8',
            'type' => 'upload',
			'std' => ''
        ),
        array(
            'name' => 'Image 9:',
            'id' => $prefix . 'image-9',
            'type' => 'upload',
        	'std' => ''
        ),
        array(
            'name' => 'Image 10:',
            'id' => $prefix . 'image-10',
            'type' => 'upload',
        	'std' => ''
        )
    )
);

add_action('admin_menu', 'mytheme_add_box');

// Add meta box
function mytheme_add_box() {
    global $meta_box;

    add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

	
// Callback function to show fields in meta box
function mytheme_show_box() {
    global $meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
                '<td style="width:18%"><label for="', $field['id'], '">', $field['name'], '</label></td>',
                '<td>';
        switch ($field['type']) {
			case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' /><span>Check to use the "Image 1" only as a thumbnail</span>';
                break;
            case 'radio':
               foreach ($field['options'] as $option) {
               		
                   echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] || $option['value'] == "lightbox" && !$meta ? ' checked="checked"' : '', ' />', $option['name'].'<br>';
               }
               break;
			case 'upload':
                echo '<input id="', $field['id'], '" class="upload_image" type="text" size="30" name="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" style="width:60%" />';
                echo '<input id="upload_image_button" class="button upload_image_button" name="', $field['id'], '" type="button" value="Upload Image" />';
                break;
			case 'taxonomy':
                portfolio_cats2();
                break;
            
        }
        echo     '<td>',
            '</tr>';
    }

    echo '</table>';
}

add_action('save_post', 'mytheme_save_data');

// Save data from meta box
function mytheme_save_data($post_id) {
    global $meta_box;

    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}	

// Video functions

function video_height(){	
	global $post;
	$height = get_post_meta($post->ID, 'video_height', true);
	if($height){
		echo $height;
	}else{
		echo "400";
	}
}