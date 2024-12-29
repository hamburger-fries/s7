<?php
if ( have_comments() ) : ?>

	<div class="divider line"></div>
    
    <!-- Post Comments Start --> 
    <div class="comments-wrap"> 
        <h3 id="comments">
            <?php comments_number('No Comments', 'One Comment', '% Comments' ); ?>
        </h3>

        <ul>
            <?php wp_list_comments('type=comment&callback=ts_comment&per_page='.get_option_tree('blog_comments_nr').'&reverse_top_level=1'); ?>
        </ul>        
    
    </div>    
    
    <div class="pagination comments-pagination">         	
        <div class="newer-posts"><?php next_comments_link('← '.get_option_tree('tr_newer_comments')); ?></div>
        <div class="older-posts"><?php previous_comments_link(get_option_tree('tr_older_comments').' →'); ?></div>
    </div>    

<?php

else : // no comments so far

    if ('open' == $post->comment_status) :
        // If comments are open, but there are no comments.
    else :
    endif;

endif;
?>


<?php if ('open' == $post->comment_status) : ?>


    <div id="respond" class="respond">
    
    <div class="divider line"></div>
    
    <div class="respond-title">
        <h3><?php comment_form_title( tr_translate(leave_reply) ); ?></h3>
        <span><?php cancel_comment_reply_link(get_option_tree('tr_cancel_reply')); ?></span>    
    </div>
    <div class="cancel-comment-reply">
        
    </div>   
       
    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
        <p>You must be <a href="<?php echo get_option('siteurl'); ?>
/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
    <?php else : ?>

                             
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" class="big_form" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

    <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php">
<?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" 
title="Log out of this account">Log out »</a></p>

<?php else : ?>
	<label for="author"><?php tr_translate(name); ?>:</label>
    <input type="text" class="text" name="author" id="author" value="<?php echo $comment_author; ?>">
	
    <label for="email"><?php tr_translate(email); ?>:</label>
    <input type="text" class="text" name="email" id="email" value="<?php echo $comment_author_email; ?>"> 

	<label for="url"><?php tr_translate(comment_website); ?>:</label>
    <input type="text" class="text" name="url" id="url" value="<?php echo $comment_author_url; ?>"> 

<?php endif; ?>

	<label for="comment"><?php tr_translate(comment_msg); ?>:</label> 
    <textarea name="comment" id="comment" rows="8" cols="60"></textarea>

	<input type="submit" name="submit" id="submit" class="button light" value="<?php tr_translate(comment_submit); ?>">
    
    <?php comment_id_fields(); ?>
    <?php do_action('comment_form', $post->ID); ?>

    </form>

<?php endif; // If registration required and not logged in ?>
	</div>

<?php endif; // if you delete this the sky will fall on your head ?>


