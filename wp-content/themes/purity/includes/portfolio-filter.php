<?php

if(!get_option_tree('filter_disabled')){ ?>
<ul class="filter"> 
    <li class="current"> 
        <a href="" title="view-all"><?php echo get_option_tree('all_projects') ?></a> 
    </li> 
    <?php portfolio_cats(); ?>
</ul>  
    
<?php } ?>