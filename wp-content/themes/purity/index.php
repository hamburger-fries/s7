<?php 
get_header(); 
query_posts( 'posts_per_page='.get_option_tree('blog_posts_nr').'&paged='.$paged.'&cat='.$cat.'&author='.$author.'&tag='.$tag );
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
    
    ?>    

<?php
get_footer(); 
?>