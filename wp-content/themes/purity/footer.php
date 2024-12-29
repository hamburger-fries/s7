</div><!-- .inner End --> 
        </div><!-- #main End --> 
        <!-- MAIN CONTENT END --> 
        
        <div class="inner"><div class="footer_divider"></div></div>
        
		<!-- FOOTER START --> 
        <div id="footer"> 
        
        	<?php if(!get_option_tree('footer_disabled')) : ?>
        	<div class="inner">    
            	<ul class="<?php
                if ( function_exists( 'get_option_tree') ) {
                  $footer =  get_option_tree( 'footer_cols' );
                  $footer = strtolower((str_replace (" ", "", $footer)));
                  echo "$footer";
                } 
                ?>">   
            	                 
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Widgets Area") ) : ?>                
                </ul>
                
                <div class="clear"></div>
                <?php endif; ?>             
       
            </div><!-- .inner End -->  
            <?php endif; ?>
          
            <div class="footer_small <?php echo strtolower((str_replace (" ", "", get_option_tree('footer_style')))); ?> inner">           
                        
            	<div class="copyright"><?php echo get_option_tree('copyright'); ?></div>
                
                <?php if(!get_option_tree('social_disabled')) : ?>
                <div class="social"> 
                	<?php
					foreach (range(1, 19) as $v ){
						if(get_option_tree("social_".$v)) :
						echo '<a href="'.get_option_tree("social_".$v).'" class="social-'.$v.'"></a>';
						endif;
					}					
					?>
                </div> 
                <?php endif; ?>
                
            </div> <!-- #footer_small End -->
            
        </div><!-- #footer End -->   
        <!-- FOOTER END -->        
    </div><!-- #holder End --> 
    <!-- PAGE END -->
    
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?> 
</body> 
</html>