<?php if (!defined('OT_VERSION')) exit('No direct script access allowed'); ?>

<div id="framework_wrap" class="wrap">
	
	<div id="header">
    <h1>Purity</h1>
    <span class="icon">&nbsp;</span>
    <div class="version">
      v2.2
    </div>
	</div>

  <div id="content_wrap">  	
    <form method="post" id="the-theme-options">
      
      <div class="info top-info">        
        <input type="submit" value="<?php _e('Save All Changes') ?>" class="button button-framework save-options" name="submit" />
        
        <?php if ( $this->has_xml && $this->show_docs == false ) { ?>
        <input type="submit" value="<?php _e('Reload XML') ?>" class="button button-framework reload-options" name="reload" style="margin-right:10px;" />
        <?php } ?>
        <?php
        if ( is_array( $layouts ) && !empty($layouts) ) 
        {
          echo '<div class="select-layout">';
          echo '<select name="active_theme_layout" id="active_theme_layout">';
          echo '<option value="">-- Choose One --</option>';

          $active_layout = $layouts['active_layout'];
          foreach( $layouts as $key => $v ) 
          { 
            if ( $key == 'active_layout')
              continue;
              
            $selected = '';
  	        if ( $active_layout == trim( $key ) ) 
              $selected = ' selected="selected"'; 

  	        echo '<option'.$selected.'>'.trim( $key ).'</option>';
       		}
       		echo '</select>';
       		?>
       		<input type="submit" value="<?php _e('Activate Layout') ?>" class="button button-framework user-activate-layout" name="user-activate-layout" style="margin-right:10px;" />
       		<?php
       		echo '</div>';
     		}
        ?>
        
      </div>
      
      <div class="ajax-message<?php if ( isset( $message ) || isset($_GET['updated']) || isset($_GET['xml']) || isset($_GET['default']) ) { echo ' show'; } ?>">
        <?php if (isset($_GET['updated'])) { echo '<div class="message"><span>&nbsp;</span>Theme Options were updated.</div>'; } ?>
        <?php if (isset($_GET['layout'])) { echo '<div class="message"><span>&nbsp;</span>Your Layout has been activated.</div>'; } ?>
        <?php if(isset($_GET['xml'])) { echo '<div class="message"><span>&nbsp;</span>Theme Options were successfully updated.</div>'; } ?>
        <?php if(isset($_GET['default'])) { echo '<div class="message"><span>&nbsp;</span>Default Theme Options has been imported.</div>'; } ?>
        <?php if ( isset( $message ) ) { echo $message; } ?>
      </div>
      
      <div id="content">
      
        <div id="options_tabs">
        
          <ul class="options_tabs">
            <?php 
            foreach ( $ot_array as $value ) 
            { 
              if ( $value->item_type == 'heading' ) 
              {
                echo '<li><a href="#option_'.$value->item_id.'">' . htmlspecialchars_decode( $value->item_title ).'</a><span></span></li>';
              } 
            } 
            ?>
          </ul>
          
            <?php
            // set count        
            $count = 0;
            // loop options & load corresponding function   
            foreach ( $ot_array as $value ) 
            {
              $count++;
              if ( $value->item_type == 'upload' || $value->item_type == 'slider' ) 
              {
                $int = $post_id;
              }			  
              else if ( $value->item_type == 'textarea' )
              {
                $int = ( is_numeric( trim( $value->item_options ) ) ) ? trim( $value->item_options ) : 8;
              }
              else
              {
                $int = $count;
              }
			  if ( $value->item_type == 'slider' ){
				  echo '<div style="display:none;">';
				  call_user_func_array( 'option_tree_slider', array( $value, $settings, $int ) ); 
				  echo '</div>';
              }else{				  
              	call_user_func_array( 'option_tree_' . $value->item_type, array( $value, $settings, $int ) );			  	  
			  }
            }
            // close heading
            echo '</div>';
            ?>
            
          <br class="clear" />
          
        </div>
        
      </div>
      
      <div class="info bottom">
      
        <input type="submit" value="<?php _e('Save All Changes') ?>" class="button button-framework save-options" name="submit"/>
        
      </div>
      
      <?php wp_nonce_field( '_theme_options', '_ajax_nonce', false ); ?>
      
    </form>
    
    <div class="panel-settings">
        <form method="post" action="admin.php?page=option_tree&action=upload" enctype="multipart/form-data" id="upload-xml">            
              <input type="submit" value="<?php _e('Update Panel') ?>" class="button button-framework upload-button" />
        </form>
        <form method="post" id="import-data">            
              <input type="submit" value="<?php _e('Restore Default') ?>" class="button button-framework import-button import-data" />
              <?php wp_nonce_field( '_import_data', '_ajax_nonce', false ); ?>
        </form>
    </div>
  </div>

</div>
<!-- [END] framework_wrap -->