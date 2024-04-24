function go_to_button(target,pos){
	
	var target = target;
	var pos = pos;
	if(target.length){
		next = jQuery(target);
		if(next.length){
			jQuery('html, body').animate({
				scrollTop: next.offset().top - pos
			}, 'slow');
		}else{
			console.log('Het element die is ingsteld als target bestaat niet controller je button shortcode');
		}
	}
}