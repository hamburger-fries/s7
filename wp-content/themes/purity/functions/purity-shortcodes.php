<?php

// Columns

function column_one_half($atts, $content=null){
	return '<div class="column one_half">'.do_shortcode($content).'</div>';
}
add_shortcode('one_half', 'column_one_half');

function column_one_half_last($atts, $content=null){
	return '<div class="column one_half last">'.do_shortcode($content).'</div>';
}
add_shortcode('one_half_last', 'column_one_half_last');


function column_one_third($atts, $content=null){
	return '<div class="column one_third">'.do_shortcode($content).'</div>';
}
add_shortcode('one_third', 'column_one_third');

function column_one_third_last($atts, $content=null){
	return '<div class="column one_third last">'.do_shortcode($content).'</div>';
}
add_shortcode('one_third_last', 'column_one_third_last');

function column_two_third($atts, $content=null){
	return '<div class="column two_third">'.do_shortcode($content).'</div>';
}
add_shortcode('two_third', 'column_two_third');

function column_two_third_last($atts, $content=null){
	return '<div class="column two_third last">'.do_shortcode($content).'</div>';
}
add_shortcode('two_third_last', 'column_two_third_last');


function column_one_fourth($atts, $content=null){
	return '<div class="column one_fourth">'.do_shortcode($content).'</div>';
}
add_shortcode('one_fourth', 'column_one_fourth');

function column_one_fourth_last($atts, $content=null){
	return '<div class="column one_fourth last">'.do_shortcode($content).'</div>';
}
add_shortcode('one_fourth_last', 'column_one_fourth_last');

function column_three_fourth($atts, $content=null){
	return '<div class="column three_fourth">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fourth', 'column_three_fourth');

function column_three_fourth_last($atts, $content=null){
	return '<div class="column three_fourth last">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fourth_last', 'column_three_fourth_last');


function column_one_fifth($atts, $content=null){
	return '<div class="column one_fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('one_fifth', 'column_one_fifth');

function column_one_fifth_last($atts, $content=null){
	return '<div class="column one_fifth last">'.do_shortcode($content).'</div>';
}
add_shortcode('one_fifth_last', 'column_one_fifth_last');

function column_two_fifth($atts, $content=null){
	return '<div class="column two_fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('two_fifth', 'column_two_fifth');

function column_two_fifth_last($atts, $content=null){
	return '<div class="column two_fifth last">'.do_shortcode($content).'</div>';
}
add_shortcode('two_fifth_last', 'column_two_fifth_last');

function column_three_fifth($atts, $content=null){
	return '<div class="column three_fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fifth', 'column_three_fifth');

function column_three_fifth_last($atts, $content=null){
	return '<div class="column three_fifth last">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fifth_last', 'column_three_fifth_last');

function column_four_fifth($atts, $content=null){
	return '<div class="column four_fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('four_fifth', 'column_four_fifth');

function column_four_fifth_last($atts, $content=null){
	return '<div class="column four_fifth last">'.do_shortcode($content).'</div>';
}
add_shortcode('four_fifth_last', 'column_four_fifth_last');


// Dividers

function column_divider($atts, $content=null){
	return '<div class="divider"></div>';
}
add_shortcode('divider', 'column_divider');

function column_divider_line($atts, $content=null){
	return '<div class="divider line"></div>';
}
add_shortcode('divider_line', 'column_divider_line');

function column_divider_top($atts, $content=null){
	return '<div class="divider top"><a href="#">'.get_option_tree('tr_divider_top').'</a></div>';
}
add_shortcode('divider_top', 'column_divider_top');


// Buttons


function bt_button_light($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button light">'.do_shortcode($content).'</a>';
}
add_shortcode('button_light', 'bt_button_light');

function bt_button_light_grey($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button light_grey">'.do_shortcode($content).'</a>';
}
add_shortcode('button_light_grey', 'bt_button_light_grey');

function bt_button_light_blue($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button light_blue">'.do_shortcode($content).'</a>';
}
add_shortcode('button_light_blue', 'bt_button_light_blue');

function bt_button_blue($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button blue">'.do_shortcode($content).'</a>';
}
add_shortcode('button_blue', 'bt_button_blue');

function bt_button_purple($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button purple">'.do_shortcode($content).'</a>';
}
add_shortcode('button_purple', 'bt_button_purple');

function bt_button_yellow($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button yellow">'.do_shortcode($content).'</a>';
}
add_shortcode('button_yellow', 'bt_button_yellow');

function bt_button_orange($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button orange">'.do_shortcode($content).'</a>';
}
add_shortcode('button_orange', 'bt_button_orange');

function bt_button_green($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button green">'.do_shortcode($content).'</a>';
}
add_shortcode('button_green', 'bt_button_green');   

function bt_button_light_green($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button light_green">'.do_shortcode($content).'</a>';
}
add_shortcode('button_light_green', 'bt_button_light_green'); 

function bt_button_red($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button red">'.do_shortcode($content).'</a>';
}
add_shortcode('button_red', 'bt_button_red');   

function bt_button_brown($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="button brown">'.do_shortcode($content).'</a>';
}
add_shortcode('button_brown', 'bt_button_brown');  



function bt_big_button_light($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button light">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_light', 'bt_big_button_light');

function bt_big_button_light_grey($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button light_grey">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_light_grey', 'bt_big_button_light_grey');

function bt_big_button_light_blue($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button light_blue">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_light_blue', 'bt_big_button_light_blue');

function bt_big_button_blue($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button blue">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_blue', 'bt_big_button_blue');

function bt_big_button_purple($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button purple">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_purple', 'bt_big_button_purple');

function bt_big_button_yellow($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button yellow">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_yellow', 'bt_big_button_yellow');

function bt_big_button_orange($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button orange">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_orange', 'bt_big_button_orange');

function bt_big_button_green($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button green">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_green', 'bt_big_button_green');

function bt_big_button_light_green($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button light_green">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_light_green', 'bt_big_button_light_green'); 

function bt_big_button_red($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button red">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_red', 'bt_big_button_red');   

function bt_big_button_brown($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => ''
	), $atts));
	return '<a href="'.$url.'" class="big_button brown">'.do_shortcode($content).'</a>';
}
add_shortcode('big_button_brown', 'bt_big_button_brown');  


// Lightbox Gallery


function el_lightbox_gallery($atts, $content = null) {
	return '<div class="gallery clearfix">'.do_shortcode($content).'</div></div>';
}
add_shortcode('lightbox_gallery', 'el_lightbox_gallery'); 

function lightbox_image_first($atts, $content = null) {
	extract(shortcode_atts(array(
		"rel" => '',
		"src" => '',
		"width" => '',
		"title" => ''
	), $atts));
	return '<a href="'.$src.'" rel="gallery['.$rel.']" title="'.$title.'"><img width="'.$width.'" src="'.$src.'" /></a><div class="hidden">';
}
add_shortcode('lightbox_img_first', 'lightbox_image_first'); 

function lightbox_image($atts, $content = null) {
	extract(shortcode_atts(array(
		"rel" => '',
		"src" => '',
		"title" => ''
	), $atts));
	return '<a href="'.$src.'" rel="gallery['.$rel.']" title="'.$title.'"></a>';
}
add_shortcode('lightbox_img', 'lightbox_image'); 


// Toggles

function el_toggle($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => ''
	), $atts));
	return '<div class="toggle-container"><h6 class="toggle">'.$title.'</h6><div class="toggle-content">'.do_shortcode($content).'</div></div>';
}
add_shortcode('toggle', 'el_toggle'); 


// Tabs

function el_tabs( $atts, $content ){
	$GLOBALS['tab_count'] = 0;
	$i = 0;
	
	do_shortcode( $content );
	
	if( is_array( $GLOBALS['tabs'] ) ){
	foreach( $GLOBALS['tabs'] as $tab ){
	$count = $i++;
	$pre = str_replace (" ", "", $tab['title']);
	$tabs[] = '<li><a href="#'.$pre.'tab'.$count.'">'.$tab['title'].'</a></li>';
	$panes[] = '<div id="'.$pre.'tab'.$count.'" class="tabdiv"><p>'.$tab['content'].'</p></div>';
	}
	$return = "\n".'<!-- the tabs --><div class="tabs"><ul class="tabnav">'.implode( "\n", $tabs ).'</ul>'."\n".'<!-- tab "panes" -->'.implode( "\n", $panes ).'</div>'."\n";
	unset($GLOBALS['tabs']);
	}
	return $return;
}
add_shortcode( 'tabs', 'el_tabs' );

function tab_div( $atts, $content ){
	extract(shortcode_atts(array(
	'title' => 'Tab %d'
	), $atts));
	
	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  $content );
	
	$GLOBALS['tab_count']++;
}
add_shortcode( 'tab', 'tab_div' );


// Lists

function list_item($atts, $content=null){
	return '<li>'.do_shortcode($content).'</li>';
}
add_shortcode('li', 'list_item');

function li_list_check( $atts, $content = null ) {
	return '<ul class="list check">'.do_shortcode($content).'</ul>';	
}
add_shortcode('list_check', 'li_list_check');

function li_list_checkgrey( $atts, $content = null ) {
	return '<ul class="list checkgrey">'.do_shortcode($content).'</ul>';	
}
add_shortcode('list_checkgrey', 'li_list_checkgrey');

function li_list_square( $atts, $content = null ) {
	return '<ul class="list square">'.do_shortcode($content).'</ul>';	
}
add_shortcode('list_square', 'li_list_square');

function li_list_circle( $atts, $content = null ) {
	return '<ul class="list circle">'.do_shortcode($content).'</ul>';	
}
add_shortcode('list_circle', 'li_list_circle');

function li_list_ordered( $atts, $content = null ) {
	return '<ol>'.do_shortcode($content).'</ol>';	
}
add_shortcode('list_ordered', 'li_list_ordered');
				
function el_content_box($atts, $content = null) {
	extract(shortcode_atts(array(
		"color" => ''
	), $atts));
	return '<div class="box" style="border-color:'.$color.'; color:'.$color.'">'.do_shortcode($content).'</div>';
}
add_shortcode('content_box', 'el_content_box');


// Icon Boxes

function icon_box($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => '',
		"icon" => ''
	), $atts));
	return '<div class="icon-image icon-'.$icon.'"></div><div class="icon-text"><h5>'.$title.'</h5><p>'.do_shortcode($content).'</p></div>';
}
add_shortcode('icon_box', 'icon_box');  


// Typography

function tg_heading_h1($atts, $content=null){
	return '<h1>'.do_shortcode($content).'</h1>';
}
add_shortcode('h1', 'tg_heading_h1');

function tg_heading_h2($atts, $content=null){
	return '<h2>'.do_shortcode($content).'</h1>';
}
add_shortcode('h2', 'tg_heading_h2');

function tg_heading_h3($atts, $content=null){
	return '<h3>'.do_shortcode($content).'</h1>';
}
add_shortcode('h3', 'tg_heading_h3');

function tg_heading_h4($atts, $content=null){
	return '<h4>'.do_shortcode($content).'</h1>';
}
add_shortcode('h4', 'tg_heading_h4');

function tg_heading_h5($atts, $content=null){
	return '<h5>'.do_shortcode($content).'</h1>';
}
add_shortcode('h5', 'tg_heading_h5');

function tg_heading_h6($atts, $content=null){
	return '<h6>'.do_shortcode($content).'</h1>';
}
add_shortcode('h6', 'tg_heading_h6');


function tg_highlight_light($atts, $content=null){
	return '<span class="highlight-light">'.do_shortcode($content).'</span>';
}
add_shortcode('highlight_light', 'tg_highlight_light');

function tg_highlight_dark($atts, $content=null){
	return '<span class="highlight-dark">'.do_shortcode($content).'</span>';
}
add_shortcode('highlight_dark', 'tg_highlight_dark');

function tg_blockquote($atts, $content=null){
	return '<blockquote><p>'.do_shortcode($content).'</p></blockquote>';
}
add_shortcode('blockquote', 'tg_blockquote');
                   
function tg_blockquote_author($atts, $content = null) {
	extract(shortcode_atts(array(
		"author" => ''
	), $atts));
	return '<blockquote><p>'.do_shortcode($content).'</p><span>'.$author.'</span></blockquote>';
}
add_shortcode('blockquote_with_author', 'tg_blockquote_author');    

function tg_dropcap1($atts, $content=null){
	return '<span class="dropcap1">'.do_shortcode($content).'</span>';
}
add_shortcode('dropcap_1', 'tg_dropcap1');

function tg_dropcap2($atts, $content=null){
	return '<span class="dropcap2">'.do_shortcode($content).'</span>';
}
add_shortcode('dropcap_2', 'tg_dropcap2');

function tg_pull_right($atts, $content=null){
	return '<span class="pullright">'.do_shortcode($content).'</span>';
}
add_shortcode('pull_quote_right', 'tg_pull_right');

function tg_pull_left($atts, $content=null){
	return '<span class="pullleft">'.do_shortcode($content).'</span>';
}
add_shortcode('pull_quote_left', 'tg_pull_left');


function tg_image_centered($atts, $content=null){
	extract(shortcode_atts(array(
		"src" => ''
	), $atts));
	return '<img src="'.$src.'" class="aligncenter" alt>';
}
add_shortcode('image_centered', 'tg_image_centered');

function tg_image_left($atts, $content=null){
	extract(shortcode_atts(array(
		"src" => ''
	), $atts));
	return '<img src="'.$src.'" class="imageleft" alt>';
}
add_shortcode('image_left', 'tg_image_left');

function tg_image_right($atts, $content=null){
	extract(shortcode_atts(array(
		"src" => ''
	), $atts));
	return '<img src="'.$src.'" class="imageright" alt>';
}
add_shortcode('image_right', 'tg_image_right');

function tg_image_left_with_link($atts, $content=null){
	extract(shortcode_atts(array(
		"src" => '',
		"href" => ''
	), $atts));
	return '<a href="'.$href.'"><img src="'.$src.'" class="imageleft" alt></a>';
}
add_shortcode('image_left_link', 'tg_image_left_with_link');

function tg_image_right_with_link($atts, $content=null){
	extract(shortcode_atts(array(
		"src" => '',
		"href" => ''
	), $atts));
	return '<a href="'.$href.'"><img src="'.$src.'" class="imageright" alt></a>';
}
add_shortcode('image_right_link', 'tg_image_right_with_link');

function tg_image_left_with_caption($atts, $content=null){
	extract(shortcode_atts(array(
		"src" => '',
		"href" => '',
		"caption" => ''
	), $atts));
	return '<div class="blockleft">
			<a href="'.$href.'"><img src="'.$src.'" alt></a>
			<p class="caption">'.$caption.'</p>
			</div>
	';
}
add_shortcode('image_left_caption', 'tg_image_left_with_caption');

function tg_image_right_with_caption($atts, $content=null){
	extract(shortcode_atts(array(
		"src" => '',
		"href" => '',
		"caption" => ''
	), $atts));
	return '<div class="blockright">
			<a href="'.$href.'"><img src="'.$src.'" alt></a>
			<p class="caption">'.$caption.'</p>
			</div>
	';
}
add_shortcode('image_right_caption', 'tg_image_right_with_caption');

// Youtube

function el_youtube($atts, $content=null){

	extract(shortcode_atts(array(
		"id" => ''
	), $atts));

	$return .= '<div class="video-container"><iframe src="http://www.youtube.com/embed/'.$id.'" frameborder="0" allowfullscreen></iframe></div>';

	return $return; 

}
add_shortcode('youtube', 'el_youtube');

// Vimeo

function el_vimeo($atts, $content=null){

	extract(shortcode_atts(array(
		"id" => ''
	), $atts));

	$return .= '<div class="video-container"><iframe src="http://player.vimeo.com/video/'.$id.'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe></div>';

	return $return; 

}
add_shortcode('vimeo', 'el_vimeo');

// Pricing Boxes

function pricing_box($atts, $content=null){

	extract(shortcode_atts(array(
		"title" => '',
		"price" => '',
		"color" => '',
		"border_color" => ''
	), $atts));

	$return .= '<div class="pricing-box" style="border-color:'.$border_color.';">
				<div class="pricing-title"><h3>'.$title.'</h3></div>
				<div class="pricing-content">
				<div class="pricing-price">
                	<h1 style="color:'.$color.';">'.$price.'</h1>
                </div>'.do_shortcode($content).'</div></div>
			
	';

	return $return; 

}
add_shortcode('pricing_box', 'pricing_box');

