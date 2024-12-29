<?php

//
//	Purity Sidebar Manager
//

function sidebar_manager_add() {
	
	$sidebar_manager = add_menu_page('Purity', 'Sidebar Manager', 'administrator','purity_sidebar_manager', 'sidebar_manager_frontend' );	
}

add_action( 'admin_menu', 'sidebar_manager_add' );
 
function sidebarmanager_get_options() {
	return get_option( 'sidebarmanager_options', sidebarmanager_get_default_options() );
}

function sidebarmanager_get_default_options() {
	$default_options = array(
		'custom_sidebar' => array()
	);

	return apply_filters( 'sidebarmanager_default_options', $default_options );
}

function sidebar_manager_frontend() { 
 
?>  
    <div class="wrap">  
        <div id="icon-users" class="icon32"><br></div>
        <h2>Sidebar Manager</h2>  
        <form action="options.php" method="post">  
            <?php wp_nonce_field('update-options') ?>  
            <?php
			
			$themename = "sp";
			// Retrieve theme options  
			$opts = sidebarmanager_get_options();  
		  
			// A bit of jQuery to handle interactions (add / remove sidebars)  
			$output = "<script type='text/javascript'>";  
			$output .= ' 
						var $ = jQuery; 
						$(document).ready(function(){ 
							$(".sidebar_management").on("click", ".delete", function(){ 
								$(this).parents(".menu-item").fadeOut(300, function() { $(this).remove(); }); 
							}); 
		 
							$("#add_sidebar").click(function(){ 
								var new_item = $("<li style=\'display:none\' class=\'menu-item\'><dt class=\'menu-item-bar\'><dt class=\'menu-item-handle\'><h3>"+$("#new_sidebar_name").val()+"</h3><span class=\'item-controls\'><a href=\'#\' class=\'delete delete-sidebar\'>Delete</a></span><input type=\'hidden\' name=\'sidebarmanager_options[custom_sidebar][]\' value=\'"+$("#new_sidebar_name").val()+"\' /></dt></dt></li>").hide();
								$(".sidebar_management ul").append(new_item); 
								new_item.show("slow");
								$("#new_sidebar_name").val("");  
							})  
		  
						})  
			';  
		  
			$output .= "</script>";  
		  	if($_GET['settings-updated']){
		  	$output .= '<br><div id="message" class="updated below-h2" style="width:396px;"><p>Sidebars have been saved. <a href="widgets.php" data-bitly-type="bitly_hover_card">View widgets</a></p></div>';
			};
			$output .= "<div class='sidebar_management'>";
			
			$output .= "<ul class='menu ui-sortable'>";  
		  
			// Display every custom sidebar  
			if(isset($opts['custom_sidebar']))  
			{  
				$i = 0;  
				foreach($opts['custom_sidebar'] as $sidebar)  
				{  
					$output .= "<li class='menu-item'><dt class='menu-item-bar'><dt class='menu-item-handle'><h3>".$sidebar."</h3><span class='item-controls '><a href='#' class='delete delete-sidebar'>Delete</a></span><input type='hidden' name='sidebarmanager_options[custom_sidebar][]' value='".$sidebar."' /></dt></dt></li>";  
					$i++;  
				}  
			}  
		  
			$output .= "</ul>";  
			$onfocus = 'onfocus=\'if (this.value == \'Sidebar name\') {this.value = \'\';}\' onblur=\'if (this.value == \'\') {this.value = \'Sidebar name\';}\'';
			$output .= '<p><input type="text" value="Sidebar name" onfocus="if (this.value == \'Sidebar name\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'Sidebar name\';}" id="new_sidebar_name" /> <input class="button-secondary" type="button" id="add_sidebar" value="Add new sidebar" /></p>';  
		  
			$output .= "</div>";  
		  
			echo $output;  
			
			?> 
            <p><input type="submit" name="Submit" class="button-primary" value="Save Sidebars" /></p>  
            <input type="hidden" name="action" value="update" />  
            <input type="hidden" name="page_options" value="sidebarmanager_options" />  
        </form>  
    </div>  
<?php  
  
}

//
// Sidebar Metabox
//

add_action("admin_init", "page_sidebar_metabox");   

function page_sidebar_metabox(){
	add_meta_box("page_sidebar_metabox", "Sidebar", "page_sidebar_config", "post", "side", "low");
	add_meta_box("page_sidebar_metabox", "Sidebar", "page_sidebar_config", "page", "side", "low");
}   

function page_sidebar_config(){
        global $post,$of_option;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
		$page_sidebar = $custom["page_sidebar"][0];
?>
    <table class="form-table custom-table side-table">
    	<tr class="primary-sidebar">
            <td class="select-fields" style="padding-left:0;">        
                <select name="page_sidebar"> 
                <option value="Default" <?php if($page_sidebar == "Default" || !$page_sidebar) echo "selected"; ?>>Default</option>
            	<?php
								
				$sidebars = get_option('sidebarmanager_options');  
  
				if(isset($sidebars['custom_sidebar']) && sizeof($sidebars['custom_sidebar']) > 0)  
				{  
					foreach($sidebars['custom_sidebar'] as $sidebar)  
					{  
				?>                
				<option value="<?php echo $sidebar; ?>"<?php if($page_sidebar == $sidebar) echo "selected"; ?>><?php echo $sidebar; ?></option>';
                
				<?php
                	}  
				}				
				?>            	

                </select>
            </td>
        </tr>           
    </table>

<?php
    }

// Save Sidebar
	
add_action('save_post', 'save_sidebar'); 

function save_sidebar(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{	
		update_post_meta($post->ID, "page_sidebar", $_POST["page_sidebar"]);
    }

}