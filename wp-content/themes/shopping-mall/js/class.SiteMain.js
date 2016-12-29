// JavaScript Document
var SiteMain = (function() {
	function init(){
		createTooltip();
		createRadio();
		createSelectBox();
		createRangePrice();
	}
	
	function createRadio(){
		$('input.iCheckRadio').iCheck();
		$('input.iCheckBox').iCheck();
	}
	
	function createSelectBox(){
		$('.filterSelect select, .woocommerce-ordering select').select2({
			minimumResultsForSearch: -1
		});
	}

	function createRangePrice(){
		if($('#rangePrice').length > 0){
			var range = document.getElementById('rangePrice');

			range.style.width = '120px';
			range.style.margin = '0 auto 30px';
			$(range).tooltipster({
	            theme: "tooltip--light",
	            animation: "grow",
	            tooltips: true
	        })
			noUiSlider.create(range, {
				format: wNumb({
					decimals: 0,
					thousand: '.',
					postfix: '$ '
				}),
				tooltips: true,
				connect: !0,
		        start: [0, 5000],
		                step: 1,
		                range: {
		                    min: 0,
		                    max: 5000
		                }
			});
		}
		
	}
	function createTooltip(){
		var wElement = $('.content-box-wrapper .product-grid-item').width();
		//var position = { my: 'left top', at: 'right+10 bottom-20' }; 
		//position.collision = 'none';

		var windowHeight = $(window).height();
    	var windowWidth = $(window).width();


		$(function() {
		    $( document ).tooltip();
		});


		$('div.tooltip').each(function(){
			$this='';
			$(document).tooltip({
	        	items: '[data-toggle="tooltip"]',
				offset: [10, 2],
 
			   // use the "slide" effect
			   effect: 'slide',
				tooltipClass: 'right',
				content: function(){
					var imagelist = $(this).find('.tooltip-data').val();
					var productname = $(this).find('.content-box-title').html();
					var extension = $(this).find('.content-box-file-extensions').html();

					$this = $(this);
					imagelist = JSON.parse(imagelist);
					var list = "<ul class='slick'>";
					for (var i = 0; i < imagelist.length; i++) {
					    list += "<li><img src=" + imagelist[i] + " /></li>"
					}
					list += "</ul>";
					list += "<div class='product-name'>" + productname + "</div> <div class='extension'>"+ extension +"</div>";
					return list;
				},
				open: function (elem,ui) {
					var left = $($this).offset().left;
    				var top = $($this).offset().top;
    				var proH = $($this).height();
				    var proW = $($this).width();
				    var bottom = windowHeight - top - proH;
				    var right = windowWidth - left - proW;
				    var topbottom = (top < bottom) ? bottom : top;
				    var leftright = (left < right) ? right : left;

				    var tooltiph = $(ui.tooltip).find('ul.slick').height()/2;
				    var tooltipw = $(ui.tooltip).find('ul.slick').width();
				    if (topbottom == bottom && leftright == right) //done
				    {
				    	console.log(1);
				        var yPos = top;
				        var xPos = left + proW + 10;
				        ui.tooltip.css({ top: yPos , left:  xPos }, "fast" );
				    } else if (topbottom == bottom && leftright == left) //done
				    {
				    	console.log(2);
				        var yPos = top;
				        var xPos = right + proW + 10;
				        ui.tooltip.css({ top: yPos, left:  'auto', right: xPos  }, "fast" );
				    } else if (topbottom == top && leftright == right) //done
				    {
				    	
				        var xPos = left + proW + 10;
				        var yPos = top;
				        ui.tooltip.css({ top: yPos, left: xPos + 25  }, "fast" );
				    } else if (topbottom == top && leftright == left) {
				    	console.log(4);
				        var yPos = top ;
				        var xPos = left - (tooltipw - 25);
				        ui.tooltip.css({ top: yPos, left: xPos - 50  }, "fast" );
				    } else {}


					//ui.tooltip.css({ top: $($this).offset().top + 10, left:  $($this).offset().left + $($this).width() + 20 }, "fast" );
					$('ul.slick').not('.slick-initialized').slick({
						dots: false,
						    prevArrow: $('.prev'),
							nextArrow: $('.next')


					});

					$(this).find('.content-box-controls .action .fa-chevron-left ')
				}
			});
		});
	}
	
	function openPopup(idDiv){
		$('.result_question').css('display','none')
		$(idDiv).css('display','block');	
	}
	function closePopup(idDiv){
		$(idDiv).css('display','none');
        return false;
	}
	return {
		init:init,
		openPopup:openPopup,
		closePopup:closePopup
	}
	
})();		

$(document).ready( function() {
	SiteMain.init();
});

