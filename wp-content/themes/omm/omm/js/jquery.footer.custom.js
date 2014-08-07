/*-----------------------------------------------------------------------------------*/
/*	Custom Footer JS
/*-----------------------------------------------------------------------------------*/

(function($) {

	// Capture page elements
	var $pageContent = $('.main-content');
	var $mmtileContainer = $('#isotope-trigger');
	var $dropdownContainer = $('.dropdown-container');
	var $dropdownContent = $('.dropdown-content');
	var $mobileMenu = $('.mobile-menu');
	var $mobileSearchForm = $('.header-buttons #main-search-form');
	var isIE9 = $('html').hasClass('ie9');


	/*-----------------------------------------------------------------------------------*/
	/*	Isotope
	/*-----------------------------------------------------------------------------------*/

	/* filter items with an isotope filter animation, when one of the filter links is clicked */
	if($('body').hasClass('single-mmtile') || $('body').hasClass('page-template-template-mmtile-php')) {
		$('.mmtile-filter a').click(function(e) {
			e.preventDefault();

            var selector = $(this).attr('data-filter');

            if (selector == '*') {
                $('.mmtile-filter li').removeClass('active');
            } else {
                $('.mmtile-filter li:first-child').removeClass('active');
            }

            $(this).parent().toggleClass('active');
            var $active = $('.mmtile-filter li.active a');

            var filter = [];

            if ($active.length === 0) {
                $('.mmtile-filter li:first-child').addClass('active');
                filter.push('*');
            } else {
                $active.each(function() {
                    filter.push($(this).attr('data-filter'));
                });
            }


		 	$mmtileContainer.isotope({ filter: filter.join(', ') });

			if($('body').hasClass('single-mmtile') || Modernizr.mq('only screen and (max-width: 1220px)')) {
				$('html, body').animate({
				    scrollTop: $mmtileContainer.offset().top
				}, 800);
			}
		});
	}

	/* Initialize Isotope */
	$mmtileContainer.imagesLoaded(function() {

		/* Get the widths of isotope thumbnails, depending on the current screen size */
		function getThumbWidth() {
			var windowWidth = $(window).width();

			if(windowWidth <= 400) {
				return Math.floor($mmtileContainer.width());
			}
			else if(windowWidth <= 1080) {
				return Math.floor($mmtileContainer.width() / 2);
			}
			else if(windowWidth <= 1480) {
				return Math.floor($mmtileContainer.width() / 3);
			}
			else if(windowWidth <= 1880) {
				return Math.floor($mmtileContainer.width() / 4);
			}
			else if(windowWidth <= 2280) {
				return Math.floor($mmtileContainer.width() / 5);
			}
			else if(windowWidth <= 2680) {
				return Math.floor($mmtileContainer.width() / 6);
			}
			else if(windowWidth <= 3080) {
				return Math.floor($mmtileContainer.width() / 7);
			}
		}

		function setThumbWidth() {
			var thumbWidth = getThumbWidth();
			$mmtileContainer.children().css({ width: thumbWidth });
		}
		setThumbWidth();

		/* Set the height of the main content column (on the right), to match the height of the browser window */
		function setPageHeight() {
			if($pageContent.css('float') === 'left') {
				$pageContent.css('height', 'auto'); // Reset the main column height
				var windowHeight = $(window).height();
				var columnHeight = $pageContent.outerHeight();

				if(windowHeight > columnHeight) {
					$pageContent.css('height', windowHeight);
				}
				else {
					$pageContent.css('height', 'auto');
				}
			}
		}
		setPageHeight();

		$mmtileContainer.isotope({
			layoutMode: 'masonry',
			masonry: {
            	columnWidth: getThumbWidth()
            }
        });

        $(window).smartresize(function() {
        	setThumbWidth();
        	setPageHeight();

			$mmtileContainer.isotope({
            	masonry: {
                	columnWidth: getThumbWidth()
				}
			});
        });
    });


	/*-----------------------------------------------------------------------------------*/
	/*	Mobile Menu
	/*-----------------------------------------------------------------------------------*/

	$('.menu-button').click(function(e) {

		var wrapperHeight = $dropdownContainer.height();
		var pageHeight = $dropdownContent.outerHeight();

		// Execute if the drop-down content is opened
		if(wrapperHeight) {

			// Close the drop-down content, if the clicked header button corresponds to the content already opened in the drop-down, or else open the drop-down.
			if(Modernizr.csstransitions) {
				$dropdownContainer.transition({ height: 0 }, 300, 'ease', function() {
					$mobileMenu.css('display', 'none');
				});
			}
			else {
				$dropdownContainer.animate({ height: 0 }, 300, 'easeOutCubic', function() {
					$mobileMenu.css('display', 'none');
				});
			}

		}
		// The drop-down is closed. Open it.
		else {
			$mobileMenu.css('display', 'block');

	        pageHeight = $dropdownContent.outerHeight();

			if(Modernizr.csstransitions) {
				$dropdownContainer.transition({ height: pageHeight }, 300, 'ease');
			}
			else {
				$dropdownContainer.animate({ height: pageHeight }, 300, 'easeOutCubic', function() {
					$(this).css('height', 'auto');
				});
			}
		}

		$('body, html').animate({ scrollTop: 0 }, 200, 'easeOutCubic' );

	});

	$('.close-button').click(function() {
		if(Modernizr.csstransitions) {
			$dropdownContainer.transition({ height: 0 }, 300, 'ease', function() {
				$mobileMenu.css('display', 'none');
			});
		}
		else {
			$dropdownContainer.animate({ height: 0 }, 300, 'easeOutCubic', function() {
				$mobileMenu.css('display', 'none');
			});
		}
	});


	/*-----------------------------------------------------------------------------------*/
	/*	Mobile Search
	/*-----------------------------------------------------------------------------------*/

	$('.search-button').click(function() {
		$mobileSearchForm.toggleClass('search-active');

		if($mobileSearchForm.hasClass('search-active')) {
			$mobileSearchForm.find('input').trigger('focus');
		}
		else {
			$mobileSearchForm.find('input').blur();
		}
	});


	/*-----------------------------------------------------------------------------------*/
	/*	Responsive Videos
	/*-----------------------------------------------------------------------------------*/

	$pageContent.fitVids();


	/*-----------------------------------------------------------------------------------*/
	/*	Comment Form Placeholders for IE9
	/*-----------------------------------------------------------------------------------*/

	if (isIE9) {

		var authorPlaceholder = $('#commentform #author').attr('placeholder');
		var emailPlaceholder = $('#commentform #email').attr('placeholder');
		var urlPlaceholder = $('#commentform #url').attr('placeholder');
		var commentPlaceholder = $('#commentform #comment').attr('placeholder');

		$('#commentform #author').val(authorPlaceholder);
		$('#commentform #email').val(emailPlaceholder);
		$('#commentform #url').val(urlPlaceholder);
		$('#commentform #comment').val(commentPlaceholder);

		$('#commentform input, #commentform textarea').focus(function() {
			if($(this).attr('id') == 'author') {
				if ($(this).val() == authorPlaceholder) { $(this).val(''); }
			}
			else if($(this).attr('id') == 'email') {
				if ($(this).val() == emailPlaceholder) { $(this).val(''); }
			}
			else if($(this).attr('id') == 'url') {
				if ($(this).val() == urlPlaceholder) { $(this).val(''); }
			}
			else if($(this).attr('id') == 'comment') {
				if ($(this).val() == commentPlaceholder) { $(this).val(''); }
			}
		});

		$('#commentform input, #commentform textarea').blur(function() {
			if($(this).attr('id') == 'author') {
				if ($(this).val() == '') { $(this).val(authorPlaceholder); }
			}
			else if($(this).attr('id') == 'email') {
				if ($(this).val() == '') { $(this).val(emailPlaceholder); }
			}
			else if($(this).attr('id') == 'url') {
				if ($(this).val() == '') { $(this).val(urlPlaceholder); }
			}
			else if($(this).attr('id') == 'comment') {
				if ($(this).val() == '') { $(this).val(commentPlaceholder); }
			}
		});

	}


	/*-----------------------------------------------------------------------------------*/
	/*	Responsive Tables
	/*-----------------------------------------------------------------------------------*/

	$('.the-content table').addClass('responsive');

	var switched = false;
  	var updateTables = function() {
	    if (($(window).width() < 767) && !switched ){
	    	switched = true;
	      	$("table.responsive").each(function(i, element) {
	        	splitTable($(element));
	      	});
	      	return true;
	    }
	    else if (switched && ($(window).width() > 767)) {
	      	switched = false;
	      	$("table.responsive").each(function(i, element) {
	        	unsplitTable($(element));
	      	});
	    }
  	};

  	$(window).load(updateTables);
  	$(window).bind("resize", updateTables);

	function splitTable(original) {
		original.wrap("<div class='table-wrap' />");

		var copy = original.clone();
		copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
		copy.removeClass("responsive");

		original.closest(".table-wrap").append(copy);
		copy.wrap("<div class='pinned' />");
		original.wrap("<div class='scrollable' />");
	}

	function unsplitTable(original) {
    	original.closest(".table-wrap").find(".pinned").remove();
    	original.unwrap();
   	 	original.unwrap();
	}


})( jQuery );