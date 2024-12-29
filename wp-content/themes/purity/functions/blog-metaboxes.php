<?php
$prefix = 'pp_';

$meta_blog_images = array(
    'id' => 'blog-images',
    'title' => 'Post Gallery',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
    	array(
    	    'name' => 'Gallery Type',
    	    'id' => $prefix . 'gallery_type',
    	    'type' => 'radio',
    	    'options' => array(
    	    	array('name' => 'Lightbox', 'value' => 'lightbox'),
    	        array('name' => 'Direct Lightbox', 'value' => 'direct'),    	        
    	        array('name' => 'Slider', 'value' => 'slider'),
    	    ),
    	    'std' => '1'
    	),
        array(
            'name' => 'Image 1:',
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
        )
    )
);

add_action('admin_menu', 'blog_add_box');

// Add meta box
function blog_add_box() {
    global $meta_blog_images;

    add_meta_box($meta_blog_images['id'], $meta_blog_images['title'], 'blog_show_box', $meta_blog_images['page'], $meta_blog_images['context'], $meta_blog_images['priority']);
}

	
// Callback function to show fields in meta box
function blog_show_box() {
    global $meta_blog_images, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="blog_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_blog_images['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
                '<th style="width:18%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
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
			case 'heading':
				echo 'The first image of the lightbox gallery is the "Post Thumbnail" image. Leave the following fields blank to disable Lightbox.';
                break;
            
        }
        echo     '<td>',
            '</tr>';
    }

    echo '</table>';
}

add_action('save_post', 'blog_save_data');

// Save data from meta box
function blog_save_data($post_id) {
    global $meta_blog_images;

    // verify nonce
    if (!wp_verify_nonce($_POST['blog_meta_box_nonce'], basename(__FILE__))) {
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

    foreach ($meta_blog_images['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}	