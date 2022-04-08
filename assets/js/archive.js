  $ = jQuery;

  var mafs = $("#my-ajax-filter-search");
  var mafsForm = mafs.find("form");
  $(document).on('click', 'a.page-numbers', function(e){
    $.ajax({
      url : $(this).attr("href"),
      beforeSend: function(){
        $('#ajax_filter_search_results').html('');
        $('.loading').html('<center><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></center>');
      // return false;
      },
		  success : function(response) {
        $('#ajax_filter_search_results').html(response);
      },
      complete: function(){
        $('.loading').html('');
      }
    });
    return false;
  })

  $('#month').attr("disabled", "disabled");
  function checkYear() {
    $('#month').removeAttr("disabled");
    // $("#year").attr("size", 50);
  }

  mafsForm.submit(function(e){
    e.preventDefault();
    var year = '';
    var url = DVO.siteurl;
    var ajax_url = url+"/wp-admin/admin-ajax.php";

    if(mafsForm.find("#search").val().length !== 0) {
      var search = mafsForm.find("#search").val();
    }
    if(mafsForm.find("#year").length) {
    if(mafsForm.find("#year").val()!= '') {
      var year = mafsForm.find("#year").val();
    }else{
      var year = '';
    }
  }
    if(mafsForm.find("#month").val() != '') {
      var month = mafsForm.find("#month").val();
    }
    if(mafsForm.find("#category").val()!='') {
      var category = mafsForm.find("#category").val();
    }
    var data = {
      action : "my_ajax_filter_search",
      search : search,
      year : year,
      month : month,
      category : category
    }
    $.ajax({
        url : ajax_url,
        data : data,
        beforeSend: function(){
          $('#ajax_filter_search_results').html('');
          $('.loading').html('<center><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></center>');

        },
        success : function(response) {
          $('#ajax_filter_search_results').html(response);
        },
        complete: function(){
          $('.loading').html('');
        }

 });

  });

  $('.form-tabs li').click(function() {
    var tab = $(this).attr("data-tab-content");
    console.log($(this).attr("data-tab-content"));
    if($(this).hasClass('active') === true){
      $(this).removeClass('active');
      $('.tab-content.active').removeClass('active');
    }
    else{
        disableAllTab();
        $(this).addClass('active');
        $('.tab-content[data-tab-content='+tab+']').addClass('active');
    }
    if (tab == "tab2") {
      $("#ajax_filter_search_results").hide();
    }else{
      $("#ajax_filter_search_results").show();
    }
  });

  var disableAllTab = function(){
    console.log("disableAllTab");
    $(".form-tabs li").removeClass('active');
    $(".tabcontent").removeClass('active');
  }

$(document).ready(function(){

	$('ul.tabs_one li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs_one li').removeClass('current');
		$('.tab-content-one').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})
  setTimeout(function(){
      jQuery('.full-width-tab').append(jQuery('#ui-datepicker-div'));
  },1000);
jQuery("a.cs-footer__logo.cs-logo-dark").removeAttr('href');

})

// MORE DROPDOWN LINK
    jQuery(function(){
      var windowWidthMore = + screen.width;
      if(windowWidthMore < 1200) {
        jQuery(".cs-header__nav-inner .menu-item").click(function(){
          jQuery(".cs-header__nav-inner > .menu-item").toggleClass("touch-device");
        });
      }
      }); 

// DISABLE LOGO HYPERLING ABOVE TAB DEVICE
jQuery(function(){
      var windowWidthMore = + screen.width;
      if(windowWidthMore > 1019) {
        jQuery("a.cs-header__logo.cs-logo-default").removeAttr('href');
      }
      }); 
jQuery(function(){
      var windowWidthMore = + screen.width;
      if(windowWidthMore < 1020) {
        jQuery("a.cs-header__logo.cs-logo-default").attr("href", "https://albiladdaily.com/");
      }
      });

