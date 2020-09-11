jQuery(document).ready( function($) {
	$(".user_like").click( function(e) {
		e.preventDefault();
		post_id = jQuery(this).attr("data-post_id");
		nonce = jQuery(this).attr("data-nonce");
		$.ajax({
			type : "POST",
			async: true,
			dataType : "json",
			url : myAjax.ajaxurl,
			data : {action: 'my_user_like', post_id : post_id, nonce: nonce},
			success: function(result, status, xhr) {
				if(result.type == 'success') {
					$("#like_counter").html(result.like_count);
				}
				else {
					alert("Your like could not be added");
				}
			}
		});
	});
});