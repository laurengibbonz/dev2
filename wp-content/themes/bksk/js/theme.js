$('.toplink').click(function(e){
	e.preventDefault();
		$('html, body').animate({scrollTop : 0},600);
		return false;
	});

'use strict';

var openCtrl = document.getElementById('btn-search'),
	closeCtrl = document.getElementById('btn-search-close'),
	searchContainer = document.querySelector('.overlay-search'),
	inputSearch = searchContainer.querySelector('.search__input');

/*
function init() {
	initEvents();	
}
*/

function initEvents() {
	openCtrl.addEventListener('click', openSearch);
	closeCtrl.addEventListener('click', closeSearch);
	document.addEventListener('keyup', function(ev) {
		// escape key.
		if( ev.keyCode == 27 ) {
			closeSearch();
		}
	});
}

function openSearch() {
	searchContainer.classList.add('search--open');
	inputSearch.focus();
}

function closeSearch() {
	searchContainer.classList.remove('search--open');
	inputSearch.blur();
	inputSearch.value = '';
}

function dynamicSize() {
	var width = $(document).width();
	if($('body').hasClass('page-template-page-inspiration') || $('body').hasClass('page-template-page-instagram')) {
		if(width >= 1200) {
			$('.item').removeClass('fourcol twocol').addClass('fivecol');
		}
		else if(width < 1200 && width >= 768) {
			$('.item').removeClass('fivecol twocol').addClass('fourcol');
		}
		else if(width < 767 && width >= 490) {
			$('.item').removeClass('fivecol fourcol').addClass('twocol');
		} 
		if(w > 320 && menu.is(':hidden')) {
			  menu.removeAttr('style');
		}
	}
}
	
$(document).ready(function(){
	dynamicSize();
	initEvents();
});	

$(window).resize(function() {
	if($('body').hasClass('page-template-page-inspiration') || $('body').hasClass('page-template-page-instagram')) {
	dynamicSize();
	}
	var w = $(window).width();
	if(w > 490 && menu.is(':hidden')) {
		  menu.removeAttr('style');
	}
});

  var pull    = $('#pull');
    menu    = $('.menu-navigation-container ul');
    menuHeight  = menu.height();
 
  $(pull).on('click', function(e) {
    e.preventDefault();
    menu.slideToggle();
  });
  
if($('body').hasClass('home')) {
	
	var $grid = $('.grid');
	$grid.imagesLoaded(function(){
		$('.grid').isotope({
			percentPosition: true,
			columnWidth: '.grid-sizer',
			itemSelector: '.item',
			layoutMode: 'packery',
			packery: {
				gutter: '.gutter-sizer',
			},
		});	
		$('#main, footer').animate({opacity: 1}, 600);
	});
} else if($('body').hasClass('post-type-archive-lab')) {

var $grid = $('.grid-lab');
$grid.imagesLoaded(function(){
    $grid.isotope({
		percentPosition: true,
		columnWidth: '.grid-sizer',
		itemSelector: '.grid-item',
		layoutMode: 'packery',
		packery: {
			gutter: '.gutter-sizer',
		},
// 		filter: '.'+hashFilter
    });
    $('.grid-lab').animate({opacity: 1});
});
	
function getHashFilter() {
  var matches = location.hash.match( /filter=([^&]+)/i );
  var hashFilter = matches && matches[1];
  console.log(hashFilter);
  return hashFilter && decodeURIComponent( hashFilter );

// var hashFilter = window.location.hash.slice(1);
// 	return hashFilter;
}


  // bind filter button click
	var $filters = $('.filter');
	$filters.on( 'click', 'a', function(e) {
		e.preventDefault();
		$(this).toggleClass('active');
	  var filterAttr = $( this ).attr('data-filter');
	  console.log('filter: '+filterAttr);
	  // set filter in hash
	    location.hash = 'filter=' + encodeURIComponent( filterAttr );
	});

  var isIsotopeInit = false;

  function onHashchange() {
    var hashFilter = getHashFilter();
    if ( hashFilter == null ) {
      return;
    }
    isIsotopeInit = true;
    // filter isotope
    $grid.isotope({
	    percentPosition: true,
		columnWidth: '.grid-sizer',
		itemSelector: '.grid-item',
		filter: '.'+hashFilter,
		layoutMode: 'packery',
		packery: {
			gutter: '.gutter-sizer'
		},
    });
    // set selected class on button
    if ( hashFilter ) {
      $filters.find('.active').removeClass('active');
      $filters.find('[data-filter="' + hashFilter + '"]').addClass('active');
    }
  }

  $(window).on( 'hashchange', onHashchange );
  // trigger event handler to init Isotope
  onHashchange();
	
} else if($('.content').hasClass('grid-team')) {

var $grid = $('.grid-team');
$grid.imagesLoaded(function(){
	$grid.isotope({
		percentPosition: true,
		itemSelector: '.grid-item',
		columnWidth: '.grid-sizer',
		layoutMode: 'packery',
		filter: filterSelector,
		packery: {
			gutter: '.gutter-sizer',
		},
	});
	$('.grid-team').animate({opacity: 1});
});

var slideID;

$('.grid-item--partner').on('click', function(){
	var type = $(this).find('a').data('type');
	if(type == 'emeritus') {
		slideID = $(this).data('slide-emeritus-id');
		slideType = 'emeritus';
	} else {
		slideID = $(this).data('slide-partner-id');	
		slideType = 'partner';
	}
	initOverlay(slideType);
	overlay(slideID, slideType);
});

$('.grid-item--staff').on('click', function(){
	slideID = $(this).data('slide-id');
	initOverlay('staff');
	overlay(slideID, 'staff');
});

function initOverlay(slideType) {
	$('.overlay').addClass('open');
	$('.overlay').removeClass('partner emeritus staff');
	if(slideType == 'partner' || slideType == 'emeritus') {	
		$('.overlay').addClass('partner');
	} else {
		$('.overlay').addClass('staff');
	}
}

function overlay(slideID, slideType) {	
	if(slideType == 'partner') {
		var slide = $('[data-slide-partner-id="'+slideID+'"]');
	} else if(slideType == 'emeritus') {
		var slide = $('[data-slide-emeritus-id="'+slideID+'"]');
	} else {
		var slide = $('[data-slide-id="'+slideID+'"]');
	}
	var type = $(slide).find('a').data('type');
	var id = $(slide).data('id');
	var name = $(slide).find('a').data('name');
	var title = $(slide).find('a').data('title');
	var credentials = $(slide).find('a').data('credentials');
	var bio = $(slide).find('a').data('bio');
	var img = $(slide).find('a').data('largesrc');
	var resume = $(slide).find('a').data('resume');
	var link = $(slide).find('a').data('link');
	var resumeText, commaClass;
	if(type == 'staff') {
		totalSlides = $(".grid-item--staff").length;
	} else if(type == 'emeritus') {
		totalSlides = $('.grid-item--partner a[data-type="emeritus"]').length;
	} else {
		totalSlides = $('.grid-item--partner a[data-type="partner"]').length;
	}
	
	if(totalSlides == 1) {
		$('button.prev, button.next').hide();
	} else {
		$('button.prev, button.next').show();
	}
	
	if(resume == '') {
		resumeText = '';
	} else {
		resumeText = '<a target="_blank" href="'+resume+'">Resume</a>';
	}
	if(credentials == '') {
		commaClass = '';
	} else {
		commaClass = 'class="comma"';
	}
	
	if(type == 'partner' || type == 'emeritus') {
		partnerSub(id, link);	
	}

	$('.overlay .content').html('<div class="left"><header><img class="header-img" src="'+img+'" /><div class="header__text"><h2><span '+commaClass+'>'+name+'</span> <span class="small">'+credentials+'</span></h2><h3>'+title+'</h3></div></header><article>'+bio+resumeText+'</article></div><div class="right"><img src="'+img+'" /></div><div class="sub"></div>');
}

$('.close').on('click', function(){
	$('.overlay').removeClass('open');
});

function partnerSub(currentID, link) {
    $.ajax({
        type: "POST",
        url: "/overlay-team.php",
        data: {
            id: currentID
        },
        success: function(data) {
	        $('.sub').append(data);
	    }
    });
}

$(".prev, .next").click(function() {
	if ($(this).hasClass("next")){
	  if (slideID != totalSlides){
	    slideID++;
	  } else {
	    slideID = 1;
	  }
	} else{
	  if (slideID != 1){
	    slideID--;
	  } else {
	    slideID = totalSlides;
	  }
	}
	if($('.overlay').hasClass('partner')) {
		slideType = 'partner';
	} else {
		slideType = 'staff';
	}
	overlay(slideID, slideType);
	return false;
});


$('.grid-item--staff').hover(
  function() {
    $( this ).removeClass( "bw" );
  }, function() {
    $( this ).addClass( "bw" );
  }
 );

} else if($('body').hasClass('page-template-page-recognition') || $('body').hasClass('page-id-5361') || $('body').hasClass('tag') || $('body').hasClass('single-post') || $('body').hasClass('search')) {

var headers = $('.accordion-header');
var contentAreas = $('.accordion-content').hide();
var expandLink = $('.accordion-expand-all');

// add the accordion functionality
headers.click(function() {
	var arrow = $(this).find('.arrow');
    var panel = $(this).next();
    var isOpen = panel.is(':visible');
 
    // open or close as necessary
    panel[isOpen? 'slideUp': 'slideDown']()
        // trigger the correct custom event
        .trigger(isOpen? 'hide': 'show');
    
    arrow.toggleClass('open');

    // stop the link from causing a pagescroll
    return false;
});

// hook up the expand/collapse all
expandLink.click(function(){
    var isAllOpen = $(this).data('isAllOpen');
    
    contentAreas[isAllOpen? 'hide': 'show']()
        .trigger(isAllOpen? 'hide': 'show');
});

// when panels open or close, check to see if they're all open
contentAreas.on({
    // whenever we open a panel, check to see if they're all open
    // if all open, swap the button to collapser
    show: function(){
        var isAllOpen = !contentAreas.is(':hidden');   
        if(isAllOpen){
            expandLink.text('Collapse All')
                .data('isAllOpen', true);
        }
    },
    // whenever we close a panel, check to see if they're all open
    // if not all open, swap the button to expander
    hide: function(){
        var isAllOpen = !contentAreas.is(':hidden');
        if(!isAllOpen){
            expandLink.text('Expand all')
            .data('isAllOpen', false);
        } 
    }
});

function replaceMentions ( text ) {
    return text.replace(/@([a-z\d_]+)/ig, '<a href="http://twitter.com/$1">@$1</a>'); 
}

function replaceHash( text ) {
    return text.replace(/#([a-zA-Z0-9]+)/g, '<a href="http://twitter.com/hashtag/$1">#$1</a>'); 
}

var user = 'bkskarchitects';
$.ajax({
	url: '/twitterproxy.php?url='+encodeURIComponent('statuses/user_timeline.json?screen_name='+user+'&count=4'), 
	type: 'GET',
	success: function(data) {
		var tweet_array = [];
		for(i in data) {
			console.log(data);
			var tweet_data = data[i]
			var tweet = tweet_data.text;
			tweet = tweet.replace(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig, function(url) {
				return '<a href="'+url+'">'+url+'</a>';
			}).replace(/B@([_a-z0-9]+)/ig, function(reply) {
				return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
			});
			tweet = replaceMentions(tweet);
			tweet = replaceHash(tweet);
			var date = tweet_data.created_at,
			split = date.split(' '),
			newDate = split[1]+' '+split[2];
			name = tweet_data.user.screen_name;
			var text = '<span class="gray"><a href="http://twitter.com/'+name+'" target="_blank">@'+name+'</a> - '+newDate+'</span><p>'+tweet+'</p>';
			tweet_array.push(text);
			var tweet_display = tweet_array.join('');
			$(".twitter").html(tweet_array);
		}
	},
	error: function(data) { console.log(data); }
});
	
} else if($('body').hasClass('page-id-2')) {
	function initMap() {
	var uluru = {lat: 40.743371, lng: -73.990508};
	var map = new google.maps.Map(document.getElementById('map__office'), {
	zoom: 15,
	styles: [{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"labels","stylers":[{"lightness":-25},{"saturation":-100}]},
	   {
     featureType: "poi",
     stylers: [
      { visibility: "off" }
     ]   
    }],
	center: uluru
	});
	var marker = new google.maps.Marker({
	position: uluru,
	map: map
	});
	}
$('.map--toggle').click(function(){
    $('.map').fadeOut();
    $('.map--toggle').removeClass('active');
    $(this).addClass('active');
    var show = $(this).attr('data-show');
     $("#map__"+show).fadeIn();
    $("#map__"+show).animate({opacity:1});
});

} else if($('body').hasClass('single-work')) {	

$(document).on('ready', function(){
	
setMaxWidth();

var $slider = $('#slides')
$slider.imagesLoaded(function(){
	$('.loading-wrapper').fadeOut(function(){
		$('#slides').animate({opacity:1});
	});
});

$('#slides').slick({
  centerMode: true,
  centerPadding: '0',
  slidesToShow: 1,
  variableWidth: true,
  draggable: true,
//   appendArrows: 'body',
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerPadding: '0'
      }
    }
  ]
});


$('.slick-slide').click(function(){
	var currentSlide = $('#slides').slick('slickCurrentSlide');
	var clickedSlide = $(this).data('slick-index');
	console.log(clickedSlide);
	console.log(currentSlide);
	if(clickedSlide > currentSlide) {
		$('#slides').slick('slickNext');
	} else if(clickedSlide < currentSlide) {
		$('#slides').slick('slickPrev');
	}
});    
   
});

$( window ).bind( "resize", setMaxWidth );

function setMaxWidth() {
	$( "#slides img" ).css( "maxWidth", ( $( window ).width() * 0.9 | 0 ) + "px" );
}
	
} else if($('body').hasClass('post-type-archive-work')) {

function loadItems(pageNumber){    
// 	console.log('loading');
      $('a#inifiniteLoader').show('fast');
      $.ajax({
          url: "../wp-admin/admin-ajax.php",
          type:'POST',
          data: 'action=infinite_scroll&page_no='+pageNumber+'&loop_file=loop-work.php', 
          success: function(html){
	          var $items = $(html);
	          $grid.append( $items );
  	          $grid.imagesLoaded(function(){	
	  	        $.each($items, function(){
// 		  	        $('.featured_default').addClass('grid-item--featured');
		  	        $(this).removeClass('hidden');
	  	        });
	          	$grid.isotope('appended', $items);
	          });
// 				console.log(html);
          }
      });
  return false;
}

// init Isotope
var $grid = $('#grid'),
init = true,
pageNumber = 3,
maxPages = 3,
all,
buttonFilter,
filters = {},
$checkboxes = $('#filters input'),
filterSelector = window.location.hash.slice(1);

$grid.imagesLoaded(function(){
	if($('.grid-item--featured').length == 0) {
		$('.featured_default').addClass('grid-item--featured');	
	}
	$grid.isotope();
	$('.loading-wrapper').fadeOut();
	$('.grid-work').delay(100).animate({opacity: 1});
});

$grid.isotope({
	percentPosition: true,
	columnWidth: '.grid-sizer',
	itemSelector: '.grid-item',
	layoutMode: 'packery',
	filter: function() {
    	var $this = $(this);
		var searchResult = qsRegex ? $this.find('h3').text().match( qsRegex ) : true;
		var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
		return searchResult && buttonResult;
	},
	packery: {
		gutter: '.gutter-sizer',
	},
	getSortData: {
		category: '[data-category]',
		name: '.text'
	},
	sortBy: 'category'
});

/*
$grid.on('layoutComplete', function( event, laidOutItems ) {
if(pageNumber <= maxPages) {
	loadItems(pageNumber);
	pageNumber++;
	init = false;
}
	
});
*/

var isotope = $grid.data('isotope');

function activeClass(input) {
	$this = input;
	if ($($this).is(':checked')) {
		$($this).parents('a').addClass('selected');
	} else {
		$($this).parents('a').removeClass('selected');	
	}
}

$('#filters').on('change', function( jQEvent ) {
	var $checkbox = $( jQEvent.target );
	manageCheckbox( $checkbox );
	
	var comboFilter = getComboFilter( filters );
	buttonFilter = comboFilter;
	$grid.isotope();
});

function getComboFilter( filters ) {
	$('.grid-item').removeClass('grid-item--featured');
	var i = 0;
	var comboFilters = [];
	var message = [];

  for ( var prop in filters ) {
    message.push( filters[ prop ].join('') );
    
    var filterGroup = filters[ prop ];
    // skip to next filter group if it doesn't have any values
    if ( !filterGroup.length ) {
      continue;
    }
    if ( i === 0 ) {
      // copy to new array
      comboFilters = filterGroup.slice(0);
    } else {
      var filterSelectors = [];
      // copy to fresh array
      var groupCombo = comboFilters.slice(0); // [ A, B ]
      // merge filter Groups
      for (var k=0, len3 = filterGroup.length; k < len3; k++) {
        for (var j=0, len2 = groupCombo.length; j < len2; j++) {
          filterSelectors.push( groupCombo[j] + filterGroup[k] ); // [ 1, 2 ]
        }

      }
      // apply filter selectors to combo filters for next group
      comboFilters = filterSelectors;
    }
    i++;
  }
	
	addFeatured(comboFilters); 

  var comboFilter = comboFilters.join(', ');
  
  var hash = comboFilter.replace(/\s/g, '');
  window.location.hash = hash;
  return comboFilter;
}

function addFeatured(comboFilters) {
	var classFilters = comboFilters.map(function(el) {
		el = el.replace('.','');
	    return '.featured_'+el;
	}); 
	var classFilters = classFilters.join(',');
	$(classFilters).addClass('grid-item--featured');
}


function manageCheckbox( $checkbox ) {
	console.log(filters);
  var checkbox = $checkbox[0];

  var group = $checkbox.parents('.group').attr('data-group');
  // create array for filter group, if not there yet
  var filterGroup = filters[ group ];
  //new filter group clicked - clear other groups
  if ( !filterGroup ) {
	  console.log('new group');
	filters = {};
	$checkboxes.removeAttr('checked');
	filterDisplay(checkbox, group);
	filterGroup = filters[ group ] = [];
	if ( !checkbox.checked ) {
      checkbox.checked = 'checked';
    }
  }

  var isAll = $checkbox.hasClass('all');
  // reset filter group if the all box was checked
  if ( isAll ) {
    delete filters[ group ];
    if ( !checkbox.checked ) {
      checkbox.checked = 'checked';
    }
  }
  
  // index of
  var index = $.inArray( checkbox.value, filterGroup );

  if ( checkbox.checked ) {
    var selector = isAll ? 'input' : 'input.all';
    $checkbox.siblings( selector ).removeAttr('checked');


    if ( !isAll && index === -1 ) {
      // add filter to group
      filters[ group ].push( checkbox.value );
    }

  } else if ( !isAll ) {
    // remove filter from group
    filters[ group ].splice( index, 1 );
    // if unchecked the last box, check the all
    if ( !$checkbox.siblings('[checked]').length ) {
      $checkbox.siblings('input.all').attr('checked', 'checked');
    }
  }

}

function filterDisplay(input, group) {
	$this = input;
	var link = $(input).parents('a');
	console.log(group);
// 	console.log(link);
	$checkboxes.filter(':checked').each(function(){
		$checkboxes.removeAttr('checked');
	});
	$(input).attr('checked', 'checked');
	if(group == 'discipline-interiors' || group == 'interiors') {
		if($($this).not(':checked')) {
			$('.discipline-interiors input').prop('checked', true);
		}
		if($('.filter.interiors').is(':hidden')) {
			$('.filter').fadeOut();
			$('.filter.interiors').delay(400).fadeIn();	
		}
		$('.img--interiors').css('z-index',1);
		toggleLink('interiors');
	}
	if(group == 'discipline-architecture') {
		$('.discipline-architecture input').prop('checked', true);
		$('.filter').fadeOut();
		$('.filter.architecture').delay(400).fadeIn();
		$('.img--interiors').css('z-index',-1);
		toggleLink();
	}
	if(group == 'specialty-preservation') {
		$('.discipline-architecture input').prop('checked', true);
		$('.filter--three').fadeOut();
		$('.filter--three.preservation').delay(400).fadeIn();
		toggleLink();
	}
	if(group == 'preservation') {
		$('.discipline-architecture input').prop('checked', true);
		$('.specialty-preservation input').prop('checked', true);
		toggleLink();
	}
	if(group == 'architecture') {
		$('.discipline-architecture input').prop('checked', true);
		toggleLink();
	}
	if(group == 'specialty-sustainability') {
		$('.discipline-architecture input').prop('checked', true);
		$('.filter--three').fadeOut();
		toggleLink();
	}
}

function toggleLink(order) {
	$('.grid-item a').each(function(){
		var link = $(this).attr('href');
		link = link.split('?')[0];
		if(order == 'interiors') {
			$(this).attr('href', link+'?order=interiors');
		} else {
			$(this).attr('href', link);
		}
	});
}

function reset(all) {
	// 	console.log('reset & all: '+all);
	$('.featured_default').addClass('grid-item--featured');
	$('.quicksearch').val('');
	buttonFilter = '';
	qsRegex = '';
	window.location.hash = '';
	filters = {};
	$grid.isotope();
	if(all == false) {
		$('.filters a').find(':input').prop('checked', false);
	} else {
		$('#filters a').find(':input').prop('checked', false);	
	}
	$('.filter--two,.filter--three').fadeOut();
}

$('.filter--remove').on( 'click', function() {
	all = true;
	reset(all);
});

if(filterSelector) {
    var selectorClasses = filterSelector.split('.');
    	$.each( selectorClasses, function( i, selectorClass ) {
    	selectorClass = selectorClass.replace(',', '');
		$('#filters input[value=".' + selectorClass + '"]').delay(500 * i).click();
	});
}

var qsRegex, buttonFilter;
	
var $quicksearch = $('.quicksearch').keyup( debounce( function(e) {
  qsRegex = new RegExp( $quicksearch.val(), 'gi' );
  $grid.isotope();
}, 200 ) );

$('.quicksearch').submit(function(){
	return false;
});
	
// debounce so filtering doesn't happen every millisecond
function debounce( fn, threshold ) {
  var timeout;
  return function debounced() {
    if ( timeout ) {
      clearTimeout( timeout );
    }
    function delayed() {
      fn();
      timeout = null;
    }
    setTimeout( delayed, threshold || 100 );
  };
}

$grid.on( 'arrangeComplete', function( event, filteredItems ) {
	// 	console.log('arrangecomplete'+filter);
	if (filteredItems.length <= 0) {
	  	$('#empty').fadeIn();
	} else {
		$('#empty').hide();
	}
});

} //end work