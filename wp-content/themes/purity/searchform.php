<div class="search"> 
	<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
        <input class="search_submit" id="searchsubmit" value="" type="submit"> 
        <input class="search_box" name="s" id="s" type="text" value="<?php tr_translate(search); ?>" onfocus="if (this.value == '<?php tr_translate(search); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php tr_translate(search); ?>';}">  
    </form>    
</div>