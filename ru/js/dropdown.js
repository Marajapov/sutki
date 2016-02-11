/*
 * jQuery dropdown: A simple dropdown plugin
 *
 * Inspired by Bootstrap: http://twitter.github.com/bootstrap/javascript.html#dropdowns
 *
 * Copyright 2013 Cory LaViska for A Beautiful Site, LLC. (http://abeautifulsite.net/)
 *
 * Dual licensed under the MIT / GPL Version 2 licenses
 *
*/
if(jQuery) (function($) {

	$.extend($.fn, {
		dropdown: function(method, data) {

			switch( method ) {
				case 'hide':
					hideDropdowns();
					return $(this);
				case 'attach':
					return $(this).attr('data-dropdown', data);
				case 'detach':
					hideDropdowns();
					return $(this).removeAttr('data-dropdown');
				case 'disable':
					return $(this).addClass('dropdown-disabled');
				case 'enable':
					hideDropdowns();
					return $(this).removeClass('dropdown-disabled');
			}

		}
	});

	function showDropdown(event) {

		var trigger = $(this),
			dropdown = $( $(this).attr('data-dropdown') ),
			isOpen = trigger.hasClass('dropdown-open'),
			hOffset = parseInt($(this).attr('data-horizontal-offset') || 0),
			vOffset = parseInt($(this).attr('data-vertical-offset') || 0);

		if( trigger !== event.target && $(event.target).hasClass('dropdown-ignore') ) return;

		event.preventDefault();
		event.stopPropagation();

		hideDropdowns();

		if( isOpen || trigger.hasClass('dropdown-disabled') ) return;

		// Disable window.resize handler for old IE (window.resize bug)
		$(window).off('resize.dropdown');

		dropdown
			.css({
				left: dropdown.hasClass('dropdown-anchor-right') ? 
					trigger.offset().left - (dropdown.outerWidth() - trigger.outerWidth()) + hOffset : trigger.offset().left + hOffset,
				top: trigger.offset().top + trigger.outerHeight() + vOffset
			})
			.show()
			.trigger('show', {
				dropdown: dropdown,
				trigger: trigger
			});

		trigger.addClass('dropdown-open');

		// Re-enable window.resize handler for old IE (window.resize bug)
		setTimeout( function() {
			$(window).on('resize.dropdown', hideDropdowns);
		}, 1);

	};

	function hideDropdowns(event) {

		var targetGroup = event ? $(event.target).parents().andSelf() : null;
		if( targetGroup && targetGroup.is('.dropdown') && !targetGroup.is('A') ) return;

		// Hide all dropdowns
		$('BODY').find('.dropdown').each( function() {
			var dropdown = $(this);
			if( dropdown.is(':visible') ) dropdown.hide().trigger('hide', {
				dropdown: dropdown
			});
		});

		// Remove all dropdown-open classes
		$('BODY').find('[data-dropdown]').removeClass('dropdown-open');

	};

	$(function() {
		$('BODY').on('click.dropdown', '[data-dropdown]', showDropdown);
		$('HTML').on('click.dropdown', hideDropdowns);
	});

})(jQuery);

/*
 * jQuery dropdown1: A simple dropdown1 plugin
 *
 * Inspired by Bootstrap: http://twitter.github.com/bootstrap/javascript.html#dropdown1s
 *
 * Copyright 2013 Cory LaViska for A Beautiful Site, LLC. (http://abeautifulsite.net/)
 *
 * Dual licensed under the MIT / GPL Version 2 licenses
 *
*/
if(jQuery) (function($) {

	$.extend($.fn, {
		dropdown1: function(method, data) {

			switch( method ) {
				case 'hide':
					hidedropdown1s();
					return $(this);
				case 'attach':
					return $(this).attr('data-dropdown1', data);
				case 'detach':
					hidedropdown1s();
					return $(this).removeAttr('data-dropdown1');
				case 'disable':
					return $(this).addClass('dropdown1-disabled');
				case 'enable':
					hidedropdown1s();
					return $(this).removeClass('dropdown1-disabled');
			}

		}
	});

	function showdropdown1(event) {

		var trigger = $(this),
			dropdown1 = $( $(this).attr('data-dropdown1') ),
			isOpen = trigger.hasClass('dropdown1-open'),
			hOffset = parseInt($(this).attr('data-horizontal-offset') || 0),
			vOffset = parseInt($(this).attr('data-vertical-offset') || 0);

		if( trigger !== event.target && $(event.target).hasClass('dropdown1-ignore') ) return;

		event.preventDefault();
		event.stopPropagation();

		hidedropdown1s();

		if( isOpen || trigger.hasClass('dropdown1-disabled') ) return;

		// Disable window.resize handler for old IE (window.resize bug)
		$(window).off('resize.dropdown1');

		dropdown1
			.css({
				left: dropdown1.hasClass('dropdown1-anchor-right') ? 
					trigger.offset().left - (dropdown1.outerWidth() - trigger.outerWidth()) + hOffset : trigger.offset().left + hOffset,
				top: trigger.offset().top + trigger.outerHeight() + vOffset
			})
			.show()
			.trigger('show', {
				dropdown1: dropdown1,
				trigger: trigger
			});

		trigger.addClass('dropdown1-open');

		// Re-enable window.resize handler for old IE (window.resize bug)
		setTimeout( function() {
			$(window).on('resize.dropdown1', hidedropdown1s);
		}, 1);

	};

	function hidedropdown1s(event) {

		var targetGroup = event ? $(event.target).parents().andSelf() : null;
		if( targetGroup && targetGroup.is('.dropdown1') && !targetGroup.is('A') ) return;

		// Hide all dropdown1s
		$('BODY').find('.dropdown1').each( function() {
			var dropdown1 = $(this);
			if( dropdown1.is(':visible') ) dropdown1.hide().trigger('hide', {
				dropdown1: dropdown1
			});
		});

		// Remove all dropdown1-open classes
		$('BODY').find('[data-dropdown1]').removeClass('dropdown1-open');

	};

	$(function() {
		$('BODY').on('click.dropdown1', '[data-dropdown1]', showdropdown1);
		$('HTML').on('click.dropdown1', hidedropdown1s);
	});

})(jQuery);