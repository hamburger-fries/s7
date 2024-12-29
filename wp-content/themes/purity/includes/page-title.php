<?php /* If this is a 404 page error */ if (is_404()) { ?>
    <h1><?php echo get_option_tree('404_title'); ?></h1>
    <?php if(get_option_tree('404_tagline')){
			echo "<span>". get_option_tree('404_tagline') . "</span>";
	} ?>    
<?php /* If this is a tag archive */ } elseif (is_category()) { ?>
    <h1>Archives</h1>
    <span><?php single_cat_title(); ?></span>
<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
    <h1>Archives</h1>
    <span>Tagged &#8216;<?php single_tag_title(); ?>&#8216;</span>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    <h1>Archives</h1>
    <span><?php the_time('F, Y'); ?></span>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1>Archives</h1>
    <span><?php the_time('Y'); ?></span>
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
    <h1>Archives</h1>
	<span>Written by <?php echo get_userdata($author)->display_name; ?></span>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h1>Archives</h1>   
<?php /* If this is a search page */ } elseif (is_search()) { ?>
    <h1>Search</h1>
    <span>Results for "<?php echo $s; ?>"</span> 
<?php /* If this is a portfolio post page */ } elseif(is_page() || get_post_type() == 'portfolio') { ?>
    <h1> <?php page_title(title); ?></h1>
    <?php page_title(tagline); ?> 
<?php /* If this is a single post page */ } elseif(is_single() && get_post_type() !== 'portfolio') { ?>
    <h1> <?php page_title(blog_title); ?></h1>
    <?php page_title(blog_tagline); ?> 
<?php /* If this is a blog page */ } elseif (is_home()) { ?>
    <h1> <?php page_title(blog_title); ?> </h1>
    <?php page_title(blog_tagline); ?>
<?php /* If other */ } else { ?>
    <h1> <?php page_title(title);  echo get_page_template();?></h1>
    <?php page_title(tagline); ?>
<?php
}
?>