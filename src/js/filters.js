var $ = require("jquery");

//Mobile Show/Hidden
$(".filter-open-js").on("click", function(){
  $(".filter-card-js").toggle(".hidden");
});

$(".average-check-value-js").on("change", function () {
  var averageValue = $(".average-check-value-js").val();
  $(".average-check-value-html-js").html(averageValue);
});

$(".city-filter-submit-js").on("click", function () {
  let category_id = $(".category-filter-id").val();
  let averageCheckValue = $(".average-check-value-js").val();
  console.log(averageCheckValue);
  console.log(category_id);
  let keyArray = [];
  let checkedInputs = document.querySelectorAll(".filter-checkbox:checked");
  for (checkedInput of checkedInputs) {
    let checkedKey = checkedInput.dataset.key;
    keyArray.push(checkedKey);
  }
  $.ajax({
    type: "POST",
    url: "/wp-admin/admin-ajax.php",
    dataType: "html",
    data: {
      action: "filter_places_click_action",
      category_id: category_id,
      averageCheckValue: averageCheckValue,
      keyArray: keyArray,
    },
    beforeSend: function() {
      $(".filter-button").removeClass('city-filter-submit-js');
      $(".filter-button").addClass('bg-black/80');
      console.log("before");
    },
    success: function (res) {
      $("#response").html(res);
      $(".filter-button").addClass('city-filter-submit-js');
      $(".filter-button").removeClass('bg-black/80');
      $([document.documentElement, document.body]).animate({
        scrollTop: $("#response").offset().top - 50
      }, 500);
      console.log("відповідь");
      // closeModal();
    },
  });
});
