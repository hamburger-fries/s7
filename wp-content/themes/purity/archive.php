<?php
	if (have_posts()) :
	get_header();
?>

<div class="inner">

<?php
    
    $the_template = get_option_tree('blog_template');
    
    if($the_template){
        $the_template = strtolower((str_replace (" ", "-", $the_template)));
        include "templates/blog/".$the_template.".php";
    }else{
        include "templates/blog/right-sidebar-1.php";
    }
    

# No search results:
else :

    get_header(); ?>
    
    <div class="inner">
    
    <div class="content  <?php global_template(content); ?>"> 
    	
        <h2><?php _e('No posts found.') ?></h2>
        <p><?php _e('Sorry, no posts matched your criteria.') ?></p>

		<div class="pagination">         	
        	<div class="newer-posts"><?php next_posts_link('← Newer entries'); ?></div>
            <div class="older-posts"><?php previous_posts_link('Older entries →'); ?></div>
        </div>
	</div><!-- .content End --> 
    
    <?php global_template(sidebar); ?> 
	
<?php endif; ?>
<?php
get_footer(); ?>