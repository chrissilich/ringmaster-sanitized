$(document).ready(function(){

	$(".join-box #showJoinCodeButton").on("click", function() {
		$(".join-box *").show();
		$(this).hide();

		if ($("#joinCode").text().indexOf("generating") != -1) {
			$(".join-box #newJoinCode").click();
		}
	})

	$(".join-box #hideJoinCodeButton").on("click", function() {
		$(".join-box *").hide();
		$(".join-box #showJoinCodeButton").show();
	})


	$(".join-box #newJoinCode").on("click", function(e) {
		e.preventDefault();
		$.ajax($(this).attr("href"), {
			dataType: "json",
			success: function(response) {
				//console.log(response);
				$("#joinCode").html(response.message);
			},
			error: function() {
				$("#joinCode").html("<em>New code couldn't be generated</em>");
			}
		});
	});






	if ($("table#grades").hasClass("admin")) {


		$(".hide-zeros").on("click", function() {
			$(this).hide();
			$(".show-zeros").show();
			$("tr.weight-row input").each(function() {
				if ($(this).val() == "" ||$(this).val() == 0) {
					var aID = $(this).parents("th").attr("data-assignment-id");
					$("#grades [data-assignment-id="+aID+"]").hide();
				}
			})
		})

		$(".show-zeros").hide().on("click", function() {
			$(this).hide();
			$(".hide-zeros").show();
			$("#grades [data-assignment-id]").show();
		});



		$(".grade-row input, .weight-row input").on("blur", function() {
			var g = normalizeNumber($(this).val());
			if (g || g == 0) {
				$(this).val(g);				
			} else {
				$(this).val(null);
			}
		})

		

		var gradeAjaxTimeout;
		$(".grade-row input, .grade-row textarea").on("keyup", function() {
			clearTimeout(gradeAjaxTimeout);
			gradeAjaxTimeout = setTimeout(sendGradeUpdates, 1000);
		});
		$(".grade-row input, .grade-row textarea").on("keyup", function() {
			$(this).parents("td").find("input").addClass("unsynced");
		});
		$(".grade-row textarea").on("keyup", function() {
			if ($(this).val()) {
				$(this).addClass("commented");
			} else {
				$(this).removeClass("commented");
			}
		});


		var weightAjaxTimeout;
		$(".weight-row input").on("keyup", function() {
			clearTimeout(weightAjaxTimeout);
			weightAjaxTimeout = setTimeout(sendWeightUpdates, 1000);
		});
		$(".weight-row input").on("keyup", function() {
			$(this).addClass("unsynced-weight");
		});

		recalculateGrades();
	}

});


function sendGradeUpdates() {
	console.log("sendGradeUpdates");
	recalculateGrades();

	var data = {grades: []};
	$(".grade-row input.unsynced").removeClass("unsynced").addClass("syncing").each(function() {
		var dto = {
			assignment_id: 	$(this).attr("data-assignment-id"),
			user_id: 		$(this).attr("data-user-id"),
			new_value: 		normalizeNumber($(this).val()),
			comment: 		$(this).siblings("textarea").val()
		};
		// console.log(dto);
		data.grades.push(dto);
	})
	// console.log(data.grades);

	if (data.grades.length) {
		$.post(ajaxGradeSaveURI, data, function(response) {
			// console.log(response);
			if (response.status == "success") {
				$(".syncing").parent().addClass("has-success");
				setTimeout(function() {
					$(".syncing").parent().removeClass("has-success");
					$(".syncing").removeClass("syncing");
				}, 1500)
			} else {
				// TODO make a popup that says the error
				$(".syncing").parent().removeClass("has-success").addClass("has-error");
				$(".syncing").removeClass("syncing").addClass("has-error");
			}
		}, "json");
	}
}


function sendWeightUpdates() {
	console.log("sendWeightUpdates");
	recalculateGrades();

	var data = {weights: []};
	$(".weight-row input.unsynced-weight").removeClass("unsynced-weight").addClass("syncing-weight").each(function() {
		data.weights.push({
			assignment_id: 	$(this).attr("data-assignment-id"),
			new_value: 		normalizeNumber($(this).val())
		});
		
	})
	console.log(data.weights);

	if (data.weights.length) {
		$.post(ajaxWeightSaveURI, data, function(response) {
			if (response.status == "success") {
				$(".syncing-weight").parent().addClass("has-success");
				setTimeout(function() {
					$(".syncing-weight").parent().removeClass("has-success");
					$(".syncing-weight").removeClass("syncing-weight");
				}, 1500)
			} else {
				// TODO make a popup that says the error
				$(".syncing-weight").parent().removeClass("has-success").addClass("has-error");
				$(".syncing-weight").removeClass("syncing").addClass("has-error");
			}
		}, "json");
	}
}


function recalculateGrades() {
	
	var assignmentCount = $(".assignment-header").length;
	console.log("assignmentCount: " + assignmentCount);

	var weights = [];
	var total_weight = 0;
	$(".weight-row th input").each(function() {
		weights.push( normalizeNumber( $(this).val() ) )
		total_weight += normalizeNumber( $(this).val() );
	})
	$(".weight-row .calculated").text(total_weight);
	//if (total_weight != 100) {
	//	$(".weight-row .calculated").css("color", "red");
	//} else {
	//	$(".weight-row .calculated").css("color", "black");
	//}

	$(".grade-row").each(function() {
		var calc = 0;
		
		$(this).find("input").each(function(i) {
			calc += ( normalizeNumber($(this).val()) * weights[i] );
		})
		if (calc) {
			var calculated = calc / total_weight;
			$(this).find(".calculated").text(calculated.toFixed(2));
		} else {
			$(this).find(".calculated").text("?");
		}
	})
}



function normalizeNumber(n) {
	if (typeof n == "string") {
		if (n.trim() == "") return null;
		if (n.trim() == "%") return null;
		if (parseFloat(n.trim()) != NaN) return parseFloat(n.trim());
		return null;
	}
	if (typeof n == "number") return n;
	return null;
}