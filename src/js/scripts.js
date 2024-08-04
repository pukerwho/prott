var $ = require("jquery");

$('.detail-click-js').on("click", function(){
  let detailId = $(this).data('detail-id');
  $('.detail-modal[data-detail-modal='+detailId+']').addClass('open');
  $('.modal-bg').addClass('open');
  $('body').addClass('overflow-hidden');
});

document.addEventListener('click', function(e){
  if(e.target.classList.value === 'modal-content') {
    $('.modal-bg').removeClass('open');
    $('.detail-modal').removeClass('open');
    $('body').removeClass('overflow-hidden');
  }
});

var clipboard = new Clipboard('.copy-click');

clipboard.on('success', function(e) {
  $('.copy-tooltip[data-copy-text="'+e.text+'"]').removeClass('hidden');
  setTimeout(function(){
    $('.copy-tooltip[data-copy-text="'+e.text+'"]').addClass('hidden');
  }, 2000);
});