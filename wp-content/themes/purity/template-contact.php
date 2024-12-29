<?php
/*
Template Name: Contact
*/

get_header(); ?>


<?php 
//If the form is submitted
if(isset($_POST['submitted'])) {

	//Check to make sure that the name field is not empty
	if(trim($_POST['contactName']) === '') {
		$nameError = 'You forgot to enter your name.';
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}
	
	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) === '')  {
		$emailError = 'You forgot to enter your email address.';
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}
		
	//Check to make sure comments were entered	
	if(trim($_POST['comments']) === '') {
		$commentError = 'You forgot to enter your comments.';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}
		
	//If there is no error, send the email
	if(!isset($hasError)) {

		$emailTo = get_option_tree('pr_contact_email');
		$subject = 'Contact Form Submission from '.$name;
		$msubject = trim($_POST['subject']);
		$body = "Name: $name \n\nE-Mail: $email \n\nSubject: $msubject \n\nMessage: $comments";
		$headers = 'From: My Site <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
		
		mail($emailTo, $subject, $body, $headers);

		$emailSent = true;

	}
}
?>
<?php get_header(); ?>

<div class="inner custom_content"> 
                            
	<div class="content  <?php global_template(content); ?>"> 
    
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>                    
  
    	<?php if(the_content()){ ?>
    	<div class="divider"></div>
        <?php } ?>
			
		<?php endwhile; endif; ?>
    
	<?php if(isset($emailSent) && $emailSent == true) { ?>
  
    <div class="form-success"> 
    	<?php echo get_option_tree('pr_form_success'); ?>  
    </div></div>

	<?php } else { ?>

	<div class="form-success"> 
    	<?php echo get_option_tree('pr_form_success'); ?> 
    </div>

		<form action="<?php the_permalink(); ?>" id="contactForm" class="big_form" method="post">
	
			<ul class="forms">
				<li><label for="contactName"><?php tr_translate(name); ?>: *</label>
					<input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="requiredField <?php if($nameError != '') { ?>hightlight<?php } ?>" />
					
					
				</li>
                
				<li><label for="email"><?php tr_translate(email); ?>: *</label>
					<input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="requiredField email <?php if($emailError != '') { ?>hightlight<?php } ?>" />					
					
				</li>
                
				<li><label for="subject"><?php tr_translate(contact_subject); ?>:</label>
					<input type="text" name="subject" id="subject" value="<?php if(isset($_POST['subject']))  echo $_POST['subject'];?>" />					
					
				</li>
				
				<li class="textarea"><label for="commentsText"><?php tr_translate(contact_msg); ?>: *</label>
					<textarea name="comments" id="commentsText" rows="8" cols="60" class="requiredField <?php if($commentError != '') { ?>hightlight<?php } ?>"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
				</li>				
				<li class="buttons">
                    <input type="hidden" name="submitted" id="submitted" value="true" />
                    <button type="submit" class="button light"><?php tr_translate(submit_contact); ?></button>
                    <div class="loading"></div>
                </li>
			</ul>
		</form>
        
    </div><!-- .content End --> 
    <!-- Content End -->    
	
<?php } ?>

<?php global_template(sidebar); ?> 

<?php get_footer(); ?>