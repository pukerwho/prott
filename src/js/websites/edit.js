var $ = require("jquery");
let now = new Date();
let day = String(now.getDate()).padStart(2, '0');
let month = String(now.getMonth() + 1).padStart(2, '0');
let todayDate = day+'.'+month;
console.log(todayDate);
$('.edit-send-js').on('click', function(){
  var modalId = $(this).data('modal-id');
  var postId = $(this).data('post-id');
  let siteWeek = $('.chart-week-'+postId+'').data('week-array');
  siteWeek = siteWeek.replace(/ /g,'');
  siteWeek = siteWeek.split(',');
  console.log(siteWeek);
  if (siteWeek.includes(todayDate)) {
    let action = 'website_edit_click_action';
  } else {
    let action = 'website_add_click_action';
  }


  let editMeta = document.querySelectorAll('.edit-modal[data-modal-id='+modalId+'] .edit-meta');
  
  editMeta.forEach(function(element) {
    let metaValue = element.value;
    
    if (metaValue) {
      let metaCrb = element.dataset.crbValue;
      let data = {
        'action': action,
        'postId': postId,
        'metaValue': metaValue,
        'metaCrb': metaCrb,
        'todayDate': todayDate
      };
      $.ajax({
        url: ajaxurl, // AJAX handler
        data: data,
        type: 'POST',
        beforeSend : function(xhr) {
          $('.edit-send-js').addClass('hidden');
        },
        success : function(data) {
          if (data) {
            $('.edit-send-js').removeClass('hidden');
            console.log(data);
          }
        }
      });
    }
    
  });
})