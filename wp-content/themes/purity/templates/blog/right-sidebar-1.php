	<div class="content">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>        
           
        <div class="post"> 
        
        	<?php if(get_post_meta($post->ID, 'pp_image-1', true)){ blog_index_gallery(1); } ?>
            
            <div class="post-content">
                <div class="post-info">
                    <span class="date"><p class="bold"><?php the_time('M d'); ?></p><?php the_time('Y'); ?></span>
                    <span class="comments-nr"><a href="<?php the_permalink(); ?>#comments"><p class="bold"><?php comments_number('0','1','%'); ?></p> <?php tr_translate(comments); ?></a></span>
                    <p><span><?php tr_translate(by); ?></span> <?php the_author_posts_link(); ?></p>
                    <p><span><?php tr_translate(in); ?></span> <?php the_category(', '); ?></p>
                    <?php post_tags(); ?>
                </div>
                <div class="post-entry"> 
                    <h1 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1> 
                    <?php the_content(get_option_tree(tr_read_more).' →'); ?>                     
                </div> 
            </div>
        </div>
            
    <?php endwhile;

# Archive doesn't exist:
else :

    get_header(); ?>
    <h2><?php _e('No posts found.') ?></h2>
    <p><?php _e('Sorry, no posts matched your criteria.') ?></p>
<?php
endif; ?>
    
	<?php include TEMPLATEPATH . '/includes/blog-pagination.php'; ?>
        
    </div><!-- .content End --> 
    <!-- Content End --> 
    
    <?php include TEMPLATEPATH . '/templates/sidebar/sidebar-right.php'; ?>