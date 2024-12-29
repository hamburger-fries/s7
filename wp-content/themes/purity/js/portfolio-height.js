/*
 * ---------------------------------------------------------------- 
 *  
 *  Portfolio list items equal height script.
 *  
 * ----------------------------------------------------------------  
 */


jQuery(document).ready(function(){	

	function equalHeight(group) {
		var tallest = 0;
		group.css("height", "auto");
		group.each(function() {
			var thisHeight = jQuery(this).height();
			if(thisHeight > tallest) {
				tallest = thisHeight;
			}
		});
		group.height(tallest);
	}
	equalHeight(jQuery(".portfolio3 li"));
	
	jQuery(window).resize(function () {
		equalHeight(jQuery(".portfolio3 li"));	
	});

});