<?php if (!defined('OT_VERSION')) exit('No direct script access allowed'); ?>

<div id="framework_wrap" class="wrap">
	
	<div id="header">
    <h1>Purity</h1>
	</div>

  <div id="content_wrap">
  
    <form method="post" id="the-theme-options">
      
            
      <div class="ajax-message<?php if ( isset( $message ) || isset($_GET['updated']) || isset($_GET['layout']) ) { echo ' show'; } ?>">
        <?php if (isset($_GET['updated'])) { echo '<div class="message"><span>&nbsp;</span>Theme Options were updated.</div>'; } ?>
        <?php if (isset($_GET['layout'])) { echo '<div class="message"><span>&nbsp;</span>Your Layout has been activated.</div>'; } ?>
        <?php if ( isset( $message ) ) { echo $message; } ?>
      </div>
      
      <div id="content">
      

        
          <ul class="options_tabs">

          </ul>
          
          <div class="block ui-tabs-panel ui-widget-content ui-corner-bottom">
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
			  if ( $value->item_type !== 'slider' ){
				  echo '<div id="slider" style="display:none;">';
				  call_user_func_array( 'option_tree_' . $value->item_type, array( $value, $settings, $int ) ); 
				  echo '</div>';
              }else{				  
              	call_user_func_array( 'option_tree_' . $value->item_type, array( $value, $settings, $int ) );			  	  
			  }
            }
            ?>
            </div>
            
          <br class="clear" />
          
        </div>
        

      
      <div class="info bottom">
      
        <input type="submit" value="<?php _e('Save All Changes') ?>" class="button button-framework save-options" name="submit"/>
        
      </div>
      
      <?php wp_nonce_field( '_theme_options', '_ajax_nonce', false ); ?>
      
    </form>
    
  </div>

</div>
<!-- [END] framework_wrap -->