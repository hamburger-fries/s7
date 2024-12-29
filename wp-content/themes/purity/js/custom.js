/*
 * ---------------------------------------------------------------- 
 *  
 *  Purity HTML/CSS Template custom jQuery scripts.
 *  
 * ----------------------------------------------------------------  
 */


jQuery(document).ready(function(){	
	
 
/*
 * ---------------------------------------------------------------- 
 *  Dropdown menu
 * ----------------------------------------------------------------  
 */
	
	function mainmenu(){
	jQuery('.nav li').hover(function(){
		jQuery(this).find('ul:first').css({visibility: "visible",display: "none"}).show(300);
	},function(){
		jQuery(this).find('ul:first').css({visibility: "hidden"});
	});
	}
	
	mainmenu();
	
	
	
/*
 * ---------------------------------------------------------------- 
 *  Responsive Navigation
 * ----------------------------------------------------------------  
 */		
	
	var dropdown = document.getElementById("page_id");
	function onPageChange() {
		if ( dropdown.options[dropdown.selectedIndex].value != 0 ) {
			location.href = dropdown.options[dropdown.selectedIndex].value;
		}
	}
	dropdown.onchange = onPageChange;
	

/*
 * ---------------------------------------------------------------- 
 *  Image hover effect
 * ----------------------------------------------------------------  
 */
 	
	// Over field
	
	jQuery('.over').stop().animate({ "opacity": 0 }, 0);
 	function over() {
		jQuery('.over').hover(function() {
			jQuery(this).stop().animate({ "opacity": .9 }, 250);
		}, function() {
			jQuery(this).stop().animate({ "opacity": 0 }, 250);
		});	
	}
	
	over();
	
	// Firefox fix
	
	if (window.addEventListener) { 
        window.addEventListener('unload', function() {}, false); 
	} 
	
	
	// Opacity change on hover
	
	function hover_opacity() {
		jQuery('.portfolio li,.gallery a[rel], .button, .big_button, .search_submit, .flickr_badge_image').hover(function() {
			jQuery(this).find('img').stop().animate({ "opacity": .4 }, 250);
		}, function() {
			jQuery(this).find('img').stop().animate({ "opacity": 1 }, 250);
		});
	}
	
	hover_opacity();
	
	
/*
 * ---------------------------------------------------------------- 
 *  Simple codes
 * ----------------------------------------------------------------  
 */
	
	// Tabs
	
	jQuery(".tabs").tabs();
	
	
	// Toggles	

	jQuery('.toggle-container').click(function () {
		var text = jQuery(this).children('.toggle-content');
		
		if (text.is(':hidden')) {
			text.slideDown('fast');
			jQuery(this).children('h6').addClass('active');		
		} else {
			text.slideUp('fast');
			jQuery(this).children('h6').removeClass('active');		
		}		
	});
	
	
/*
 * ---------------------------------------------------------------- 
 *  Quicksand (Sortable Portfolio)
 * ----------------------------------------------------------------  
 */
 
	if (jQuery().quicksand) {

        (function($) {
            
            jQuery.fn.sorted = function(customOptions) {
                var options = {
                    reversed: false,
                    by: function(a) {
                        return a.text();
                    }
                };
        
                jQuery.extend(options, customOptions);
        
                $data = jQuery(this);
                arr = $data.get();
                arr.sort(function(a, b) {
        
                    var valA = options.by(jQuery(a));
                    var valB = options.by(jQuery(b));
            
                    if (options.reversed) {
                        return (valA < valB) ? 1 : (valA > valB) ? -1 : 0;              
                    } else {        
                        return (valA < valB) ? -1 : (valA > valB) ? 1 : 0;  
                    }
            
                });
        
                return jQuery(arr);
        
            };
        
        })(jQuery);
        
        jQuery(function() {
        
            var determine_sort = function($buttons) {
                var $selected = $buttons.parent().filter('[class*="current"]');
                return $selected.find('a').attr('data-value');
            };
        
            var determine_kind = function($buttons) {
                var $selected = $buttons.parent().filter('[class*="current"]');
                return $selected.find('a').attr('data-value');
            };
        
            var $preferences = {
                duration: 500,
                adjustHeight: 'auto'
            }
        
            var $list = jQuery('.portfolio');
            var $data = $list.clone();
        
            var $controls = jQuery('.filter');
        
            $controls.each(function(i) {
        
                var $control = jQuery(this);
                var $buttons = $control.find('a');
        
                $buttons.bind('click', function(e) {
        
                    var $button = jQuery(this);
                    var $button_container = $button.parent();
                    var button_properties = jQuery(this).attr('title');    
                    var selected = button_properties.selected;
                    var button_segment = button_properties.segment;
					
                    if (!selected) {
        
                        $buttons.parent().removeClass();
                        $button_container.addClass('current');
        
                        var sorting_type = determine_sort($controls.eq(1).find('a'));
                        var sorting_kind = determine_kind($controls.eq(0).find('a'));
        
                        if (button_properties == 'view-all') {
                            var $filtered_data = $data.find('li');
                        } else {
                            var $filtered_data = $data.find('li.' + button_properties);
                        }
        
                        var $sorted_data = $filtered_data.sorted({
                            by: function(v) {
                                return jQuery(v).attr('data-id');
                            }
                        });
        
                        $list.quicksand($sorted_data, $preferences, function () {
                                over();
								hover_opacity();
                                prettyPhoto();
                        });
            
                    }
            
                    e.preventDefault();
                    
                });
            
            }); 
            
        });
    
    }
	
/*
 * ---------------------------------------------------------------- 
 *  PrettyPhoto
 * ----------------------------------------------------------------  
 */
 
 	
	
	function prettyPhoto() {
		jQuery(".gallery a[rel^='gallery']").prettyPhoto({animation_speed:'normal',theme:'pp_default',deeplinking:false,slideshow:3000});
	}
	
	prettyPhoto();
	
	
});