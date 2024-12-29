<?php
get_header();
?>
            
<div class="inner custom_content"> 
         
	<!-- Content Start --> 
	<div class="content <?php global_template(content); ?>">  
          
	<?php echo get_option_tree('404_msg'); ?>

	</div><!-- .content End --> 
	<!-- Content End -->

	<?php global_template(sidebar); ?>
                   
<?php
get_footer(); 
?>
