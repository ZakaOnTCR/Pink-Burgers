jQuery( document ).ready( function($) {

	jQuery('.row.flex-content.row1 .container.slick').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 5000,
		arrows: false,
		dots: true,
		infinite: true,
        pauseOnHover: false,
	});

});