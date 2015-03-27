// Make a company.project namespace
var erm = erm || {};
erm.emenu = erm.emenu || {};
// My global variable is now restricted and shouldn't collide.
erm.emenu.editing = false;

erm.emenu.hideNavbar = function() {
	var $navbar = $(".collapse.navbar-collapse"); // .class1.class2 checks to see if it belongs to BOTH class1 and class2.
	if ($navbar.hasClass("in")) {
		$navbar.collapse("hide");
	}
};

erm.emenu.enableButtons = function() {
	$("#toggle-edit").click(function() {
		if (erm.emenu.editing) {
			erm.emenu.editing = false;
			$(".edit-actions").addClass("hidden");
			$(".edit-actions-hidden").removeClass("hidden");
			$(this).html(editVar);
		} else {
			erm.emenu.editing = true;
			$(".edit-actions").removeClass("hidden");
			$(".edit-actions-hidden").addClass("hidden");
			$(this).html(doneVar);
		}
		erm.emenu.hideNavbar();
	});

	$(".edit-cuisine").click(function() {
		cuisineName = $(this).find(".cuisineName").html();
		console.log("name: " + cuisineName);
		$("#edit-cuisine-modal input[name=cuisineName]").val(cuisineName);

		retailPrice = $(this).find(".retailPrice").html();
		console.log("price: " + retailPrice);
		$("#edit-cuisine-modal input[name=retailPrice]").val(retailPrice);

		description = $(this).find(".description").html();
		console.log("description: " + description);
		$("#edit-cuisine-modal textarea[name=description]").val(description);

		cuisineTypeID = $(this).find(".cuisineTypeID").html();
		console.log("typeID: " + cuisineTypeID);
		if (cuisineTypeID == "") {
			$("#edit-cuisine-modal select[name=cuisine_type]").find("option[value=NULL]").attr("selected", true);
		} else {
			$("#edit-cuisine-modal select[name=cuisine_type]").find("option[value="+ cuisineTypeID +"]").attr("selected", true);
		}

		dailyspecial = $(this).find(".dailyspecial").html();
		console.log("dailyspecial: " + dailyspecial);
		if (dailyspecial == "1") {
			$("#edit-cuisine-modal input[name=dailyspecial]").attr("checked", true);
		};

		specialPrice = $(this).find(".specialPrice").html();
		console.log("special price: " + specialPrice);
		$("#edit-cuisine-modal input[name=specialPrice]").val(specialPrice);
		
		cuisineID = $(this).find(".cuisineID").html();
		console.log("EDIT ID: " + cuisineID);
		$("#edit-cuisine-modal input[name=cuisineID]").val(cuisineID).prop("disabled", false);
	});

	$(".edit-dailyspecialcuisine").click(function() {
		cuisineName = $(this).find(".cuisineName").html();
		console.log("name: " + cuisineName);
		$("#edit-dailyspecialcuisine-mode .specialCuisineName").html(cuisineName);

		specialPrice = $(this).find(".specialPrice").html();
		console.log("price: " + specialPrice);
		$("#edit-dailyspecialcuisine-mode input[name=specialPrice]").val(specialPrice);

		cuisineID = $(this).find(".cuisineID").html();
		console.log("EDIT DAILY SPECIAL ID: " + cuisineID);
		$("#edit-dailyspecialcuisine-mode input[name=cuisineID]").val(cuisineID).prop("disabled", false);
	});

	$(".delete-cuisine").click(function() {
		cuisineID = $(this).find(".cuisineID").html();
		console.log("DELETE ID: " + cuisineID);
		$("#delete-cuisine-modal input[name=cuisineID]").val(cuisineID).prop("disabled", false);
	});

	$(".delete-cuisine-type").click(function() {
		typeID = $(this).find(".typeID").html();
		console.log("DELETE TYPE ID: " + typeID);
		$("#delete-cuisine-type-modal input[name=typeID]").val(typeID).prop("disabled", false);
	});

	$("#add-cuisine-type").click(function() {
		console.log("TYPE ID: " + lastSortOrder);
		$("#insert-cuisine-type-modal input[name=lastSortOrder]").val(lastSortOrder).prop("disabled", false);
	});

	$(".insert-cuisine-step1-next").click(function() {
		name_ch = $("#insert-cuisine-step1-modal input[name=cuisine_name_ch]").val();
		console.log("Name in Chinese: " + name_ch);
		$("#insert-cuisine-step4-modal input[name=cuisine_name_ch]").val(name_ch);

		name_en = $("#insert-cuisine-step1-modal input[name=cuisine_name_en]").val();
		console.log("Name in English: " + name_en);
		$("#insert-cuisine-step4-modal input[name=cuisine_name_en]").val(name_en);

		description_ch = $("#insert-cuisine-step1-modal textarea[name=cuisine_description_ch]").val();
		console.log("Description in Chinese: " + description_ch);
		$("#insert-cuisine-step4-modal textarea[name=cuisine_description_ch]").val(description_ch);

		description_en = $("#insert-cuisine-step1-modal textarea[name=cuisine_description_en]").val();
		console.log("Description in English: " + description_en);
		$("#insert-cuisine-step4-modal textarea[name=cuisine_description_en]").val(description_en);
	});

	$(".insert-cuisine-step2-next").click(function() {
		typeID = $("#insert-cuisine-step2-modal select[name=cuisine_type]").val();
		console.log("Cuisine Type: " + typeID);
		$("#insert-cuisine-step4-modal input[name=cuisine_typeID]").val(typeID);
	});

	$(".insert-cuisine-step3-next").click(function() {
		price = $("#insert-cuisine-step3-modal input[name=cuisine_price]").val();
		console.log("retail price: " + price);
		$("#insert-cuisine-step4-modal input[name=cuisine_retailPrice]").val(price);
	});
};

$(document).ready(function() {
	erm.emenu.enableButtons();
	//erm.emenu.addEventHandlers();
});