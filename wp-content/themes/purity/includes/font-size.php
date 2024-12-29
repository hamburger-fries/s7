<?php 
$fs = "{font-size:";
$px = "px !important;}";
if(get_option_tree('fs_body')){ 
	echo "body". $fs . get_option_tree('fs_body') . $px;
}if(get_option_tree('fs_nav')){ 
	echo ".nav ul li". $fs . get_option_tree('fs_nav') . $px;
}if(get_option_tree('fs_ht')){ 
	echo ".home_tagline h1". $fs . get_option_tree('fs_ht') . $px;
}if(get_option_tree('fs_h1')){ 
	echo "h1". $fs . get_option_tree('fs_h1') . $px;
}if(get_option_tree('fs_h2')){ 
	echo "h2". $fs . get_option_tree('fs_h2') . $px;
}if(get_option_tree('fs_h3')){ 
	echo "h3". $fs . get_option_tree('fs_h3') . $px;
}if(get_option_tree('fs_h4')){ 
	echo "h4". $fs . get_option_tree('fs_h4') . $px;
}if(get_option_tree('fs_h5')){ 
	echo "h5". $fs . get_option_tree('fs_h5') . $px;
}if(get_option_tree('fs_h6')){ 
	echo "h6". $fs . get_option_tree('fs_h6') . $px;
}