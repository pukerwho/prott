var $ = require("jquery");

const addForm = document.querySelector("#form_add");
if (addForm) {
  addForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const title = document.querySelector('#title-place').value;
    const city = document.querySelector('#city-place').value;
    const email = document.querySelector('#email-place').value;
    const phone = document.querySelector('#phone-place').value;
    const address = document.querySelector('#address-place').value;
    const menu = document.querySelector('#menu-place').value;
    const price = document.querySelector('#price-place').value;
    const parkingCheckbox = document.querySelector('#parking-checkbox').checked;
    const wifiCheckbox = document.querySelector('#wifi-checkbox').checked;
    const banketCheckbox = document.querySelector('#banket-checkbox').checked;
    const menuCheckbox = document.querySelector('#menu-checkbox').checked;
    const summerCheckbox = document.querySelector('#summer-checkbox').checked;
    const musicCheckbox = document.querySelector('#music-checkbox').checked;
    const hookanCheckbox = document.querySelector('#hookan-checkbox').checked;
    const vipCheckbox = document.querySelector('#vip-checkbox').checked;
    const biznesCheckbox = document.querySelector('#biznes-checkbox').checked;
    const deliveryCheckbox = document.querySelector('#delivery-checkbox').checked;
    const kidsCheckbox = document.querySelector('#kids-checkbox').checked;
    const corpCheckbox = document.querySelector('#corp-checkbox').checked;
    const weddingCheckbox = document.querySelector('#wedding-checkbox').checked;
    const cardCheckbox = document.querySelector('#card-checkbox').checked;
    let data = {
      'action': 'telegram_add_action',
      'title': title,
      'city': city,
      'email': email,
      'phone': phone,
      'address': address,
      'menu': menu,
      'price': price,
      'parkingCheckbox': parkingCheckbox,
      'wifiCheckbox': wifiCheckbox,
      'banketCheckbox': banketCheckbox,
      'menuCheckbox': menuCheckbox,
      'summerCheckbox': summerCheckbox,
      'musicCheckbox': musicCheckbox,
      'hookanCheckbox': hookanCheckbox,
      'vipCheckbox': vipCheckbox,
      'biznesCheckbox': biznesCheckbox,
      'deliveryCheckbox': deliveryCheckbox,
      'kidsCheckbox': kidsCheckbox,
      'corpCheckbox': corpCheckbox,
      'weddingCheckbox': weddingCheckbox,
      'cardCheckbox': cardCheckbox,
    };
    $.ajax({
      url: ajaxurl,
      data: data,
      type: 'POST',
      beforeSend : function(xhr) {
        console.log('Загружаю')
      },
      success : function(data) {
        if (data) {
          console.log("відправили");
          addForm.reset();       
          document.querySelector(".add-success").classList.remove("hidden");  
        }
      }
    });
    return;
  })
}