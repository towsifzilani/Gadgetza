
'use strict';
function goBack() {
  window.history.back();
}

/* PRELOADER */

'use strict';
$(window).on('load', function() {
 $('#preloader').fadeOut('slow');
});

/* NICE-SELECT */

'use strict';
$(document).ready(function() {
  $('.nc-select').niceSelect();
});

/* FROMS */

'use strict';
  function onRecaptchaSuccess(){
    $('#submit-form').submit();
}

/* SELECT PRICE */

/*'use strict';
$(document).ready(function($){
$('.filter li a').on('click', function () {

  var plan = $(".filter li[class*='uk-active']").data('plan');

  if(plan === "monthly"){
    $(`[data-payment="monthly"]`).removeClass('uk-visible').addClass('uk-hidden');
    $(`[data-payment="annual"]`).removeClass('uk-hidden').addClass('uk-visible');
  }else if(plan === "annual"){
    $(`[data-payment="monthly"]`).removeClass('uk-hidden').addClass('uk-visible');
    $(`[data-payment="annual"]`).removeClass('uk-visible').addClass('uk-hidden');
  }

});
});*/


/* SUBMIT NO EMPTY FIELD */

'use strict';
$(document).ready(function($){

  $("#searchForm").submit(function() {
    $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
    return true;
  });

  $( "#searchForm" ).find( ":input" ).prop( "disabled", false );

});

'use strict';
$(document).ready(function(){
  $('.submit-form').on('click', function(){

  $("#searchForm").submit();

  });
});

/* CHOOSE PLAN */

'use strict';
$(document).ready(function(){
  $('.choosePlan').on('click', function(){

      let frequency = $(".tas_pricing_filter li[class*='uk-active']").data('plan'); 
      var planId = $(this).data('plan');
      window.open(SITEURL+"/pay/"+planId+"/?freq="+frequency);

  });
  
});

'use strict';
const number_format = (number, decimals, dec_point = '.', thousands_point = ',') => {

    if (number == null || !isFinite(number)) {
        // throw new TypeError('number is not valid');
    }
    
    if(!decimals) {
        let len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }
    
    number = parseFloat(number).toFixed(decimals);
    
    number = number.replace('.', dec_point);
    
    let splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);
    
    return number;
    };
    
    const nr = (number, decimals = 0) => {
        return number_format(number, decimals);
    };
    
    let calculate_prices = () => {
      
            let payment_amount = $('[name="frequency"]:checked').data('price');

            let price = parseFloat(payment_amount);

            let exclusive_taxes = 0;
            let price_without_inclusive_taxes = 0;
            let price_with_taxes = 0;

            if(codeDiscount) {
              let discount = parseInt(codeDiscount[0].percentage);
              let discount_value = parseFloat((price * discount / 100).toFixed(2));
              price = price - discount_value;
              document.querySelector('#summary_discount #discount_price').innerHTML = nr(-discount_value, 2);
            }

            /* Calculate with taxes, if any */
            if(plantaxes) {

              /* Check for the inclusives */
              let inclusive_taxes_total_percentage = 0;

              for(let row of plantaxes) {
                  if(row.tax_type == 'exclusive') continue;

                  inclusive_taxes_total_percentage += parseInt(row.tax_percentage);
              }

              let total_inclusive_tax = parseFloat((price - (price / (1 + inclusive_taxes_total_percentage / 100))).toFixed(2));

              for(let row of plantaxes) {
                  if(row.tax_type == 'exclusive') continue;

                  let percentage_of_total_inclusive_tax = parseInt(row.tax_percentage) * 100 / inclusive_taxes_total_percentage;

                  let inclusive_tax = parseFloat(total_inclusive_tax * percentage_of_total_inclusive_tax / 100).toFixed(2)

                  /* Display the value of the tax */
                  $(`#summary_tax_id_${row.tax_id} .tax-value`).html(nr(inclusive_tax, 2));

              }

              price_without_inclusive_taxes = price - total_inclusive_tax;

              /* Check for the exclusives */
              let exclusive_taxes_array = [];

              for(let row of plantaxes) {
                  if(row.tax_type == 'inclusive') continue;

                  let exclusive_tax = parseFloat(price_without_inclusive_taxes * (parseInt(row.tax_percentage) / 100));

                  exclusive_taxes_array.push(exclusive_tax);

                  $(`#summary_tax_id_${row.tax_id} .tax-value`).html(`+${nr(exclusive_tax, 2)}`);
              }

              exclusive_taxes = exclusive_taxes_array.reduce((total, number) => total + number, 0);

              /* Price with all the taxes */
              price_with_taxes = price + exclusive_taxes;

              price = price_with_taxes;

            }

            if(payment_amount){

            /* Display the price */
            document.querySelector('#summary_plan_price').innerHTML = nr(payment_amount, 2);
            $('#summary_total').html(nr(price, 2));
            $('#pay_total').html(nr(price, 2));

            }

          }
    
          let selected_frequency = () => {
            let value = $('[name="frequency"]:checked').data('freq');
            if(value){
            document.querySelector('#summary_plan_frequency').innerHTML = value;
            }

          }
    
          calculate_prices();
    
     $('[name="frequency"]').on('change', event => {
            //let value = $('[name="frequency"]:checked').data('id');
            //var key = 'freq';
            removeParam('freq');
            //window.location.reload();
            selected_frequency();
            calculate_prices();
        });
    
        selected_frequency();
  
/* COUPON CODE */

'use strict';
$('.applyCode').on("click", function(event){ 

  event.preventDefault(); 

  var $this = $('#submit-coupon');
  var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
  if ($('#submit-coupon').html() !== loadingText) {
    $this.html(loadingText);
  }

  $.ajax({
    type: 'POST',
    url: SITEURL+"/controllers/coupon.php",
    data: {
      plan:$("#planid").val(),
      frequency:$("input[type='radio'][name='frequency']:checked").data('frequency'),
      code:$("#couponcode").val(),
    },
    success: function(data) {
      var dataResult = JSON.parse(data);
        $('#coderesults').html(dataResult.message);
        $this.html($this.val());

        if(dataResult.statusCode == 200){

         codeDiscount = [
            {value: dataResult.value, discount: dataResult.discounted, percentage: dataResult.percentage},
         ];

          $('#summary_total').html(dataResult.value);
          $('#pay_total').html(dataResult.value);
          $('#discount_price').html(dataResult.discounted);
          $('#discount_percentage').html(dataResult.percentage);
          $('#summary_discount').removeClass('uk-hidden').addClass('uk-visible');
        }

        calculate_prices();

    }
  });
});

/* PAGINATION */

'use strict';
$(document).ready(function(){
  $('.change-page').on('click', function(){

    var paramName = 'p';
    var paramValue = $(this).data('page');

    var url = window.location.href;
    var hash = location.hash;
    url = url.replace(hash, '');
    if (url.indexOf(paramName + "=") >= 0)
    {
      var prefix = url.substring(0, url.indexOf(paramName + "=")); 
      var suffix = url.substring(url.indexOf(paramName + "="));
      suffix = suffix.substring(suffix.indexOf("=") + 1);
      suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
      url = prefix + paramName + "=" + paramValue + suffix;
    }
    else
    {
      if (url.indexOf("?") < 0)
        url += "?" + paramName + "=" + paramValue;
      else
        url += "&" + paramName + "=" + paramValue;
    }

    window.location.href = url + hash;

  });
  
});

/* FILTERS */

'use strict';
function removeParam(parameter){
  var url=document.location.href;
  var urlparts= url.split('?');

 if (urlparts.length>=2)
 {
  var urlBase=urlparts.shift(); 
  var queryString=urlparts.join("?"); 

  var prefix = encodeURIComponent(parameter)+'=';
  var pars = queryString.split(/[&;]/g);
  for (var i= pars.length; i-->0;)               
      if (pars[i].lastIndexOf(prefix, 0)!==-1)   
          pars.splice(i, 1);
  url = urlBase+'?'+pars.join('&');
  window.history.pushState('',document.title,url);
}
return url;
}

'use strict';
function insertParam(key, value) {

  var kvp = document.location.search.substr(1).split('&');
  if (kvp == '') {
    document.location.search = '?' + key + '=' + value;
  }else{
    var i = kvp.length; var x; while (i--) {
      x = kvp[i].split('=');
      if (x[0] == key) {
        x[1] = value;
        kvp[i] = x.join('=');
        break;
      }
    }

    if (i < 0) { kvp[kvp.length] = [key, value].join('='); }
    document.location.search = kvp.join('&');
  }
}

'use strict';
$(document).ready(function(){
  $("#filterInput_1").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#filterData_1 li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

'use strict';
$(document).ready(function(){
  $("#filterInput_2").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#filterData_2 a").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

'use strict';

'use strict';
$('.btnSubmitForm').on('click', function () {
  $('#searchForm').submit();
});

'use strict';
$('.searchForm').on("submit", function(){});

'use strict';
$('.filterTag').on('click', function () {
  
  var value = $(this).data('value');
  removeParam(value);
  window.location.reload();

});

$('.searchAllCoupon').on('submit', function(event) {
  event.preventDefault();

  // Get the value entered in the search box
  var searchQuery = $('[name="searhcCoupon"]').val().trim();

  // Check if the search query is not empty
  if (searchQuery !== "") {
      // Add or update the 'q' parameter in the URL
      insertParam('q', encodeURIComponent(searchQuery));
  }

  // Continue with the form submission logic if needed
  // ...

  // You can also redirect to the updated URL if necessary
  // window.location.href = window.location.href; 
});

$('.searchDeal').on('submit', function(event) {
  event.preventDefault();

  // Get the value entered in the search box
  var searchQuery = $('[name="searchDeal"]').val().trim();

  // Check if the search query is not empty
  if (searchQuery !== "") {
      // Add or update the 'q' parameter in the URL
      insertParam('q', encodeURIComponent(searchQuery));
  }

  // Continue with the form submission logic if needed
  // ...

  // You can also redirect to the updated URL if necessary
  // window.location.href = window.location.href; 
});

'use strict';
$(document).ready(function(){
  $(window).on("load",function(){

    $.each($(".sortBy li[class*='uk-active']").find("a"), function () {
      $('#filterBtn').text($(this).text()); 
    });
});
  
});

'use strict';
$('.sortBy li a').on('click', function () {
  var key = 'sortby';
  var value = $(this).data('value');
  insertParam(key, value);
});

'use strict';
$('.filterSubCategory li a').on('click', function () {
  var key = 'sortby';
  var value = $(this).data('value');
  insertParam(key, value);
});

'use strict';
$('.filterStore a').on('click', function () {
  var key = 'store';
  var value = $(this).data('value');
  insertParam(key, value);
});

'use strict';
$('.otherFilters2 li label').on('click', function () {
  var key = 'type';
  var value = $(this).data('value');
  insertParam(key, value);
});

'use strict';
$('.filterCategory li a span').on('click', function () {
  removeParam("subcategory");
  var key = 'category';
  var current = $(this).data('current');
  var value = $(this).data('value');

  if(current == value){
    removeParam("category");
    window.location.reload();
    }else{
      insertParam(key, value);
    }
});

'use strict';
$('.filterSubCategory li a').on('click', function () {
  var key = 'subcategory';
  var value = $(this).data('value');
  insertParam(key, value);
});

'use strict';
$('.filterLocation li label').on('click', function () {
  var key = 'location';
  var current = $(this).data('current');
  var value = $(this).data('value');

  if(current == value){
  removeParam("location");
  window.location.reload();
  }else{
    insertParam(key, value);
  }

});

'use strict';
$('.filterRating li label').on('click', function () {
  var key = 'rating';
  var value = $(this).data('value');
  insertParam(key, value);
});

'use strict';
$('.filterPrice li label').on('click', function () {
  var key = 'price';
  var value = $(this).data('value');
  insertParam(key, value);
});

'use strict';
$('.resetFilters').on('click', function () {
window.location.href = window.location.href.split('?')[0]
});

'use strict';
$('.otherFilters li label').on('click', function () {
  var key = 'filter';
  var value = $(this).data('value');
  insertParam(key, value);
});

/* LIKES */
'use strict';
$(document).ready(function(){
  $('.addfav').on('click', function(){
    var itemId = $(this).data('item');
    var userId = $(this).data('user');
    $.ajax({
      url: SITEURL+"/controllers/like.php?action=add",
      type: 'post',
      data: {
        'item': itemId,
        'user': userId
      },
      success: function(response){
        $('.like').addClass('uk-hidden uk-animation-fade');
        $('.like').siblings().removeClass('uk-hidden');
        $('#likes_count').text(response); 
      },
    });
  });

  $('.removefav').on('click', function(){
    var itemId = $(this).data('item');
    var userId = $(this).data('user');
    $.ajax({
      url: SITEURL+"/controllers/like.php?action=remove",
      type: 'post',
      data: {
        'item': itemId,
        'user': userId
      },
      success: function(response){
        $('.unlike').addClass('uk-hidden uk-animation-fade');
        $('.unlike').siblings().removeClass('uk-hidden');
        $('#likes_count').text(response); 
      }
    });
  });
});

/* FILE VALIDATION & PREVIEW */

'use strict';

$("#image-upload").on('change', function(){

  var file = this.files[0];
  var fileType = file.type;
  var match = ['image/jpeg', 'image/png', 'image/jpg'];
  if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))){
    alert('Sorry, only JPG, JPEG, & PNG files are allowed to upload.');
    $("#image-upload").val('');
    return false;
  }
});

$(document).ready(function() {
  $.uploadPreview({
    input_field: "#image-upload",
    preview_box: "#image-preview",
    label_field: "#image-label"
  });
});


/* NEWSLETTER */

'use strict';
$('.new-subscriber form').on("submit", function(event){ 

  event.preventDefault();  

  var $this = $('#submit-subscriber');
  var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
  if ($('#submit-subscriber').html() !== loadingText) {
    $this.html(loadingText);
  }

  $.ajax({
    type: 'POST',
    url: SITEURL+"/controllers/add-subscriber.php",
    data: {
      subscriber_email:$("#subscriber_email").val(),
    },
    success: function(data) {

      setTimeout(function(){
        $('#showresults').html(data);
        $this.html($this.val());
      }, 1000);

    }
  });
});

'use strict';
$('.newsletter form').on("submit", function(event){ 

  event.preventDefault();  

  var $this = $('#submit-newsletter');
  var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
  if ($('#submit-newsletter').html() !== loadingText) {
    $this.html(loadingText);
  }

  $.ajax({
    type: 'POST',
    url: SITEURL+"/controllers/add-subscriber.php",
    data: {
      subscriber_email:$("#newsletter_email").val(),
    },
    success: function(data) {

      setTimeout(function(){
        $('#getresults').html(data);
        $this.html($this.val());
      }, 1000);

    }
  });
});

/* DISABLE NICE SELECT MOBILE DEVICES */

'use strict';
$(document).ready(function() {
  checkSize();
  $(window).resize(checkSize);
});

function checkSize(){
  if (window.matchMedia("(min-width: 768px)").matches) {
    $("select").removeClass('uk-select');
    $("select").niceSelect();
    $("select").addClass('nc-select');
  } else {
    $("select").niceSelect("destroy");
    $("select").removeClass('nc-select');
    $("select").addClass('uk-select');
  }
}

/* UPDATE PROFILE */

'use strict';
$('.update-profile form').on("submit", function(event){ 

  event.preventDefault();  

  var $this = $('#submit-send');
  var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
  if ($('#submit-send').html() !== loadingText) {
    $this.html(loadingText);
  }

  $.ajax({
    type: 'POST',
    url: SITEURL+"/controllers/update-profile.php",
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData:false,
    success: function(data) {

      setTimeout(function(){
        $('#showresults').html(data);
        $this.html($this.val());
      }, 1000);

    }
  });
});

'use strict';
$(document).ready(function(){
  $('#favorites_table').on('click', '.deleteItem', function(){
    var itemId = $(this).data('item');
    var userId = $(this).data('user');
    var table = $('#favorites_table').DataTable();
    $.ajax({
      url: SITEURL+"/controllers/like.php?action=remove",
      type: 'post',
      data: {
        'item': itemId,
        'user': userId
      },
      success: function(response){
                //UIkit.notification('This Favorite Has Been Removed', 'success');
                table.ajax.reload();
              }
            });
  });
});

/* REPORT FORM */

'use strict';
$(document).ready(function(){
 $('#reportForm').on("submit", function(event){  

  event.preventDefault();

  var $this = $('#btn-report');
  var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
  if ($('#btn-report').html() !== loadingText) {
    $this.html(loadingText);
  }

  $.ajax({  
    url: SITEURL+"/controllers/report.php",
    method:"POST",  
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData:false,
    success: function(data) {

      setTimeout(function(){
        $('#showReportresults').html(data);
        $this.html($this.val());

        $("#reportForm")[0].reset();
        $('.form_fields').hide();

      }, 1000);

    } 
   });

  });  
 });

/* SUBMIT RATING */

$(document).ready(function () {
  $("#rating-form").niceSelect("destroy");
});


$(document).ready(function () {
  $('#rating-form').barrating({
    theme: 'css-stars',
    showSelectedRating: false,
  });
});

'use strict';
$(document).ready(function(){
 $('#formRating').on("submit", function(event){  

  event.preventDefault();

  var $this = $('#btn-review');
  var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
  if ($('#btn-review').html() !== loadingText) {
    $this.html(loadingText);
  }

  $.ajax({  
    url: SITEURL+"/controllers/add-review.php",
    method:"POST",  
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData:false,
    success: function(data) {

      setTimeout(function(){
        $("#formRating")[0].reset();
        $('.form_fields').hide();
        $('#showReviewresults').html(data);
        $this.html($this.val());
      }, 1000);

    } 
   });

  });  
 });

/* GET REVIEWS */

  $(document).ready(function () {
    $(document).on('click', '#loadBtn', function () {
      var limit = Number($('#limit').val());
      var id = Number($('#itemId').val());
      var page = Number($('#page').val())+1;
      var count = Number($('#itemsCount').val());

      $('#page').val(page);

      var $this = $('#loadBtn');
      var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
      if ($('#loadBtn').html() !== loadingText) {
        $this.html(loadingText);
      }
      
      $.ajax({
        type: 'POST',
        url: SITEURL+"/controllers/reviews.php",
        data: {
          'page': page,
          'id': id
        },
        success: function (data) {
          var rowCount = page + limit;
          $('#content').append(data);
          if (rowCount+1 >= count) {
            $('#loadBtn').css("display", "none");
          } else {
            $this.html($this.val());
          }
        }
      });
    });
  });