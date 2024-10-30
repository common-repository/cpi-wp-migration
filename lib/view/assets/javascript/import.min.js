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
/******/ 	return __webpack_require__(__webpack_require__.s = 12);
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
/* 3 */
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

var Modal = __webpack_require__(4),
    $ = jQuery;

var Import = function Import() {
	var self = this;

	// Set params
	this.params = [];

	// Set modal
	this.modal = new Modal();

	// Set confirm listener
	this.modal.onConfirm = function (options) {
		self.onConfirm(options);
	};

	// Set blogs listener
	this.modal.onBlogs = function (options) {
		self.onBlogs(options);
	};

	// Set stop listener
	this.modal.onStop = function (options) {
		self.onStop(options);
	};
};

Import.prototype.setParams = function (params) {
	this.params = Cpiwm.Util.list(params);
};

Import.prototype.start = function (options, retries) {
	var self = this;
	retries = retries || 0;

	// Reset stop flag
	if (retries === 0) {
		this.stopImport(false);
	}

	// Stop running import
	if (this.isImportStopped()) {
		return;
	}

	// Initializing beforeunload event
	$(window).bind('beforeunload', function () {
		return cpiwm_locale.stop_importing_your_website;
	});

	// Set initial status
	this.setStatus({ type: 'info', message: cpiwm_locale.preparing_to_import });

	// Set params
	var params = this.params.concat({ name: 'secret_key', value: cpiwm_import.secret_key });

	// Set additional params
	if (options) {
		params = params.concat(Cpiwm.Util.list(options));
	}

	// Import
	$.ajax({
		url: cpiwm_import.ajax.url,
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
					self.stopImport(true);
					self.setStatus({
						type: 'error',
						title: cpiwm_locale.unable_to_import,
						message: error.message
					});
					return;
				}
			}
		} catch (e) {}

		if (retries >= 5) {
			self.stopImport(true);
			self.setStatus({
				type: 'error',
				title: cpiwm_locale.unable_to_import,
				message: cpiwm_locale.unable_to_start_the_import
			});
			return;
		}

		retries++;

		setTimeout(self.start.bind(self, options, retries), timeout);
	});
};

Import.prototype.run = function (params, retries) {
	var self = this;
	retries = retries || 0;

	// Stop running import
	if (this.isImportStopped()) {
		return;
	}

	// Import
	$.ajax({
		url: cpiwm_import.ajax.url,
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
					self.stopImport(true);
					self.setStatus({
						type: 'error',
						title: cpiwm_locale.unable_to_import,
						message: error.message
					});
					return;
				}
			}
		} catch (e) {}

		retries++;

		setTimeout(self.run.bind(self, params, retries), timeout);
	});
};

Import.prototype.confirm = function (options, retries) {
	var self = this;
	retries = retries || 0;

	// Stop running import
	if (this.isImportStopped()) {
		return;
	}

	// Set params
	var params = this.params.concat({ name: 'secret_key', value: cpiwm_import.secret_key }).concat({ name: 'priority', value: 150 });

	// Set additional params
	if (options) {
		params = params.concat(Cpiwm.Util.list(options));
	}

	// Confirm
	$.ajax({
		url: cpiwm_import.ajax.url,
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
					self.stopImport(true);
					self.setStatus({
						type: 'error',
						title: cpiwm_locale.unable_to_import,
						message: error.message
					});
					return;
				}
			}
		} catch (e) {}

		if (retries >= 5) {
			self.stopImport(true);
			self.setStatus({
				type: 'error',
				title: cpiwm_locale.unable_to_import,
				message: cpiwm_locale.unable_to_confirm_the_import
			});
			return;
		}

		retries++;

		setTimeout(self.confirm.bind(self, options, retries), timeout);
	});
};

Import.prototype.hasEnoughDiskSpace = function (backupSize) {
	if (cpiwm_disk_space.free && backupSize) {
		var requiredDiskSpace = backupSize * cpiwm_disk_space.factor + parseInt(cpiwm_disk_space.extra, 10);
		return cpiwm_disk_space.free >= requiredDiskSpace;
	}

	return true;
};

Import.prototype.getNoDiskSpaceMessage = function (backupSize) {
	var requiredDiskSpace = backupSize * cpiwm_disk_space.factor + parseInt(cpiwm_disk_space.extra, 10);
	var additionalDiskSpaceText = Cpiwm.Util.sizeFormat(requiredDiskSpace - cpiwm_disk_space.free);

	return cpiwm_locale.out_of_disk_space.replace('%s', additionalDiskSpaceText);
};

Import.prototype.blogs = function (options, retries) {
	var self = this;
	retries = retries || 0;

	// Stop running import
	if (this.isImportStopped()) {
		return;
	}

	// Set params
	var params = this.params.concat({ name: 'secret_key', value: cpiwm_import.secret_key }).concat({ name: 'priority', value: 150 });

	// Set additional params
	if (options) {
		params = params.concat(Cpiwm.Util.list(options));
	}

	// Blogs
	$.ajax({
		url: cpiwm_import.ajax.url,
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
					self.stopImport(true);
					self.setStatus({
						type: 'error',
						title: cpiwm_locale.unable_to_import,
						message: error.message
					});
					return;
				}
			}
		} catch (e) {}

		if (retries >= 5) {
			self.stopImport(true);
			self.setStatus({
				type: 'error',
				title: cpiwm_locale.unable_to_import,
				message: cpiwm_locale.unable_to_prepare_blogs_on_import
			});
			return;
		}

		retries++;

		setTimeout(self.blogs.bind(self, options, retries), timeout);
	});
};

Import.prototype.clean = function (options, retries) {
	var self = this;
	retries = retries || 0;

	// Reset stop flag
	if (retries === 0) {
		this.stopImport(true);
	}

	// Set initial status
	this.setStatus({ type: 'info', message: cpiwm_locale.please_wait_stopping_the_import });

	// Set params
	var params = this.params.concat({ name: 'secret_key', value: cpiwm_import.secret_key }).concat({ name: 'priority', value: 400 });

	// Set additional params
	if (options) {
		params = params.concat(Cpiwm.Util.list(options));
	}

	// Clean
	$.ajax({
		url: cpiwm_import.ajax.url,
		type: 'POST',
		dataType: 'json',
		data: params,
		dataFilter: function dataFilter(data) {
			return Cpiwm.Util.json(data);
		}
	}).done(function () {
		// Unbinding the beforeunload event when we stop importing
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
					self.stopImport(true);
					self.setStatus({
						type: 'error',
						title: cpiwm_locale.unable_to_import,
						message: error.message
					});
					return;
				}
			}
		} catch (e) {}

		if (retries >= 5) {
			self.stopImport(true);
			self.setStatus({
				type: 'error',
				title: cpiwm_locale.unable_to_import,
				message: cpiwm_locale.unable_to_stop_the_import
			});
			return;
		}

		retries++;

		setTimeout(self.clean.bind(self, options, retries), timeout);
	});
};

Import.prototype.getStatus = function () {
	var self = this;

	// Stop getting status
	if (this.isImportStopped()) {
		return;
	}

	this.statusXhr = $.ajax({
		url: cpiwm_import.status.url,
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
					// Unbinding the beforeunload event when any case is performed
					$(window).unbind('beforeunload');
					return;

				case 'confirm':
				case 'disk_space_confirm':
				case 'blogs':
					return;
			}
		}

		// Import is not done yet, let's check status in 3 seconds
		setTimeout(self.getStatus.bind(self), 3000);
	}).fail(function () {
		// Import is not done yet, let's check status in 3 seconds
		setTimeout(self.getStatus.bind(self), 3000);
	});
};

Import.prototype.setStatus = function (params) {
	this.modal.render(params);
};

Import.prototype.onConfirm = function (options) {
	this.confirm(options);
};

Import.prototype.onBlogs = function (options) {
	this.blogs(options);
};

Import.prototype.onStop = function (options) {
	this.clean(options);
};

Import.prototype.stopImport = function (isStopped) {
	try {
		if (isStopped) {
			this.statusXhr.abort();
		}
	} finally {
		this.isStopped = isStopped;
	}
};

Import.prototype.isImportStopped = function () {
	return this.isStopped;
};

module.exports = Import;

/***/ }),
/* 4 */
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
		closeButton.append(cpiwm_locale.close_import);

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

	// Progress Modal
	this.progress = function (params) {
		// Update progress bar meter
		if (this.progress.progressBarMeter) {
			this.progress.progressBarMeter.width(params.percent + '%');
		}

		// Update progress bar percent
		if (this.progress.progressBarPercent) {
			this.progress.progressBarPercent.text(params.percent + '%');
			return;
		}

		// Create the modal container
		var container = $('<div></div>');

		// Create section to hold title, message and action
		var section = $('<section></section>');

		// Create header to hold progress bar
		var header = $('<h1></h1>');

		// Create action section
		var action = $('<div></div>');

		// Create progress bar
		var progressBar = $('<span class="cpiwm-progress-bar"></span>');

		// Create progress bar meter
		this.progress.progressBarMeter = $('<span class="cpiwm-progress-bar-meter"></span>').width(params.percent + '%');

		// Create progress bar percent
		this.progress.progressBarPercent = $('<span class="cpiwm-progress-bar-percent"></span>').text(params.percent + '%');

		// Create stop import
		var stopButton = $('<button type="button" class="cpiwm-button-red"></button>').on('click', function () {
			stopButton.attr('disabled', 'disabled');
			self.onStop();
		});

		// Append text to stop button
		stopButton.append('<i class="cpiwm-icon-notification"></i> ' + cpiwm_locale.stop_import);

		// Append progress meter and progress percent
		progressBar.append(this.progress.progressBarMeter).append(this.progress.progressBarPercent);

		// Append stop button to action
		action.append(stopButton);

		// Append progress bar to section
		header.append(progressBar);

		// Append header to section
		section.append(header);

		// Append section and action to container
		container.append(section).append(action);

		// Render modal
		self.modal.html(container).show();
		self.modal.focus();
		self.overlay.show();
	};

	// Pro Modal
	this.pro = function (params) {
		// Create the modal container
		var container = $('<div></div>');

		// Create section to hold title, message and action
		var section = $('<section></section>');

		// Create header to hold warning
		var header = $('<h1></h1>');

		// Create paragraph to hold mesage
		var message = $('<p class="cpiwm-import-modal-content"></p>').html(params.message);

		// Create action section
		var action = $('<div></div>');

		// Create warning
		var warning = $('<i class="cpiwm-icon-notification"></i>');

		// Create close button
		var closeButton = $('<button type="button" class="cpiwm-button-gray"></button>').on('click', function () {
			self.destroy();
		});

		// Append text to close button
		closeButton.append(cpiwm_locale.close_import);

		// Append close button to action
		action.append(closeButton);

		// Append warning to section
		header.append(warning);

		// Append header and message to section
		section.append(header).append(message);

		// Append section and action to container
		container.append(section).append(action);

		// Render modal
		self.modal.html(container).show();
		self.modal.focus();
		self.overlay.show();
	};

	// Confirm Modal
	this.confirm = function (params) {
		// Create the modal container
		var container = $('<div></div>');

		// Create section to hold title, message and action
		var section = $('<section></section>');

		// Create header to hold warning
		var header = $('<h1></h1>');

		// Create paragraph to hold mesage
		var message = $('<p class="cpiwm-import-modal-content"></p>').html(params.message);

		// Create action section
		var action = $('<div class="cpiwm-import-modal-actions"></div>');

		// Create warning
		var warning = $('<i class="cpiwm-icon-notification"></i>');

		// Create close button
		var closeButton = $('<button type="button" class="cpiwm-button-gray"></button>').on('click', function () {
			closeButton.attr('disabled', 'disabled');
			self.onStop();
		});

		// Create confirm button
		var confirmButton = $('<button type="button" class="cpiwm-button-green"></button>').on('click', function () {
			confirmButton.attr('disabled', 'disabled');
			self.onConfirm();
		});

		// Append text to close button
		closeButton.append(cpiwm_locale.close_import);

		// Append text to confirm button
		confirmButton.append(cpiwm_locale.confirm_import + ' &gt;');

		// Append close button to action
		action.append(closeButton);

		// Append confirm button to action
		action.append(confirmButton);

		// Append warning to section
		header.append(warning);

		// Append header and message to section
		section.append(header).append(message);

		// Append section and action to container
		container.append(section).append(action);

		// Render modal
		self.modal.html(container).show();
		self.modal.focus();
		self.overlay.show();
	};

	// Disk space Confirm Modal
	this.diskSpaceConfirm = function (params) {
		// Create the modal container
		var container = $('<div></div>');

		// Create section to hold title, message and action
		var section = $('<section></section>');

		// Create header to hold warning
		var header = $('<h1></h1>');

		// Create paragraph to hold mesage
		var message = $('<p class="cpiwm-import-modal-content"></p>').html(params.message);

		// Create action section
		var action = $('<div class="cpiwm-import-modal-actions"></div>');

		// Create warning
		var warning = $('<i class="cpiwm-icon-notification"></i>');

		// Create close button
		var closeButton = $('<button type="button" class="cpiwm-button-gray"></button>').on('click', function () {
			self.destroy();
		});

		// Create confirm button
		var confirmButton = $('<button type="button" class="cpiwm-button-green"></button>').on('click', function () {
			$(this).attr('disabled', 'disabled');
			if (params.onProceed) {
				params.onProceed();
			}
		});

		// Append text to close button
		closeButton.append(cpiwm_locale.close_import);

		// Append text to confirm button
		confirmButton.append(cpiwm_locale.confirm_disk_space);

		// Append close button to action
		action.append(closeButton);

		// Append confirm button to action
		action.append(confirmButton);

		// Append warning to section
		header.append(warning);

		// Append header and message to section
		section.append(header).append(message);

		// Append section and action to container
		container.append(section).append(action);

		// Render modal
		self.modal.html(container).show();
		self.modal.focus();
		self.overlay.show();
	};

	// Blogs Modal
	this.blogs = function (params) {
		// Create the modal container
		var container = $('<form></form>').on('submit', function (e) {
			e.preventDefault();
			continueButton.attr('disabled', 'disabled');
			self.onBlogs(container.serializeArray());
		});

		// Create section to hold title, message and action
		var section = $('<section></section>');

		// Create header to hold title
		var header = $('<h1></h1>');

		// Create paragraph to hold mesage
		var message = $('<p></p>').html(params.message);

		// Create action section
		var action = $('<div></div>');

		// Create title
		var title = $('<span></span>').addClass('cpiwm-title-grey').text(params.title);

		// Create continue button
		var continueButton = $('<button type="submit" class="cpiwm-button-green"></button>');

		// Append text to continue button
		continueButton.append(cpiwm_locale.continue_import);

		// Append continue button to action
		action.append(continueButton);

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

		// Create warning
		var warning = $('<p></p>').html(cpiwm_locale.please_do_not_close_this_browser);

		// Create notice to be displayed during import process
		var notice = $('<div class="cpiwm-import-modal-notice"></div>');

		// Append warning to notice
		notice.append(warning);

		// Append stop button to action
		action.append(notice);

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
		var message = $('<p class="cpiwm-import-modal-content-done"></p>').html(params.message);

		// Create action section
		var action = $('<div class="cpiwm-import-modal-actions"></div>');

		// Create title
		var title = $('<span></span>').addClass('cpiwm-title-green').text(params.title);

		// Create close button
		var closeButton = $('<button type="button" class="cpiwm-button-green"></button>').on('click', function () {
			self.destroy();
		});

		// Append text to close button
		closeButton.append(cpiwm_locale.finish_import + ' &gt;');

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

	// Create the overlay
	this.overlay = $('<div class="cpiwm-overlay"></div>');

	// Create the modal container
	this.modal = $('<div class="cpiwm-modal-container" role="dialog" tabindex="-1"></div>');

	$('body').append(this.overlay) // Append overlay to body
	.append(this.modal); // Append modal to body
};

Modal.prototype.render = function (params) {
	$(document).trigger('cpiwm-import-status', params);

	// Show modal
	switch (params.type) {
		case 'pro':
			this.pro(params);
			break;

		case 'error':
			this.error(params);
			break;

		case 'confirm':
			this.confirm(params);
			break;

		case 'disk_space_confirm':
			this.diskSpaceConfirm(params);
			break;

		case 'blogs':
			this.blogs(params);
			break;

		case 'progress':
			this.progress(params);
			break;

		case 'info':
			this.info(params);
			break;

		case 'done':
			this.done(params);
			break;
	}
};

Modal.prototype.destroy = function () {
	this.modal.hide();
	this.overlay.hide();
};

module.exports = Modal;

/***/ }),
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */,
/* 10 */,
/* 11 */,
/* 12 */
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

var FileUploader = __webpack_require__(13),
    Feedback = __webpack_require__(1),
    Report = __webpack_require__(2),
    Import = __webpack_require__(3);

jQuery(document).ready(function ($) {
  'use strict';

  var uploader = void 0;
  if (Cpiwm.MultisiteExtensionUploader) {
    uploader = new Cpiwm.MultisiteExtensionUploader();
  } else if (Cpiwm.UnlimitedExtensionUploader) {
    uploader = new Cpiwm.UnlimitedExtensionUploader();
  } else if (Cpiwm.FileExtensionUploader) {
    uploader = new Cpiwm.FileExtensionUploader();
  } else {
    uploader = new Cpiwm.FileUploader();
  }

  uploader.init();

  // Expands/Collapses Import from
  $('.cpiwm-expandable > div.cpiwm-button-main').on('click', function () {
    $(this).parent().toggleClass('cpiwm-open');
  });
});

global.Cpiwm = jQuery.extend({}, global.Cpiwm, { FileUploader: FileUploader, Feedback: Feedback, Report: Report, Import: Import });
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),
/* 13 */
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

var Import = __webpack_require__(3),
    $ = jQuery;

var FileUploader = function FileUploader() {};

FileUploader.prototype.setDefaultValues = function () {
	this.model = new Import();
	this.stopUpload = false;
};

FileUploader.prototype.init = function () {
	var _this = this;

	var formElement = $('#cpiwm-import-form');
	var selectElement = $('#cpiwm-import-file');
	var dropElement = $('#cpiwm-drag-drop-area');

	selectElement.on('change', function (e) {
		_this.setDefaultValues();

		var file = e.target.files.item(0);
		if (file) {
			if (file.size > cpiwm_uploader.max_file_size) {
				_this.model.setStatus({ type: 'pro', message: cpiwm_locale.import_from_file });
			} else {
				var upload = function upload() {
					try {
						_this.onFilesAdded(file);
						_this.onBeforeUpload(file);
						_this.upload(file);
					} catch (error) {
						_this.onError(error);
					}
				};

				if (_this.model.hasEnoughDiskSpace(file.size)) {
					upload();
				} else {
					_this.model.setStatus({
						type: 'disk_space_confirm',
						message: _this.model.getNoDiskSpaceMessage(file.size),
						onProceed: upload
					});
				}
			}
		}

		formElement.trigger('reset');
		e.preventDefault();
	});

	dropElement.on('dragenter', function (e) {
		dropElement.addClass('cpiwm-drag-over');
		e.preventDefault();
	});

	dropElement.on('dragover', function (e) {
		dropElement.addClass('cpiwm-drag-over');
		e.preventDefault();
	});

	dropElement.on('dragleave', function (e) {
		dropElement.removeClass('cpiwm-drag-over');
		e.preventDefault();
	});

	dropElement.on('drop', function (e) {
		_this.setDefaultValues();
		dropElement.removeClass('cpiwm-drag-over');

		var file = e.originalEvent.dataTransfer.files.item(0);
		if (file) {
			if (file.size > cpiwm_uploader.max_file_size) {
				_this.model.setStatus({ type: 'pro', message: cpiwm_locale.import_from_file });
			} else {
				var upload = function upload() {
					try {
						_this.onFilesAdded(file);
						_this.onBeforeUpload(file);
						_this.upload(file);
					} catch (error) {
						_this.onError(error);
					}
				};

				if (_this.model.hasEnoughDiskSpace(file.size)) {
					upload();
				} else {
					_this.model.setStatus({
						type: 'disk_space_confirm',
						message: _this.model.getNoDiskSpaceMessage(file.size),
						onProceed: upload
					});
				}
			}
		}

		formElement.trigger('reset');
		e.preventDefault();
	});
};

// Check extension
FileUploader.prototype.c1 = function (file) {
	if (file.name.substr(-6) !== 'wpress') {
		throw new Error(cpiwm_locale.invalid_archive_extension);
	}
};

// Check compatibility
FileUploader.prototype.c3 = function () {
	if (cpiwm_compatibility.messages.length > 0) {
		throw new Error(cpiwm_compatibility.messages.join());
	}
};

FileUploader.prototype.onFilesAdded = function (file) {
	this.c1(file);
	this.c3(file);

	// Initializing beforeunload event
	$(window).bind('beforeunload', function () {
		return cpiwm_locale.stop_importing_your_website;
	});
};

FileUploader.prototype.onBeforeUpload = function (file) {
	var self = this;

	var storage = Cpiwm.Util.random(12);
	var options = Cpiwm.Util.form('#cpiwm-import-form').concat({ name: 'storage', value: storage }).concat({ name: 'archive', value: file.name });

	// Set global params
	this.model.setParams(options);

	// Set multipart params
	$.extend(cpiwm_uploader.params, {
		storage: storage,
		archive: file.name
	});

	// Set stop
	this.model.onStop = function () {
		self.stopUpload = true;

		// Clean storage
		self.model.clean();
	};

	// Set status
	this.model.setStatus({ type: 'progress', percent: '0.00' });
};
FileUploader.prototype.uploadFile =function(fileInput) {
  	var chunk_size = 1024 * 1024; // 1mb
	var reader = new FileReader();
    this._uploadChunk(fileInput, 0, chunk_size);  
}
 
FileUploader.prototype._uploadChunk = function(file, offset, range) {
  var reader = new FileReader();
  var self = this;
  // if no more chunks, send EOF
  if(offset >= file.size) {
    jQuery.post(cpiwm_uploader.url, {
      filename: file.name,
      storage: Cpiwm.Util.random(12),
      eof: true
    }).done(function(response){
      self.onFileUploaded();
	});
    return;
  }
 
  // prepare reader with an event listener
  reader.addEventListener('load', function(e) {
  	var chunk_size = range;
    var filename = file.name;
    var index = offset / chunk_size;
    var maxIndex = file.size / chunk_size;
    var data = e.target.result.split(';base64,')[1];
 
    // build payload with indexed chunk to be sent
    var payload = {
      filename: filename,
      index: index,
      data: data,
    };
 
    // send payload, and buffer next chunk to be uploaded
    jQuery.post(cpiwm_uploader.url,
      payload,
      function() {
        self._uploadChunk(file, offset + range, chunk_size);
      }
    ).done(function(response){
    	var percent = index / maxIndex * 100;
		self.model.setStatus({ type: 'progress', percent: percent.toFixed(2) });
    });
  }, {once: true} ); // register as a once handler!
 
  // chunk and read file data
  var chunk = file.slice(offset, offset + range);
  reader.readAsDataURL(chunk);
}
FileUploader.prototype.upload = function(file) {
	var self = this;

	var formData = new FormData();
	formData.append('upload-file', file);
	for (var name in cpiwm_uploader.params) {
		formData.append(name, cpiwm_uploader.params[name]);
	}
	self.uploadFile(file);
	// $.ajax({
	// 	url: cpiwm_uploader.url,
	// 	type: 'POST',
	// 	data: formData,
	// 	cache: false,
	// 	contentType: false,
	// 	processData: false,
	// 	xhr: function xhr() {
	// 		var handle = $.ajaxSettings.xhr();
	// 		if (handle.upload) {
	// 			handle.upload.addEventListener('progress', function (event) {
	// 				var percent = event.loaded / event.total * 100;
	// 				self.model.setStatus({ type: 'progress', percent: percent.toFixed(2) });
	// 			});
	// 		}

	// 		return handle;
	// 	},
	// 	success: function success() {
	// 		if (self.stopUpload) {
	// 			return;
	// 		}

	// 		self.onFileUploaded();
	// 	},
	// 	error: function error(jqXHR, textStatus) {
	// 		throw new Error(textStatus);
	// 	}
	// });
};

FileUploader.prototype.onUploadProgress = function (percent) {
	this.model.setStatus({ type: 'progress', percent: percent });
};

FileUploader.prototype.onFileUploaded = function () {
	this.model.start();
};

FileUploader.prototype.onError = function (error) {
	this.model.setStatus({ type: 'error', title: cpiwm_locale.unable_to_import, message: error.message });
};

module.exports = FileUploader;

/***/ })
/******/ ]);