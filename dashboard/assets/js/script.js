/* UPDATE ITEM FORM */

'use strict';
  $('#update-form').on("submit", function(event){ 
  
    event.preventDefault();  
  
    tinyMCE.triggerSave();

    var $this = $('#loading');
    var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
    if ($('#loading').html() !== loadingText) {
      $this.html(loadingText);
    }
  
    $.ajax({
      type: 'POST',
      url: SITEURL+"/dashboard/update_item_ajax.php",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(response) {
          
        let dataJson = JSON.parse(response);

        if(dataJson['validations'].length > 0){
          $('#successMsg').empty();
          $('#errorsMsg').empty();
          $.each(dataJson['validations'], function(i, obj) {
              $('#errorsMsg').append('<li>' + obj + '</li>');
          });
  
          $('#success').hide();
          $('#errors').show();
        }

        if(dataJson['errors'].length > 0){
          $('#successMsg').empty();
          $('#errorsMsg').empty();
          $.each(dataJson['errors'], function(i, obj) {
              $('#errorsMsg').append('<li>' + obj + '</li>');
          });
  
          $('#success').hide();
          $('#errors').show();
        }

        if(dataJson['success'].length > 0){
          $('#errorsMsg').empty();
          $('#successMsg').empty();
          $.each(dataJson['success'], function(i, obj) {
              $('#successMsg').append('<li>' + obj + '</li>');
          });

          $(document).ajaxStop(function(){
            setTimeout(function(){// wait for 5 secs(2)
            window.location.reload();
         }, 3500); 
        });
  
          $('#errors').hide();
          $('#success').show();
        }
        
        $this.html($this.val());
        $('html, body').animate({ scrollTop: 0 }, 'slow');

      }
    });
  });

/* UPDATE SELLER FORM */

'use strict';
$('#profile-update-form').on("submit", function(event){ 

  event.preventDefault();  

  var $this = $('#loading');
  var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
  if ($('#loading').html() !== loadingText) {
    $this.html(loadingText);
  }

  $.ajax({
    type: 'POST',
    url: SITEURL+"/dashboard/update_profile_ajax.php",
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData:false,
    success: function(response) {
        
      let dataJson = JSON.parse(response);

      if(dataJson['validations'].length > 0){
        $('#successMsg').empty();
        $('#errorsMsg').empty();
        $.each(dataJson['validations'], function(i, obj) {
            $('#errorsMsg').append('<li>' + obj + '</li>');
        });

        $('#success').hide();
        $('#errors').show();
      }

      if(dataJson['errors'].length > 0){
        $('#successMsg').empty();
        $('#errorsMsg').empty();
        $.each(dataJson['errors'], function(i, obj) {
            $('#errorsMsg').append('<li>' + obj + '</li>');
        });

        $('#success').hide();
        $('#errors').show();
      }

      if(dataJson['success'].length > 0){
        $('#errorsMsg').empty();
        $('#successMsg').empty();
        $.each(dataJson['success'], function(i, obj) {
            $('#successMsg').append('<li>' + obj + '</li>');
        });

        $(document).ajaxStop(function(){
          setTimeout(function(){// wait for 5 secs(2)
          window.location.reload();
       }, 3500); 
      });

        $('#errors').hide();
        $('#success').show();
      }
      
      $this.html($this.val());
      $('html, body').animate({ scrollTop: 0 }, 'slow');

    }
  });
});

  /* UPDATE SELLER FORM */

'use strict';
$('#seller-update-form').on("submit", function(event){ 

  event.preventDefault(); 
  
  var $this = $('#loading');
  var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
  if ($('#loading').html() !== loadingText) {
    $this.html(loadingText);
  }

  $.ajax({
    type: 'POST',
    url: SITEURL+"/dashboard/update_seller_ajax.php",
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData:false,
    success: function(response) {
        
      let dataJson = JSON.parse(response);

      if(dataJson['validations'].length > 0){
        $('#successMsg').empty();
        $('#errorsMsg').empty();
        $.each(dataJson['validations'], function(i, obj) {
            $('#errorsMsg').append('<li>' + obj + '</li>');
        });

        $('#success').hide();
        $('#errors').show();
      }

      if(dataJson['errors'].length > 0){
        $('#successMsg').empty();
        $('#errorsMsg').empty();
        $.each(dataJson['errors'], function(i, obj) {
            $('#errorsMsg').append('<li>' + obj + '</li>');
        });

        $('#success').hide();
        $('#errors').show();
      }

      if(dataJson['success'].length > 0){
        $('#errorsMsg').empty();
        $('#successMsg').empty();
        $.each(dataJson['success'], function(i, obj) {
            $('#successMsg').append('<li>' + obj + '</li>');
        });

        $(document).ajaxStop(function(){
          setTimeout(function(){// wait for 5 secs(2)
          window.location.reload();
       }, 3500); 
      });

        $('#errors').hide();
        $('#success').show();
      }
      
      $this.html($this.val());
      $('html, body').animate({ scrollTop: 0 }, 'slow');

    }
  });
});

/* SUBMISSION ITEM FORM */

'use strict';
  $('#submission-form').on("submit", function(event){ 
  
    event.preventDefault();  

    tinyMCE.triggerSave();
  
    var $this = $('#loading');
    var loadingText = '<span class="anim-rotate" uk-icon="refresh"></span>';
    if ($('#loading').html() !== loadingText) {
      $this.html(loadingText);
    }
  
    $.ajax({
      type: 'POST',
      url: SITEURL+"/dashboard/new_item_ajax.php",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(response) {
          
        let dataJson = JSON.parse(response);

        if(dataJson['validations'].length > 0){
          $('#successMsg').empty();
          $('#errorsMsg').empty();
          $.each(dataJson['validations'], function(i, obj) {
              $('#errorsMsg').append('<li>' + obj + '</li>');
          });
  
          $('#success').hide();
          $('#errors').show();
        }

        if(dataJson['errors'].length > 0){
          $('#successMsg').empty();
          $('#errorsMsg').empty();
          $.each(dataJson['errors'], function(i, obj) {
              $('#errorsMsg').append('<li>' + obj + '</li>');
          });
  
          $('#success').hide();
          $('#errors').show();
        }

        if(dataJson['success'].length > 0){
          $('#errorsMsg').empty();
          $('#successMsg').empty();
          $.each(dataJson['success'], function(i, obj) {
              $('#successMsg').append('<li>' + obj + '</li>');
          });

          $('#submission-form')[0].reset();  
          $('#formInputs').hide();
  
          $('#errors').hide();
          $('#success').show();
        }
        
        $this.html($this.val());
        $('html, body').animate({ scrollTop: 0 }, 'slow');

      }
    });
  });

/* SUBCATEGORIES BY CATEGORY */

'use strict';
$(document).ready(function() {
  $('#categories-dropdown').on('change', function() {
      var category_id = this.value;
      $.ajax({
          url: SITEURL+"/dashboard/subcategories.php",
          type: "POST",
          data: {
              category_id: category_id
          },
          cache: false,
          success: function(response){
              $("#subcategories-dropdown").html(response);
          }
      });
  });
});

/* FROMS */

tinymce.init({
  selector: ".advancedtinymce",
  height: 400,
  relative_urls : false,
  remove_script_host : false,
  convert_urls : true,
  plugins: [
    'lists link hr code preview',
  ],
  toolbar1: 'removeformat | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | preview | code',
});

'use strict';
  function onRecaptchaSuccess(){
    $('#submit-form').submit();
}

'use strict';
function replaceDecimalSep(x, sep) {

  if(sep == ","){
  return x.replace(".", sep);
  }else if(sep == "."){
    return x.replace(",", sep);
  }

}

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
$('.filterInterval').on('click', function () {
  var value = $(this).data('interval');
  insertParam('interval', value);

});

'use strict';
function formatPrice(price, currency, currencyposition, decimalnumber, decimalseparator) {

  let output = "";
  let num = replaceDecimalSep(price, decimalseparator);

if(decimalnumber > 0){

  if (currencyposition == 'left') {
    output = currency + num;
}else if (currencyposition == 'left-space') {
    output = currency +' '+ num;
}else if (currencyposition == 'right') {
    output = num + currency;
}else if (currencyposition == 'right-space') {
    output = num +' '+ currency;
}

}else{

  if (currencyposition == 'left') {
    output = currency + num;
}else if (currencyposition == 'left-space') {
    output = currency +' '+ num;
}else if (currencyposition == 'right') {
    output = num + currency;
}else if (currencyposition == 'right-space') {
    output = num +' '+ currency;
}

}

  return output;

};

'use strict';
// Configuration    
const COUNT_FORMATS =
[
  { // 0 - 999
    letter: '',
    limit: 1e3
  },
  { // 1,000 - 999,999
    letter: 'K',
    limit: 1e6
  },
  { // 1,000,000 - 999,999,999
    letter: 'M',
    limit: 1e9
  },
  { // 1,000,000,000 - 999,999,999,999
    letter: 'B',
    limit: 1e12
  },
  { // 1,000,000,000,000 - 999,999,999,999,999
    letter: 'T',
    limit: 1e15
  }
];
    
// Format Method:
function formatCount(value){
  const format = COUNT_FORMATS.find(format => (value < format.limit));

  value = (1000 * value / format.limit);
  value = Math.round(value * 10) / 10; // keep one decimal number, only if needed

  return (value + format.letter);
}

'use strict';
$('.clearinput').on('click', function() {

  $('#end-date').val('');
  
});

'use strict';
$(function() {

    // Sidebar Toggler
    function sidebarToggle(toogle) {
        var sidebar = $('#sidebar');
        var padder = $('.content-padder');
        if( toogle ) {
            $('.notyf').removeAttr( 'style' );
            sidebar.css({'display': 'block', 'x': -300});
            sidebar.transition({opacity: 1, x: 0}, 250, 'in-out', function(){
                sidebar.css('display', 'block');
            });
            if( $( window ).width() > 960 ) {
                padder.transition({marginLeft: sidebar.css('width')}, 250, 'in-out');
            }
        } else {
            $('.notyf').css({width: '90%', margin: '0 auto', display:'block', right: 0, left: 0});
            sidebar.css({'display': 'block', 'x': '0px'});
            sidebar.transition({x: -300, opacity: 0}, 250, 'in-out', function(){
                sidebar.css('display', 'none');
            });
            padder.transition({marginLeft: 0}, 250, 'in-out');
        }
    }

    $('#sidebar_toggle').click(function() {
        var sidebar = $('#sidebar');
        var padder = $('.content-padder');
        if( sidebar.css('x') == '-300px' || sidebar.css('display') == 'none' ) {
            sidebarToggle(true)
        } else {
            sidebarToggle(false)
        }
    });

    function resize()
    {
        var sidebar = $('#sidebar');
        var padder = $('.content-padder');
		padder.removeAttr( 'style' );
		if( $( window ).width() < 960 && sidebar.css('display') == 'block' ) {
			sidebarToggle(false);
		} else if( $( window ).width() > 960 && sidebar.css('display') == 'none' ) {
			sidebarToggle(true);
		}
    }

    if($( window ).width() < 960) {
        sidebarToggle(false);
    }

	$( window ).resize(function() {
		resize()
	});

    $('.content-padder').click(function() {
        if( $( window ).width() < 960 ) {
            sidebarToggle(false);
        }
    });

})

'use strict';
$(document).ready(function () {
    barChart();
});
function barChart() {{

  if ($("#graphCanvas").length) {
    var filledLineChart = document.getElementById("graphCanvas").getContext('2d');

    let gradient = filledLineChart.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, 'rgba(30, 135, 240, 0.6)');
    gradient.addColorStop(1, 'rgba(30, 135, 240, 0.05)');
  
    let gradient_white = filledLineChart.createLinearGradient(0, 0, 0, 250);
    gradient_white.addColorStop(0, 'rgba(50, 210, 150,0.6)');
    gradient_white.addColorStop(1, 'rgba(50, 210, 150, 0.05)');

        var interval = $(".intervals li[class*='uk-active'] a").data('interval');
        var item = $("#itemId").data('id');
        $.post(SITEURL+"/dashboard/data.php?type=chartclicks"+"&interval="+interval+"&item="+item,
        function (data){

            var name = [];
            var totalclicks = [];
            var uniqueclicks = [];
            for (var i in data) {
                name.push(data[i].date);
                totalclicks.push(data[i].clicks);
                uniqueclicks.push(data[i].uniqueclicks);
            }
            var chartdata = {
                labels: name,
                datasets: [
                    {
                        label: ST_ALLCLICKS,
                        data: totalclicks,
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: [
                                    'rgba(30, 135, 240, 1)',
                        ],
                        borderWidth: 1,
                    }, {
                        label: ST_UNIQUECLICKS,
                        data: uniqueclicks,
                        fill: true,
                        backgroundColor: gradient_white,
                        borderColor: [
                                    'rgba(50, 210, 150, 1)',
                        ],
                        borderWidth: 1
                      },
                ]
            };
            var graphTarget = $("#graphCanvas");
            var barGraph = new Chart(graphTarget, {
                type: 'line',
                data: chartdata,
                borderWidth: 1,
                /*options: {          
                    scales: {
                        y: {
                            min: 0,
                            max: totalclicks,
                        }
                    }
                }*/
            });
        });
    }
  }
}

// Cancel Alert

'use strict';
function cancelAlert(urlItem, reDirect = null) {
  swal({
    title: ST_CONFIRMCANCEL,
    text: ST_AREYOUSURECANCEL,
    type: "warning",
    cancelButtonClass: "uk-button uk-button-default uk-border-rounded",
    showCancelButton: true,
    cancelButtonText: ST_CANCELBUTTON,
    confirmButtonClass: "uk-button uk-button-warning uk-border-rounded",
    confirmButtonText: ST_YESCANCEL,
    closeOnConfirm: false },
    function () {
      $.ajax({
        type: 'POST',
        url: urlItem,
        success: function () {
          if (reDirect) {
            window.location.href = reDirect;
          }else{
            location.reload();
          }
        },
        error: function (error) {
          //console.log(error);
        }
      });
    });

};

'use strict';
$(document).ready(function(){
  $('.cancelSubscription').on('click', function(){
    var urlItem = $(this).data('url');
    var reDirect = $(this).data('redirect'); // Redirect page name after delete e.g. "items"

    cancelAlert(urlItem, reDirect);

  });
});

// Delete Account

'use strict';
function deleteAccountAlert(urlItem, reDirect = null) {
  swal({
    title: ST_AREYOUSUREDELETE,
    text: ST_AREYOUSUREDELETEACCOUNT,
    type: "error",
    cancelButtonClass: "uk-button uk-button-default uk-border-rounded",
    showCancelButton: true,
    cancelButtonText: ST_CANCELBUTTONALERT,
    confirmButtonClass: "uk-button uk-button-danger uk-border-rounded",
    confirmButtonText: ST_YESDELETE,
    closeOnConfirm: false },
    function () {
      $.ajax({
        type: 'POST',
        url: urlItem,
        success: function () {
          if (reDirect) {
            window.location.href = reDirect;
          }else{
            location.reload();
          }
        },
        error: function (error) {
          //console.log(error);
        }
      });
    });

};

'use strict';
$(document).ready(function(){
  $('.deleteAccount').on('click', function(){
    var urlItem = $(this).data('url');
    var reDirect = $(this).data('redirect'); // Redirect page name after delete e.g. "items"

    deleteAccountAlert(urlItem, reDirect);

  });
});

// Delete Alert

'use strict';
function deleteAlert(urlItem, reDirect = null) {
  swal({
    title: ST_AREYOUSUREDELETE,
    text: ST_YOUWILLNOT,
    type: "error",
    cancelButtonClass: "uk-button uk-button-default uk-border-rounded",
    showCancelButton: true,
    cancelButtonText: ST_CANCELBUTTONALERT,
    confirmButtonClass: "uk-button uk-button-danger uk-border-rounded",
    confirmButtonText: ST_YESDELETE,
    closeOnConfirm: false },
    function () {
      $.ajax({
        type: 'POST',
        url: urlItem,
        success: function () {
          if (reDirect) {
            window.location.href = reDirect;
          }else{
            location.reload();
          }
        },
        error: function (error) {
          //console.log(error);
        }
      });
    });

};

'use strict';
$(document).ready(function(){
  $('.deleteItem').on('click', function(){
    var urlItem = $(this).data('url');
    var reDirect = $(this).data('redirect'); // Redirect page name after delete e.g. "items"

    deleteAlert(urlItem, reDirect);

  });
});

'use strict';
$(document).ready(function(){
    $('#table_id').on('click', '.deleteItem', function(){

    var urlItem = $(this).data('url');
    var reDirect = $(this).data('redirect'); // Redirect page name after delete e.g. "items"

    deleteAlert(urlItem, reDirect);

  });
});

// Disable Alert

'use strict';
function disableAlert(urlItem, reDirect = null) {
  swal({
    title: ST_AREYOUSUREDISABLE,
    type: "warning",
    cancelButtonClass: "uk-button uk-button-default uk-border-rounded",
    showCancelButton: true,
    cancelButtonText: ST_CANCELBUTTONALERT,
    confirmButtonClass: "uk-button uk-button-warning uk-border-rounded",
    confirmButtonText: ST_YESDISABLE,
    closeOnConfirm: false },
    function () {
      $.ajax({
        type: 'POST',
        url: urlItem,
        success: function () {
          if (reDirect) {
            window.location.href = reDirect;
          }else{
            location.reload();
          }
        },
        error: function (error) {
          //console.log(error);
        }
      });
    });

};

'use strict';
$(document).ready(function(){
  $('.disableItem').on('click', function(){
    var urlItem = $(this).data('url');
    var reDirect = $(this).data('redirect'); // Redirect page name after delete e.g. "items"

    disableAlert(urlItem, reDirect);

  });
});

'use strict';
$(document).ready(function(){
    $('#table_id').on('click', '.disableItem', function(){

    var urlItem = $(this).data('url');
    var reDirect = $(this).data('redirect'); // Redirect page name after delete e.g. "items"

    disableAlert(urlItem, reDirect);

  });
});

// Enable Alert

'use strict';
function enableAlert(urlItem, reDirect = null) {
  swal({
    title: ST_AREYOUSUREENABLE,
    type: "warning",
    cancelButtonClass: "uk-button uk-button-default uk-border-rounded",
    showCancelButton: true,
    cancelButtonText: ST_CANCELBUTTONALERT,
    confirmButtonClass: "uk-button uk-button-warning uk-border-rounded",
    confirmButtonText: ST_YESENABLE,
    closeOnConfirm: false },
    function () {
      $.ajax({
        type: 'POST',
        url: urlItem,
        success: function () {
          if (reDirect) {
            window.location.href = reDirect;
          }else{
            location.reload();
          }
        },
        error: function (error) {
          //console.log(error);
        }
      });
    });

};

'use strict';
$(document).ready(function(){
  $('.enableItem').on('click', function(){
    var urlItem = $(this).data('url');
    var reDirect = $(this).data('redirect'); // Redirect page name after delete e.g. "items"

    enableAlert(urlItem, reDirect);

  });
});

'use strict';
$(document).ready(function(){
    $('#table_id').on('click', '.enableItem', function(){

    var urlItem = $(this).data('url');
    var reDirect = $(this).data('redirect'); // Redirect page name after delete e.g. "items"

    enableAlert(urlItem, reDirect);

  });
});
