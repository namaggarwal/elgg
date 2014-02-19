	$(document).ready(function(){

		$(".listentry h3:first").addClass("active");
		$(".listentry p:not(:first)").hide();

		$(".listentry h3").click(function(){
			$(this).next("p").slideToggle("slow")
			.siblings("p:visible").slideUp("slow");
			$(this).toggleClass("active");
			$(this).siblings("h3").removeClass("active");
	});

});
