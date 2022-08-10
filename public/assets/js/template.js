
$(document).ready(function(){

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	// enable intro.js
	//introJs().start();



	// header bar ball animation
	if ($.cookie('ball')) {
		//console.log("no animate");
		$(".navbar-brand img").addClass("animate");
	} else {
		//console.log("animate");
		$(".navbar-brand img").addClass("transition");
		setTimeout(function() {
			$(".navbar-brand img").addClass("animate");
		}, 500)
		$.cookie('ball', "rolled", {expires: 1, path: "/"});
	}




	// any links with .ajax-modal, make them load over ajax, they should be pointing to a modal
	$(document).on("click", ".ajax-modal", function(e) {
		e.preventDefault();

		console.log("show modal from", $(this).attr("href"));

		$(".modal-backdrop").remove();

		$("#ajax-modals").empty().load($(this).attr("href"), function() {
			$("#ajax-modals").find(".modal").not("dying").modal();
		});
	})



	// any forms with .ajax-modal-form, make them submit over ajax, and on success, close the modal
	$("body").on("submit", ".ajax-modal-form", function(e) {
		e.preventDefault();

		console.log("submit modal as ajax");

		var $modal = $(this).parents(".modal");
		var $form = $(this);

		$(this).find("[type='submit']").attr("disabled", 1);
		$("<span class='micro-loader'></span>").prependTo( $(this).parents(".modal").find(".modal-footer") );

		//console.log(new FormData(this)); return;

		$.ajax($(this).attr("action"), {
			type: "POST",
			data: new FormData(this),
			processData: false,
      		contentType: false,
      		dataType: "json"

		}).done(function(response) {

			$modal.find(".micro-loader").remove();
			$form.find("[type='submit']").attr("disabled", false);

			if (response.status == "success") {
				
				$(".modal").modal("hide");

				if ($form.find("[name=success_redirect]").length) {
					document.location.href = $form.find("[name=success_redirect]").val();
				} else if (response.data && response.data.redirect) {
					document.location.href = response.data.redirect;
				}
				if (response.data && response.data.refresh) {
					location.reload();
				}

			} else if (response.status == "fail") {
				$(".modal .has-error").removeClass("has-error");
				$(".modal .help-block").empty();

				if (response.data && response.data.validation) {
					for (var field in response.data.validation) {
						$(".modal [name='"+field+"']").siblings(".help-block").text( response.data.validation[field][0] ).parent().addClass("has-error")
					}
				}

			} else {
				// errors, and anything else
				var text = "Something went wrong and we don't have an error code.";
				if (response.message) {
					text = response.message;
				}
				if (response.data.code) {
					text += "<br>Error code: " + response.data.code;
				}
				$('<div class="alert alert-danger" role="alert">'+text+'</div>').appendTo(".modal .modal-body").delay(3000).fadeOut();
			}

		});
	})

	// any forms that are just ajax-form should be done over ajax, but without all the modal junk
	$("body").on("submit", ".ajax-form", function(e) {
		e.preventDefault();
		console.log("submit as ajax");

		var $form = $(this);

		$form.find("[type='submit']").attr("disabled", 1);
		$("<span class='micro-loader'></span>").insertBefore( $form.find("[type='submit']") );

		$.ajax($(this).attr("action"), {
			type: "POST",
			data: new FormData(this),
			processData: false,
      		contentType: false,
      		dataType: "json"

		}).done(function(response) {

			$form.find("[type='submit']").attr("disabled", false);

			if (response.status == "success") {

				if ($form.find("[name=success_redirect]").length) {
					document.location.href = $form.find("[name=success_redirect]").val();
				} else if (response.data && response.data.redirect) {
					document.location.href = response.data.redirect;
				}
				if (response.data && response.data.refresh) {
					location.reload();
				}

			} else if (response.status == "fail") {

				$form.find(".has-error").removeClass("has-error");
				$form.find(".help-block").empty();

				if (response.data && response.data.validation) {
					for (var field in response.data.validation) {
						$(".modal [name='"+field+"']").siblings(".help-block").text( response.data.validation[field][0] ).parent().addClass("has-error")
					}
				}

			} else {
				// errors, and anything else
				var text = "Something went wrong and we don't have an error code.";
				if (response.message) {
					text = response.message;
				}
				if (response.code) {
					text += "<br>Error code: " + response.code;
				}
				$('<div class="alert alert-danger" role="alert">'+text+'</div>').prependTo($form).delay(3000).fadeOut();
			
			}

		});
	})
	
	// any link with class ajax-simple should be done over ajax
	$("body").on("click", ".ajax-simple", function(e) {
		e.preventDefault();
		console.log("submit as ajax");

		var $element = $(this);

		if ($element.hasClass("btn")) $element.attr("disabled", "disabled");

		var type = $(this).attr("method") ? $(this).attr("method") : "POST";

		$.ajax($element.attr("href"), {
			type: type,
			contentType: false,
      		dataType: "json"

		}).done(function(response) {

			if ($element.hasClass("btn")) $element.removeAttr("disabled");

			if (response.status == "success") {

				if (response.data && response.data.redirect) {
					document.location.href = response.data.redirect;
				}
				if (response.data && response.data.refresh) {
					location.reload();
				}

			} else if (response.status == "fail") {

			} else {
				
			}

		})
	});

	
	// any datepickers anywhere
	$('.datepicker').datepicker({format: "mm-dd-yyyy"});
	$('.timepicker').timepicker({template: "dropdown"});

	$('body').on('shown.bs.modal', function (e) {
		$('.modal .datepicker').datepicker({format: "mm-dd-yyyy"});
		$('.modal .timepicker').timepicker({template: "dropdown"});
		$('.modal form input:visible, .modal form textarea:visible').first().focus();
	})



	// readmore text areas
	$(".read-more").each(function() {
		console.log($(this).height());
		if ($(this).height() < 42) {
			// short response, therefore no expansion/contraction
		} else {
			console.log("add button");
			$("<button class='btn btn-xs btn-default read-more-expand'>Read More</button>").insertAfter(this);
		}
	})

	$(".read-more-expand").on("click", function() {
		if ($(this).hasClass("expanded")) {
			// already expanded
			$(this).text("Read More").prev().removeClass("read-more-expanded");
		} else {
			// not expanded
			$(this).text("Read Less").prev().addClass("read-more-expanded");
		}

		$(this).toggleClass("expanded");
	})



	// connect buttons that have a data-show-element attribute to the elements theyre meant to show
	$("[data-show-element]").on("click", function() {
		console.log("show hide button clicked");
		$(this).hide();
		var elSelector = $(this).attr("data-show-element");
		console.log(elSelector);
		$(elSelector).show();
	})



	// make all tabbed nav save cookies so when we return to that page, it opens the last tab automatically
	$("ul.nav-tabs li").on("click", function() {
		saveTabCookie($(this));
	})

	// if there's a show GET variable, 
	if (_GET("show")) {
		// remove it from the address bar
		// console.log("show", _GET("show"));
		window.history.pushState(null, null, document.URL.replace("?show="+_GET("show"), ""));
		
		// and save it as a cookie that we're here.
		saveTabCookie($("ul.nav-tabs li.active"));

	} else {

		// check for a cookie matching the above, and if found, click that tab
		var cookieName = 'tab-'+document.URL.replace("/", "").replace(":", "");
		if ($.cookie(cookieName)) {
			console.log("found cookie for ",cookieName );
			$("ul.nav-tabs li a[href='"+$.cookie(cookieName)+"']").click();
		}

	}


	function saveTabCookie($li) {
		console.log("saveTabCookie", $li);
		var cookieName = 'tab-'+document.URL.replace("/", "").replace(":", "").replace("%", "").replace("#", "");
		var cookieValue = $li.find("a[role='tab']").attr("href");
		cookieName.replace(cookieValue, "");
		console.log(cookieName, cookieValue);
		$.cookie(cookieName, cookieValue);
	}

});


