/* Based on http://wordpress.org/extend/plugins/social-connect/ */
(function() {
	jQuery(".wsl_connect_with_provider").click(function(){
		popupurl = jQuery("#wsl_popup_base_url").val();
		provider = jQuery(this).attr("data-provider");

		window.open(
			popupurl+"provider="+provider,
			"hybridauth_social_sing_on", 
			"location=1,status=0,scrollbars=0,width=1000,height=600"
		); 
	});
})();

window.wsl_wordpress_social_login = function(config) {
	jQuery('#loginform').unbind('submit.simplemodal-login');

	var form_id = '#loginform';

	if(!jQuery('#loginform').length) {
		// if register form exists, just use that
		if( jQuery('#registerform').length ) {
			form_id = '#registerform';
		} 
		else {
			// create the login form
			var login_uri = jQuery("#wsl_login_form_uri").val();

			jQuery('body').append("<form id='loginform' method='post' action='" + login_uri + "'></form>");
			jQuery('#loginform').append("<input type='hidden' id='redirect_to' name='redirect_to' value='" + window.location.href + "'>");
		}
	}

	jQuery.each(config, function(key, value) { 
		jQuery("#" + key).remove();
		jQuery(form_id).append("<input type='hidden' id='" + key + "' name='" + key + "' value='" + value + "'>");
	});  

	if(jQuery("#simplemodal-login-form").length) {
		var current_url = window.location.href;
		jQuery("#redirect_to").remove();
		jQuery(form_id).append("<input type='hidden' id='redirect_to' name='redirect_to' value='" + current_url + "'>");
	}

	jQuery(form_id).submit();
}
