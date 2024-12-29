<?php
//
// Spacing Theme Dynamic Stylesheet
//

header("Content-type: text/css;");

$current_url = dirname(__FILE__);
$wp_content_pos = strpos($current_url, 'wp-content');
$wp_content = substr($current_url, 0, $wp_content_pos);

require_once($wp_content . 'wp-load.php');
	
$prefix = "st_";

if(get_option_tree('theme_color')){ ?>

a,.portfolio li h4.title:hover,.home_tagline h1 a,.nav ul li.current > a,.nav ul li:hover > a,.tweet .twitter-content a,#footer ul.recent-posts a:hover,.nav ul li.current > a:hover,.slider .nivo-caption a,.title a:hover,.comments-nr a:hover,.comments-nr a:hover .bold,.pagination a:hover,.top a:hover,.filter li.current a,.recent-posts li:hover strong,.nav ul li.current-menu-item > a,#recent-posts h5 a:hover,#recent-posts span.post-info a:hover,.nav ul li.current-menu-parent > a,.nav ul li.current-menu-item > a:hover,.nav ul li.current-menu-parent > a:hover,.post-info p a:hover,.post-meta a:hover{ color: <?php echo get_option_tree( 'theme_color' ); ?>;  }

::selection { background:<?php echo get_option_tree( 'theme_color' ); ?>; }	
<?php } ?>

a:hover,.sidebar_item ul li a:hover,.home_tagline h1 a:hover,.tweet .twitter-content a:hover { color: <?php echo get_option_tree( 'hover_color' ); ?>; ?>  }	

<?php if(get_option_tree('bg_color') || get_option_tree('bg_img') ){ ?>
body { background: <?php echo get_option_tree( 'bg_color' ); ?> url(<?php echo get_option_tree( 'bg_img' ); ?>) repeat top center <?php if(get_option_tree( 'bg_style' )){echo "fixed";} ?>; }	
<?php } ?>

<?php if(get_option_tree('nav_margin')){ ?>
.nav { margin-top:<?php echo get_option_tree('nav_margin'); ?>px; }
<?php }

//
// Font Sizes
//

include '../includes/font-size.php'; 

//
// Font Families
//

// Heading Font

if(!get_option_tree('font_heading') || get_option_tree('font_heading') == "League Gothic"){
?>

@font-face {
    font-family: 'LeagueGothicRegular';
    src: url('font/League_Gothic-webfont.eot');
    src: url('font/League_Gothic-webfont.eot?#iefix') format('embedded-opentype'),
         url('font/League_Gothic-webfont.woff') format('woff'),
         url('font/League_Gothic-webfont.ttf') format('truetype'),
         url('font/League_Gothic-webfont.svg#LeagueGothicRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

<?php } elseif(get_option_tree('font_heading')) { ?>


.nav,h1,h2,h3,h4,.home_tagline h1,.tagline h1,.over span,.dropcap1,.dropcap2,.bold,.flex-caption { 
	font-family:'<?php echo get_option_tree('font_heading') ?>', Helvetica, Arial; 
	text-transform:none; 
	font-weight:normal;
}

<?php } 

if(get_option_tree('font_body') && get_option_tree('font_body') != "Helvetica/Arial"){
?>

body {
	font-family: '<?php echo get_option_tree('font_body') ?>',Helvetica,Arial;
}

<?php } ?>