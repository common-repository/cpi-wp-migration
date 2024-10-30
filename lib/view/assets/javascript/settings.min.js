/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 14);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Copyright (C) 2014-2019 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

jQuery(document).ready(function ($) {
	'use strict';

	// Idea

	$('#cpiwm-feedback-type-link-1').click(function () {
		var radio = $('#cpiwm-feedback-type-1');
		if (radio.is(':checked')) {
			radio.attr('checked', false);
		} else {
			radio.attr('checked', true);
		}
	});

	// Help
	$('#cpiwm-feedback-type-2').click(function () {
		// Hide other options
		$('#cpiwm-feedback-type-1').closest('li').hide();

		// Change placeholder message
		$('.cpiwm-feedback-form').find('.cpiwm-feedback-message').attr('placeholder', cpiwm_locale.how_may_we_help_you);

		// Show feedback form
		$('.cpiwm-feedback-form').fadeIn();
	});

	// Cancel feedback form
	$('#cpiwm-feedback-cancel').click(function (e) {
		$('.cpiwm-feedback-form').fadeOut(function () {
			$('.cpiwm-feedback-type').attr('checked', false).closest('li').show();
		});

		e.preventDefault();
	});

	// Send feedback form
	$('#cpiwm-feedback-submit').click(function (e) {
		var self = $(this);

		var spinner = self.next();
		var type = $('.cpiwm-feedback-type:checked').val();
		var email = $('.cpiwm-feedback-email').val();
		var message = $('.cpiwm-feedback-message').val();
		var terms = $('.cpiwm-feedback-terms').is(':checked');

		self.attr('disabled', true);
		spinner.css('visibility', 'visible');

		$.ajax({
			url: cpiwm_feedback.ajax.url,
			type: 'POST',
			dataType: 'json',
			async: true,
			data: {
				secret_key: cpiwm_feedback.secret_key,
				cpiwm_type: type,
				cpiwm_email: email,
				cpiwm_message: message,
				cpiwm_terms: +terms
			},
			dataFilter: function dataFilter(data) {
				return Cpiwm.Util.json(data);
			}
		}).done(function (data) {
			self.attr('disabled', false);
			spinner.css('visibility', 'hidden');

			if (data.errors.length > 0) {
				$('.cpiwm-feedback .cpiwm-message').remove();

				var errorMessage = $('<div />').addClass('cpiwm-message cpiwm-error-message');
				$.each(data.errors, function (key, value) {
					errorMessage.append($('<p />').text(value));
				});

				$('.cpiwm-feedback').prepend(errorMessage);
			} else {
				var successMessage = $('<div />').addClass('cpiwm-message cpiwm-success-message');
				successMessage.append($('<p />').text(cpiwm_locale.thanks_for_submitting_your_feedback));

				$('.cpiwm-feedback').html(successMessage);
			}
		});

		e.preventDefault();
	});
});

/***/ }),

/***/ 14:
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(global) {

/**
 * Copyright (C) 2014-2019 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

var Feedback = __webpack_require__(1),
    Report = __webpack_require__(2);

jQuery(document).ready(function () {
  'use strict';
});

global.Cpiwm = jQuery.extend({}, global.Cpiwm, { Feedback: Feedback, Report: Report });
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),

/***/ 2:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Copyright (C) 2014-2019 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

jQuery(document).ready(function ($) {
	'use strict';

	$('#cpiwm-report-problem-button').click(function (e) {
		$(this).next('.cpiwm-report-problem-dialog').toggleClass('cpiwm-report-active');

		e.preventDefault();
	});

	$('#cpiwm-report-cancel').click(function (e) {
		$(this).closest('.cpiwm-report-problem-dialog').removeClass('cpiwm-report-active');

		e.preventDefault();
	});

	$('#cpiwm-report-submit').click(function (e) {
		var self = $(this);

		var spinner = self.next();
		var email = $('.cpiwm-report-email').val();
		var message = $('.cpiwm-report-message').val();
		var terms = $('.cpiwm-report-terms').is(':checked');

		self.attr('disabled', true);
		spinner.css('visibility', 'visible');

		$.ajax({
			url: cpiwm_report.ajax.url,
			type: 'POST',
			dataType: 'json',
			async: true,
			data: {
				secret_key: cpiwm_report.secret_key,
				cpiwm_email: email,
				cpiwm_message: message,
				cpiwm_terms: +terms
			},
			dataFilter: function dataFilter(data) {
				return Cpiwm.Util.json(data);
			}
		}).done(function (data) {
			self.attr('disabled', false);
			spinner.css('visibility', 'hidden');

			if (data.errors.length > 0) {
				$('.cpiwm-report-problem-dialog .cpiwm-message').remove();

				var errorMessage = $('<div />').addClass('cpiwm-message cpiwm-error-message');
				$.each(data.errors, function (key, value) {
					errorMessage.append($('<p />').text(value));
				});

				$('.cpiwm-report-problem-dialog').prepend(errorMessage);
			} else {
				var successMessage = $('<div />').addClass('cpiwm-message cpiwm-success-message');
				successMessage.append($('<p />').text(cpiwm_locale.thanks_for_submitting_your_request));

				$('.cpiwm-report-problem-dialog').html(successMessage);

				// Hide message
				setTimeout(function () {
					$('.cpiwm-report-problem-dialog').removeClass('cpiwm-report-active');
				}, 2000);
			}
		});

		e.preventDefault();
	});
});

/***/ })

/******/ });