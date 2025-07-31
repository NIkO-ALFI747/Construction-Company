/* Flexslider Documentation:
https://github.com/woocommerce/FlexSlider/wiki/FlexSlider-Properties
*/

$(document).ready(function() {
  $('.flexslider').flexslider({
    animation: "slide",
	animationLoop: true,
	pausePlay: true,
	mousewheel: false,
	rtl: true,
  });
});