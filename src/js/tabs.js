var $ = require("jquery");
$('.tab').on('click', function(){
  let tabData = $(this).data('tab');
  $('.tab-content').addClass('hidden');
  $('.tab-content[data-content="'+tabData+'"]').removeClass('hidden');
  $('.tab').removeClass('active');
  $('.tab[data-tab="'+tabData+'"]').addClass('active');
});