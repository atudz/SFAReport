/**
 * Add all scripts here for the site.
 */

jQuery(document).ready(function(){
	
	// Blog post button redirect
	jQuery('#add_blog').click(function(){
		window.location.href = "BlogPost/add";
	})
	
	
	// home logo redirect
	jQuery('#home').click(function(){
		window.location.href = "/"
	});
});