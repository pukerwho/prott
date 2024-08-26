var $ = require("jquery");

$('.detail-click-js').on("click", function(){
  let detailId = $(this).data('detail-id');
  $('.detail-modal[data-detail-modal='+detailId+']').addClass('open');
  $('.modal-bg').addClass('open');
  $('body').addClass('overflow-hidden');
});

$('.date-click-js').on("click", function(){
  let dateId = $(this).data('date-id');
  $('.date-modal[data-date-modal='+dateId+']').addClass('open');
  $('.modal-bg').addClass('open');
  $('body').addClass('overflow-hidden');
});

$('.value-modal-js').on("click", function(){
  let modalId = $(this).data('modal-id');
  $('.chart-modal[data-modal-id='+modalId+']').addClass('open');
  $('.modal-bg').addClass('open');
  $('body').addClass('overflow-hidden');
});

$('.edit-modal-js').on("click", function(){
  let modalId = $(this).data('modal-id');
  $('.edit-modal[data-modal-id='+modalId+']').addClass('open');
  $('.modal-bg').addClass('open');
  $('body').addClass('overflow-hidden');
});

document.addEventListener('click', function(e){
  if(e.target.classList.value === 'modal-content') {
    $('.modal-bg').removeClass('open');
    $('.detail-modal').removeClass('open');
    $('.date-modal').removeClass('open');
    $('.chart-modal').removeClass('open');
    $('.edit-modal').removeClass('open');
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