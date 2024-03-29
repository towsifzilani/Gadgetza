/*

 Main javascript functions to init most of the elements

 #1. FORM VALIDATION
 #2. CK EDITOR
 #3. SORTABLE -- TASKS
 #4. CHARTJS CHARTS
 #4.1 LINE CHARTS
 #4.2 BAR CHARTS
 #4.3 PIE & DOUGHNUT CHARTS

 #5  MENU/NAVIGATION
 #6. FULL BODY COLORED SCROLL
 #7. NAVIGATION SCROLL
 #8. BOOTSTRAP RELATED JS ACTIVATIONS

 */

'use strict';
$(function () {
    /*----------------------------------------
     // - #0. COLOR VARIABLES
     ----------------------------------------*/

    var primaryColor = '#18BCC9';
    var primaryAlphaDot5 = 'rgba(24, 188, 201,0.5)';
    var primaryAlpha = 'rgba(24, 188, 201,0)';

    var whiteColor = '#fff';
    var whiteAlphaDot5 = 'rgba(255,255,255,0.5)';
    var whiteAlphaDot25 = 'rgba(255,255,255,0.25)';
    var whiteAlpha = 'rgba(255,255,255,0)';

    var lightColor ='#f1f1f1'

    var darkColor = '#2a3f5a';

    var secondaryColor = '#a5b5c5';
    var secondaryAlphaDot5 = 'rgba(165,181,197,0.5)';

    var successColor = '#66bb6a';
    var successAlphaDot5 = 'rgba(102,187,106,0.5)';

    var dangerColor = '#f65f6e';
    var dangerAlphaDot5 = 'rgba(246,95,110,0.5)';

    /*----------------------------------------
     // - #1. FORM VALIDATION
     ----------------------------------------*/
    if ($('#needs-validation').length) {
        "use strict";
        var form = document.getElementById("needs-validation");
        form.addEventListener("submit", function(event) {
            if (form.checkValidity() == false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        }, false);
    }

	"use strict";
    if ($("#fullCalendar").length) {
        var calendar, d, date, m, y;

        date = new Date();

        d = date.getDate();

        m = date.getMonth();

        y = date.getFullYear();

        calendar = $("#fullCalendar").fullCalendar({
            header: {
                left: "prev,next today",
                center: "title",
                right: "month,agendaWeek,agendaDay"
            },
            selectable: true,
            selectHelper: true,
            select: function select(start, end, allDay) {
                var title;
                title = prompt("Event Title:");
                if (title) {
                    calendar.fullCalendar("renderEvent", {
                        title: title,
                        start: start,
                        end: end,
                        allDay: allDay
                    }, true);
                }
                return calendar.fullCalendar("unselect");
            },
            editable: true,
            events: [{
                title: "Long Event",
                start: new Date(y, m, 3, 12, 0),
                end: new Date(y, m, 7, 14, 0)
            }, {
                title: "Lunch",
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d + 2, 14, 0),
                allDay: false
            }, {
                title: "Click for Google",
                start: new Date(y, m, 28),
                end: new Date(y, m, 29),
                url: "http://google.com/"
            }]
        });
    }

    /*----------------------------------------
     // - #2. CK EDITOR
     ----------------------------------------*/
	 "use strict";
    if ($('#textEditor').length) {
        CKEDITOR.replace('textEditor');
    }

    /*----------------------------------------
     // - #3. SORTABLE -- TASKS
     ----------------------------------------*/
	 "use strict";
    if($('#sortable1').length){
        var todo = document.getElementById('todo');
        var inprog = document.getElementById('inprogress');
        var complete = document.getElementById('taskdone');

        Sortable.create(todo, {
            group: "shared",
            scroll: true,
            sort: true
        });

        Sortable.create(inprog, {
            group: "shared",
            scroll: true,
            sort: true
        });

        Sortable.create(complete, {
            group: "shared",
            scroll: true,
            sort: true
        });
    }

	"use strict";
    if($('.sparklineBarChartPrimary').length){
        var myValue = [32, 38, 36, 35, 38, 37, 35, 34, 36, 38, 36,];
        $('.sparklineBarChartPrimary').sparkline(myValue,{
            type:'bar',
            barColor: primaryColor,
            height: "60",
            barWidth: 3,
            resize: true,
            barSpacing: 8
        });
    }

	"use strict";
    if($('.sparklineBarChartWhite').length){
        var myValue = [32, 38, 36, 35, 38, 37, 35, 34, 36, 38, 36,];
        $('.sparklineBarChartWhite').sparkline(myValue,{
            type:'bar',
            barColor: whiteColor,
            height: "60",
            barWidth: 3,
            resize: true,
            barSpacing: 8
        });
    }


    /*----------------------------------------
     // - #5  MENU/NAVIGATION
     ----------------------------------------*/
    "use strict";
    $('.menu-items li a').on('click', function(){
        if($(this).next('ul.sub-menu').length !== 0 && !$(this).hasClass('show')){
            $('ul.sub-menu').slideUp(300);
            $('.menu-items li a').removeClass('show');
            $(this).addClass('show');
            $(this).next('ul.sub-menu').slideDown(300);
        }
        else if($(this).hasClass('show')){
            $(this).removeClass('show');
            $(this).next('ul.sub-menu').slideToggle(300);
        }
    });

    // - Toggle Logged User Menu
    $(document).on('click',function(e){
        if ($(e.target).is('.logged-user-menu,.logged-user-menu *')){
        }
        else if($(e.target).is('#show-user-menu, #show-user-menu *')){
            $('.logged-user-menu').toggleClass('show');
        }
        else if($('.logged-user-menu').hasClass('show')){

            $('.logged-user-menu').removeClass('show')
        }
    });

    // - Toggle Sidebar
    $(document).on('click',function(e){
        if ($(e.target).is('#sidebar-panel,#sidebar-panel *')){
        }
        else if($(e.target).is('#toggle-sidebar, #toggle-sidebar *')){
            $('#sidebar-panel').toggleClass('open');
        }
        else if($('#sidebar-panel').hasClass('open') && nWidth<1096){

            $('#sidebar-panel').removeClass('open')
        }
    });


    // - Toggle Navigation
    $(document).on('click',function(e){

        var nWidth = document.getElementById('navigation').offsetWidth;

        if ($(e.target).is('#navigation,#navigation *')){
        }
        else if($(e.target).is('#toggle-navigation, #toggle-navigation *')){
            $('#navigation').toggleClass('open');
        }
        else if($('#navigation').hasClass('open') && nWidth<992){

            $('#navigation').removeClass('open');
        }
    });



    /*----------------------------------------
     // - #6. FULL BODY COLORED SCROLL
     ----------------------------------------*/

    /*'use strict';
    $('html').niceScroll({
        'smoothscroll': true,
        'scrollspeed': 100,
        'horizrailenabled': false
    });*/

    // - #7. NAVIGATION SCROLL
    $('.custom-scroll').mCustomScrollbar({
        theme:"minimal",
        scrollInertia: 300,
        advanced:{
            autoExpandHorizontalScroll:true
        }
    });



    /*----------------------------------------
     // - #8. BOOTSTRAP RELATED JS ACTIVATIONS
     ----------------------------------------*/


    // - Activate Date pickers
    $('input.single-date-picker').daterangepicker({"singleDatePicker": true});
    $('input.date-range-picker').daterangepicker({ "startDate": "03/28/2017", "endDate": "01/10/2017"});

    // - Activate tooltips
    $('[data-toggle="tooltip"]').tooltip({html:true,trigger: 'hover'});

    // - Activate popovers
    $('[data-toggle="popover"]').popover();

    // - Activate Data Tables
    $('[data-table="data-table"]').DataTable({"ordering": false});

    //- Activate Nav pill
    $('#myTab a').on('click',function (e) {
        e.preventDefault();
        $(this).tab('show');
    });


    $('.table-editable').editableTableWidget();

});



$(document).ready(function() {
  /******************************
      BOTTOM SCROLL TOP BUTTON
   ******************************/

  // declare variable
  var scrollTop = $(".scrollTop");

  $(window).scroll(function() {
    // declare variable
    var topPos = $(this).scrollTop();

    // if user scrolls down - show scroll to top button
    if (topPos > 100) {
      $(scrollTop).css("opacity", "1");

    } else {
      $(scrollTop).css("opacity", "0");
    }

  }); // scroll END

  //Click event to scroll to top
  $(scrollTop).click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 800);
    return false;

  }); // click() scroll top EMD

}); // ready() END