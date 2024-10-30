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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
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
/* 1 */
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
/* 2 */
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

/***/ }),
/* 3 */,
/* 4 */,
/* 5 */
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

var Modal = __webpack_require__(6),
    $ = jQuery;

var Export = function Export() {
	var self = this;

	// Set params
	this.params = [];

	// Set modal
	this.modal = new Modal();

	// Set stop listener
	this.modal.onStop = function (options) {
		self.onStop(options);
	};
};

Export.prototype.setParams = function (params) {
	this.params = Cpiwm.Util.list(params);
};

Export.prototype.start = function (options, retries) {
	var self = this;
	retries = retries || 0;

	// Reset stop flag
	if (retries === 0) {
		this.stopExport(false);
	}

	// Stop running export
	if (this.isExportStopped()) {
		return;
	}

	// Initializing beforeunload event
	$(window).bind('beforeunload', function () {
		return cpiwm_locale.stop_exporting_your_website;
	});

	// Set initial status
	this.setStatus({ type: 'info', message: cpiwm_locale.preparing_to_export });

	// Set params
	var params = this.params.concat({ name: 'secret_key', value: cpiwm_export.secret_key });

	// Set additional params
	if (options) {
		params = params.concat(Cpiwm.Util.list(options));
	}

	// Export
	$.ajax({
		url: cpiwm_export.ajax.url,
		type: 'POST',
		dataType: 'json',
		data: params,
		dataFilter: function dataFilter(data) {
			return Cpiwm.Util.json(data);
		}
	}).done(function () {
		self.getStatus();
	}).done(function (result) {
		if (result) {
			self.run(result);
		}
	}).fail(function (xhr) {
		var timeout = retries * 1000;

		try {
			var json = Cpiwm.Util.json(xhr.responseText);
			if (json) {
				var result = JSON.parse(json);
				var error = result.errors.pop();
				if (error.message) {
					self.stopExport(true);
					self.setStatus({
						type: 'error',
						title: cpiwm_locale.unable_to_export,
						message: error.message
					});
					return;
				}
			}
		} catch (e) {}

		if (retries >= 5) {
			self.stopExport(true);
			self.setStatus({
				type: 'error',
				title: cpiwm_locale.unable_to_export,
				message: cpiwm_locale.unable_to_start_the_export
			});
			return;
		}

		retries++;

		setTimeout(self.start.bind(self, options, retries), timeout);
	});
};

Export.prototype.run = function (params, retries) {
	var self = this;
	retries = retries || 0;

	// Stop running export
	if (this.isExportStopped()) {
		return;
	}

	// Export
	$.ajax({
		url: cpiwm_export.ajax.url,
		type: 'POST',
		dataType: 'json',
		data: params,
		dataFilter: function dataFilter(data) {
			return Cpiwm.Util.json(data);
		}
	}).done(function (result) {
		if (result) {
			self.run(result);
		}
	}).fail(function (xhr) {
		var timeout = retries * 1000;

		try {
			var json = Cpiwm.Util.json(xhr.responseText);
			if (json) {
				var result = JSON.parse(json);
				var error = result.errors.pop();
				if (error.message) {
					self.stopExport(true);
					self.setStatus({
						type: 'error',
						title: cpiwm_locale.unable_to_export,
						message: error.message
					});
					return;
				}
			}
		} catch (e) {}

		if (retries >= 5) {
			self.stopExport(true);
			self.setStatus({
				type: 'error',
				title: cpiwm_locale.unable_to_export,
				message: cpiwm_locale.unable_to_run_the_export
			});
			return;
		}

		retries++;

		setTimeout(self.run.bind(self, params, retries), timeout);
	});
};

Export.prototype.clean = function (options, retries) {
	var self = this;
	retries = retries || 0;

	// Reset stop flag
	if (retries === 0) {
		this.stopExport(true);
	}

	// Set initial status
	this.setStatus({ type: 'info', message: cpiwm_locale.please_wait_stopping_the_export });

	// Set params
	var params = this.params.concat({ name: 'secret_key', value: cpiwm_export.secret_key }).concat({ name: 'priority', value: 300 });

	// Set additional params
	if (options) {
		params = params.concat(Cpiwm.Util.list(options));
	}

	// Clean
	$.ajax({
		url: cpiwm_export.ajax.url,
		type: 'POST',
		dataType: 'json',
		data: params,
		dataFilter: function dataFilter(data) {
			return Cpiwm.Util.json(data);
		}
	}).done(function () {
		// Unbinding the beforeunload event when we stop exporting
		$(window).unbind('beforeunload');

		// Destroy modal
		self.modal.destroy();
	}).fail(function (xhr) {
		var timeout = retries * 1000;

		try {
			var json = Cpiwm.Util.json(xhr.responseText);
			if (json) {
				var result = JSON.parse(json);
				var error = result.errors.pop();
				if (error.message) {
					self.stopExport(true);
					self.setStatus({
						type: 'error',
						title: cpiwm_locale.unable_to_export,
						message: error.message
					});
					return;
				}
			}
		} catch (e) {}

		if (retries >= 5) {
			self.stopExport(true);
			self.setStatus({
				type: 'error',
				title: cpiwm_locale.unable_to_export,
				message: cpiwm_locale.unable_to_stop_the_export
			});
			return;
		}

		retries++;

		setTimeout(self.clean.bind(self, options, retries), timeout);
	});
};

Export.prototype.getStatus = function () {
	var self = this;

	// Stop getting status
	if (this.isExportStopped()) {
		return;
	}

	this.statusXhr = $.ajax({
		url: cpiwm_export.status.url,
		type: 'GET',
		dataType: 'json',
		cache: false,
		dataFilter: function dataFilter(data) {
			return Cpiwm.Util.json(data);
		}
	}).done(function (params) {
		if (params) {
			self.setStatus(params);

			// Next status
			switch (params.type) {
				case 'done':
				case 'error':
				case 'download':
					// Unbinding beforeunload event when any case is performed
					$(window).unbind('beforeunload');
					return;
			}
		}

		// Export is not done yet, let's check status in 3 seconds
		setTimeout(self.getStatus.bind(self), 3000);
	}).fail(function () {
		// Export is not done yet, let's check status in 3 seconds
		setTimeout(self.getStatus.bind(self), 3000);
	});
};

Export.prototype.setStatus = function (params) {
	this.modal.render(params);
};

Export.prototype.onStop = function (options) {
	this.clean(options);
};

Export.prototype.stopExport = function (isStopped) {
	try {
		if (isStopped) {
			this.statusXhr.abort();
		}
	} finally {
		this.isStopped = isStopped;
	}
};

Export.prototype.isExportStopped = function () {
	return this.isStopped;
};

module.exports = Export;

/***/ }),
/* 6 */
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

var $ = jQuery;

var Modal = function Modal() {
	var self = this;

	// Error Modal
	this.error = function (params) {
		// Create the modal container
		var container = $('<div></div>');

		// Create section to hold title, message and action
		var section = $('<section></section>');

		// Create header to hold title
		var header = $('<h1></h1>');

		// Create paragraph to hold mesage
		var message = $('<p></p>').html(params.message);

		// Create action section
		var action = $('<div></div>');

		// Create title
		var title = $('<span></span>').addClass('cpiwm-title-red').text(params.title);

		// Create close button
		var closeButton = $('<button type="button" class="cpiwm-button-red"></button>').on('click', function () {
			self.destroy();
		});

		// Append text to close button
		closeButton.append(cpiwm_locale.close_export);

		// Append close button to action
		action.append(closeButton);

		// Append title to section
		header.append(title);

		// Append header and message to section
		section.append(header).append(message);

		// Append section and action to container
		container.append(section).append(action);

		// Render modal
		self.modal.html(container).show();
		self.modal.focus();
		self.overlay.show();
	};

	// Info Modal
	this.info = function (params) {
		// Create the modal container
		var container = $('<div></div>');

		// Create section to hold title, message and action
		var section = $('<section></section>');

		// Create header to hold loader
		var header = $('<h1></h1>');

		// Create paragraph to hold mesage
		var message = $('<p></p>').html(params.message);

		// Create action section
		var action = $('<div></div>');

		// Create loader
		var loader = $('<span class="cpiwm-loader"></span>');

		// Create stop export
		var stopButton = $('<button type="button" class="cpiwm-button-red"></button>').on('click', function () {
			stopButton.attr('disabled', 'disabled');
			self.onStop();
		});

		// Append text to stop button
		stopButton.append('<i class="cpiwm-icon-notification"></i> ' + cpiwm_locale.stop_export);

		// Append stop button to action
		action.append(stopButton);

		// Append loader to header
		header.append(loader);

		// Append header and message to section
		section.append(header).append(message);

		// Append section and action to container
		container.append(section).append(action);

		// Render modal
		self.modal.html(container).show();
		self.modal.focus();
		self.overlay.show();
	};

	// Done Modal
	this.done = function (params) {
		// Create the modal container
		var container = $('<div></div>');

		// Create section to hold title, message and action
		var section = $('<section></section>');

		// Create header to hold title
		var header = $('<h1></h1>');

		// Create paragraph to hold mesage
		var message = $('<p></p>').html(params.message);

		// Create action section
		var action = $('<div></div>');

		// Create title
		var title = $('<span></span>').addClass('cpiwm-title-green').text(params.title);

		// Create close button
		var closeButton = $('<button type="button" class="cpiwm-button-red"></button>').on('click', function () {
			self.destroy();
		});

		// Append text to close button
		closeButton.append(cpiwm_locale.close_export);

		// Append close button to action
		action.append(closeButton);

		// Append title to section
		header.append(title);

		// Append header and message to section
		section.append(header).append(message);

		// Append section and action to container
		container.append(section).append(action);

		// Render modal
		self.modal.html(container).show();
		self.modal.focus();
		self.overlay.show();
	};

	// Download Modal
	this.download = function (params) {
		// Create the modal container
		var container = $('<div></div>');

		// Create section to hold title, message and action
		var section = $('<section></section>');

		// Create paragraph to hold mesage
		var message = $('<p></p>').html(params.message);

		// Create action section
		var action = $('<div></div>');

		// Create close button
		var closeButton = $('<button type="button" class="cpiwm-button-red"></button>').on('click', function () {
			self.destroy();
		});

		// Append text to close button
		closeButton.append(cpiwm_locale.close_export);

		// Append close button to action
		action.append(closeButton);

		// Append message to section
		section.append(message);

		// Append section and action to container
		container.append(section).append(action);

		// Render modal
		self.modal.html(container).show();
		self.modal.focus();
		self.overlay.show();
	};

	// Create the overlay
	this.overlay = $('<div class="cpiwm-overlay"></div>');

	// Create the modal container
	this.modal = $('<div class="cpiwm-modal-container" role="dialog" tabindex="-1"></div>');

	$('body').append(this.overlay) // Append overlay to body
	.append(this.modal); // Append modal to body
};

Modal.prototype.render = function (params) {
	$(document).trigger('cpiwm-export-status', params);

	// Show modal
	switch (params.type) {
		case 'error':
			this.error(params);
			break;

		case 'info':
			this.info(params);
			break;

		case 'done':
			this.done(params);
			break;

		case 'download':
			this.download(params);
			break;
	}
};

Modal.prototype.destroy = function () {
	this.modal.hide();
	this.overlay.hide();
};

module.exports = Modal;

/***/ }),
/* 7 */,
/* 8 */,
/* 9 */
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

var Query = __webpack_require__(10),
    FindReplace = __webpack_require__(11),
    Feedback = __webpack_require__(1),
    Report = __webpack_require__(2),
    Export = __webpack_require__(5);

jQuery(document).ready(function ($) {
	'use strict';

	var model = new Export();

	// Export to file
	$('#cpiwm-export-file').click(function (e) {
		var storage = Cpiwm.Util.random(12);
		var options = Cpiwm.Util.form('#cpiwm-export-form').concat({ name: 'storage', value: storage });

		// Set global params
		model.setParams(options);

		// Start export
		model.start();

		e.preventDefault();
	});

	$('.cpiwm-accordion > .cpiwm-title').click(function () {
		$(this).parent().toggleClass('cpiwm-active');
	});

	$('#cpiwm-add-new-replace-button').cpiwm_find_replace();

	$('.cpiwm-expandable > p:first, .cpiwm-expandable > h4:first, .cpiwm-expandable > div.cpiwm-button-main').on('click', function () {
		$(this).parent().toggleClass('cpiwm-open');
	});

	$('.cpiwm-query').cpiwm_query();
});

global.Cpiwm = jQuery.extend({}, global.Cpiwm, { Query: Query, FindReplace: FindReplace, Feedback: Feedback, Report: Report, Export: Export });
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),
/* 10 */
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

(function ($) {
  $.fn.cpiwm_query = function () {
    var findInput = $(this).find('input.cpiwm-query-find-input'),
        replaceInput = $(this).find('input.cpiwm-query-replace-input'),
        findText = $(this).find('small.cpiwm-query-find-text'),
        replaceText = $(this).find('small.cpiwm-query-replace-text');

    findInput.on('change paste input keypress keydown keyup', function () {
      var _inputValue = $(this).val().length > 0 ? $(this).val() : '<text>';
      findText.text(_inputValue);
    });

    replaceInput.on('change paste input keypress keydown keyup', function () {
      var _inputValue = $(this).val().length > 0 ? $(this).val() : '<another-text>';
      replaceText.text(_inputValue);
    });

    return this;
  };
})(jQuery);

/***/ }),
/* 11 */
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

(function ($) {
  $.fn.cpiwm_find_replace = function () {
    $(this).click(function (e) {
      e.preventDefault();

      var row = $('#cpiwm-queries > li:first').clone();

      // Reset input values
      row.find('input').val('');

      // Reset cpiwm-query-find-text
      row.find('.cpiwm-query-find-text').html('&lt;text&gt;');

      // Reset cpiwm-query-replace-text
      row.find('.cpiwm-query-replace-text').html('&lt;another-text&gt;');

      $('#cpiwm-queries > li').removeClass('cpiwm-open');

      $(row).addClass('cpiwm-open');

      // Add new replace fields
      $('#cpiwm-queries').append(row);
      $(row).cpiwm_query();
      $(row).find('p:first').on('click', function () {
        $(this).parent().toggleClass('cpiwm-open');
      });
    });

    return this;
  };
})(jQuery);

/***/ })
/******/ ]);