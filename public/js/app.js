(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app"],{

/***/ "./node_modules/@chenfengyuan/datepicker/dist/datepicker.js":
/*!******************************************************************!*\
  !*** ./node_modules/@chenfengyuan/datepicker/dist/datepicker.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/*!
 * Datepicker v1.0.9
 * https://fengyuanchen.github.io/datepicker
 *
 * Copyright 2014-present Chen Fengyuan
 * Released under the MIT license
 *
 * Date: 2019-09-21T06:57:34.100Z
 */

(function (global, factory) {
   true ? factory(__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")) :
  undefined;
}(this, function ($) { 'use strict';

  $ = $ && $.hasOwnProperty('default') ? $['default'] : $;

  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError("Cannot call a class as a function");
    }
  }

  function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor;
  }

  var DEFAULTS = {
    // Show the datepicker automatically when initialized
    autoShow: false,
    // Hide the datepicker automatically when picked
    autoHide: false,
    // Pick the initial date automatically when initialized
    autoPick: false,
    // Enable inline mode
    inline: false,
    // A element (or selector) for putting the datepicker
    container: null,
    // A element (or selector) for triggering the datepicker
    trigger: null,
    // The ISO language code (built-in: en-US)
    language: '',
    // The date string format
    format: 'mm/dd/yyyy',
    // The initial date
    date: null,
    // The start view date
    startDate: null,
    // The end view date
    endDate: null,
    // The start view when initialized
    startView: 0,
    // 0 for days, 1 for months, 2 for years
    // The start day of the week
    // 0 for Sunday, 1 for Monday, 2 for Tuesday, 3 for Wednesday,
    // 4 for Thursday, 5 for Friday, 6 for Saturday
    weekStart: 0,
    // Show year before month on the datepicker header
    yearFirst: false,
    // A string suffix to the year number.
    yearSuffix: '',
    // Days' name of the week.
    days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
    // Shorter days' name
    daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    // Shortest days' name
    daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
    // Months' name
    months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    // Shorter months' name
    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    // A element tag for each item of years, months and days
    itemTag: 'li',
    // A class (CSS) for muted date item
    mutedClass: 'muted',
    // A class (CSS) for picked date item
    pickedClass: 'picked',
    // A class (CSS) for disabled date item
    disabledClass: 'disabled',
    // A class (CSS) for highlight date item
    highlightedClass: 'highlighted',
    // The template of the datepicker
    template: '<div class="datepicker-container">' + '<div class="datepicker-panel" data-view="years picker">' + '<ul>' + '<li data-view="years prev">&lsaquo;</li>' + '<li data-view="years current"></li>' + '<li data-view="years next">&rsaquo;</li>' + '</ul>' + '<ul data-view="years"></ul>' + '</div>' + '<div class="datepicker-panel" data-view="months picker">' + '<ul>' + '<li data-view="year prev">&lsaquo;</li>' + '<li data-view="year current"></li>' + '<li data-view="year next">&rsaquo;</li>' + '</ul>' + '<ul data-view="months"></ul>' + '</div>' + '<div class="datepicker-panel" data-view="days picker">' + '<ul>' + '<li data-view="month prev">&lsaquo;</li>' + '<li data-view="month current"></li>' + '<li data-view="month next">&rsaquo;</li>' + '</ul>' + '<ul data-view="week"></ul>' + '<ul data-view="days"></ul>' + '</div>' + '</div>',
    // The offset top or bottom of the datepicker from the element
    offset: 10,
    // The `z-index` of the datepicker
    zIndex: 1000,
    // Filter each date item (return `false` to disable a date item)
    filter: null,
    // Event shortcuts
    show: null,
    hide: null,
    pick: null
  };

  var IS_BROWSER = typeof window !== 'undefined';
  var WINDOW = IS_BROWSER ? window : {};
  var IS_TOUCH_DEVICE = IS_BROWSER ? 'ontouchstart' in WINDOW.document.documentElement : false;
  var NAMESPACE = 'datepicker';
  var EVENT_CLICK = "click.".concat(NAMESPACE);
  var EVENT_FOCUS = "focus.".concat(NAMESPACE);
  var EVENT_HIDE = "hide.".concat(NAMESPACE);
  var EVENT_KEYUP = "keyup.".concat(NAMESPACE);
  var EVENT_PICK = "pick.".concat(NAMESPACE);
  var EVENT_RESIZE = "resize.".concat(NAMESPACE);
  var EVENT_SCROLL = "scroll.".concat(NAMESPACE);
  var EVENT_SHOW = "show.".concat(NAMESPACE);
  var EVENT_TOUCH_START = "touchstart.".concat(NAMESPACE);
  var CLASS_HIDE = "".concat(NAMESPACE, "-hide");
  var LANGUAGES = {};
  var VIEWS = {
    DAYS: 0,
    MONTHS: 1,
    YEARS: 2
  };

  var toString = Object.prototype.toString;
  function typeOf(obj) {
    return toString.call(obj).slice(8, -1).toLowerCase();
  }
  function isString(value) {
    return typeof value === 'string';
  }
  var isNaN = Number.isNaN || WINDOW.isNaN;
  function isNumber(value) {
    return typeof value === 'number' && !isNaN(value);
  }
  function isUndefined(value) {
    return typeof value === 'undefined';
  }
  function isDate(value) {
    return typeOf(value) === 'date' && !isNaN(value.getTime());
  }
  function proxy(fn, context) {
    for (var _len = arguments.length, args = new Array(_len > 2 ? _len - 2 : 0), _key = 2; _key < _len; _key++) {
      args[_key - 2] = arguments[_key];
    }

    return function () {
      for (var _len2 = arguments.length, args2 = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
        args2[_key2] = arguments[_key2];
      }

      return fn.apply(context, args.concat(args2));
    };
  }
  function selectorOf(view) {
    return "[data-view=\"".concat(view, "\"]");
  }
  function isLeapYear(year) {
    return year % 4 === 0 && year % 100 !== 0 || year % 400 === 0;
  }
  function getDaysInMonth(year, month) {
    return [31, isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
  }
  function getMinDay(year, month, day) {
    return Math.min(day, getDaysInMonth(year, month));
  }
  var formatParts = /(y|m|d)+/g;
  function parseFormat(format) {
    var source = String(format).toLowerCase();
    var parts = source.match(formatParts);

    if (!parts || parts.length === 0) {
      throw new Error('Invalid date format.');
    }

    format = {
      source: source,
      parts: parts
    };
    $.each(parts, function (i, part) {
      switch (part) {
        case 'dd':
        case 'd':
          format.hasDay = true;
          break;

        case 'mm':
        case 'm':
          format.hasMonth = true;
          break;

        case 'yyyy':
        case 'yy':
          format.hasYear = true;
          break;

        default:
      }
    });
    return format;
  }
  function getScrollParent(element) {
    var includeHidden = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var $element = $(element);
    var position = $element.css('position');
    var excludeStaticParent = position === 'absolute';
    var overflowRegex = includeHidden ? /auto|scroll|hidden/ : /auto|scroll/;
    var scrollParent = $element.parents().filter(function (index, parent) {
      var $parent = $(parent);

      if (excludeStaticParent && $parent.css('position') === 'static') {
        return false;
      }

      return overflowRegex.test($parent.css('overflow') + $parent.css('overflow-y') + $parent.css('overflow-x'));
    }).eq(0);
    return position === 'fixed' || !scrollParent.length ? $(element.ownerDocument || document) : scrollParent;
  }
  /**
   * Add leading zeroes to the given value
   * @param {number} value - The value to add.
   * @param {number} [length=1] - The expected value length.
   * @returns {string} Returns converted value.
   */

  function addLeadingZero(value) {
    var length = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
    var str = String(Math.abs(value));
    var i = str.length;
    var result = '';

    if (value < 0) {
      result += '-';
    }

    while (i < length) {
      i += 1;
      result += '0';
    }

    return result + str;
  }

  var REGEXP_DIGITS = /\d+/g;
  var methods = {
    // Show the datepicker
    show: function show() {
      if (!this.built) {
        this.build();
      }

      if (this.shown) {
        return;
      }

      if (this.trigger(EVENT_SHOW).isDefaultPrevented()) {
        return;
      }

      this.shown = true;
      this.$picker.removeClass(CLASS_HIDE).on(EVENT_CLICK, $.proxy(this.click, this));
      this.showView(this.options.startView);

      if (!this.inline) {
        this.$scrollParent.on(EVENT_SCROLL, $.proxy(this.place, this));
        $(window).on(EVENT_RESIZE, this.onResize = proxy(this.place, this));
        $(document).on(EVENT_CLICK, this.onGlobalClick = proxy(this.globalClick, this));
        $(document).on(EVENT_KEYUP, this.onGlobalKeyup = proxy(this.globalKeyup, this));

        if (IS_TOUCH_DEVICE) {
          $(document).on(EVENT_TOUCH_START, this.onTouchStart = proxy(this.touchstart, this));
        }

        this.place();
      }
    },
    // Hide the datepicker
    hide: function hide() {
      if (!this.shown) {
        return;
      }

      if (this.trigger(EVENT_HIDE).isDefaultPrevented()) {
        return;
      }

      this.shown = false;
      this.$picker.addClass(CLASS_HIDE).off(EVENT_CLICK, this.click);

      if (!this.inline) {
        this.$scrollParent.off(EVENT_SCROLL, this.place);
        $(window).off(EVENT_RESIZE, this.onResize);
        $(document).off(EVENT_CLICK, this.onGlobalClick);
        $(document).off(EVENT_KEYUP, this.onGlobalKeyup);

        if (IS_TOUCH_DEVICE) {
          $(document).off(EVENT_TOUCH_START, this.onTouchStart);
        }
      }
    },
    toggle: function toggle() {
      if (this.shown) {
        this.hide();
      } else {
        this.show();
      }
    },
    // Update the datepicker with the current input value
    update: function update() {
      var value = this.getValue();

      if (value === this.oldValue) {
        return;
      }

      this.setDate(value, true);
      this.oldValue = value;
    },

    /**
     * Pick the current date to the element
     *
     * @param {String} _view (private)
     */
    pick: function pick(_view) {
      var $this = this.$element;
      var date = this.date;

      if (this.trigger(EVENT_PICK, {
        view: _view || '',
        date: date
      }).isDefaultPrevented()) {
        return;
      }

      date = this.formatDate(this.date);
      this.setValue(date);

      if (this.isInput) {
        $this.trigger('input');
        $this.trigger('change');
      }
    },
    // Reset the datepicker
    reset: function reset() {
      this.setDate(this.initialDate, true);
      this.setValue(this.initialValue);

      if (this.shown) {
        this.showView(this.options.startView);
      }
    },

    /**
     * Get the month name with given argument or the current date
     *
     * @param {Number} month (optional)
     * @param {Boolean} shortForm (optional)
     * @return {String} (month name)
     */
    getMonthName: function getMonthName(month, shortForm) {
      var options = this.options;
      var monthsShort = options.monthsShort;
      var months = options.months;

      if ($.isNumeric(month)) {
        month = Number(month);
      } else if (isUndefined(shortForm)) {
        shortForm = month;
      }

      if (shortForm === true) {
        months = monthsShort;
      }

      return months[isNumber(month) ? month : this.date.getMonth()];
    },

    /**
     * Get the day name with given argument or the current date
     *
     * @param {Number} day (optional)
     * @param {Boolean} shortForm (optional)
     * @param {Boolean} min (optional)
     * @return {String} (day name)
     */
    getDayName: function getDayName(day, shortForm, min) {
      var options = this.options;
      var days = options.days;

      if ($.isNumeric(day)) {
        day = Number(day);
      } else {
        if (isUndefined(min)) {
          min = shortForm;
        }

        if (isUndefined(shortForm)) {
          shortForm = day;
        }
      }

      if (min) {
        days = options.daysMin;
      } else if (shortForm) {
        days = options.daysShort;
      }

      return days[isNumber(day) ? day : this.date.getDay()];
    },

    /**
     * Get the current date
     *
     * @param {Boolean} formatted (optional)
     * @return {Date|String} (date)
     */
    getDate: function getDate(formatted) {
      var date = this.date;
      return formatted ? this.formatDate(date) : new Date(date);
    },

    /**
     * Set the current date with a new date
     *
     * @param {Date} date
     * @param {Boolean} _updated (private)
     */
    setDate: function setDate(date, _updated) {
      var filter = this.options.filter;

      if (isDate(date) || isString(date)) {
        date = this.parseDate(date);

        if ($.isFunction(filter) && filter.call(this.$element, date, 'day') === false) {
          return;
        }

        this.date = date;
        this.viewDate = new Date(date);

        if (!_updated) {
          this.pick();
        }

        if (this.built) {
          this.render();
        }
      }
    },

    /**
     * Set the start view date with a new date
     *
     * @param {Date|string|null} date
     */
    setStartDate: function setStartDate(date) {
      if (isDate(date) || isString(date)) {
        this.startDate = this.parseDate(date);
      } else {
        this.startDate = null;
      }

      if (this.built) {
        this.render();
      }
    },

    /**
     * Set the end view date with a new date
     *
     * @param {Date|string|null} date
     */
    setEndDate: function setEndDate(date) {
      if (isDate(date) || isString(date)) {
        this.endDate = this.parseDate(date);
      } else {
        this.endDate = null;
      }

      if (this.built) {
        this.render();
      }
    },

    /**
     * Parse a date string with the set date format
     *
     * @param {String} date
     * @return {Date} (parsed date)
     */
    parseDate: function parseDate(date) {
      var format = this.format;
      var parts = [];

      if (!isDate(date)) {
        if (isString(date)) {
          parts = date.match(REGEXP_DIGITS) || [];
        }

        date = date ? new Date(date) : new Date();

        if (!isDate(date)) {
          date = new Date();
        }

        if (parts.length === format.parts.length) {
          // Set year and month first
          $.each(parts, function (i, part) {
            var value = parseInt(part, 10);

            switch (format.parts[i]) {
              case 'yy':
                date.setFullYear(2000 + value);
                break;

              case 'yyyy':
                // Converts 2-digit year to 2000+
                date.setFullYear(part.length === 2 ? 2000 + value : value);
                break;

              case 'mm':
              case 'm':
                date.setMonth(value - 1);
                break;

              default:
            }
          }); // Set day in the last to avoid converting `31/10/2019` to `01/10/2019`

          $.each(parts, function (i, part) {
            var value = parseInt(part, 10);

            switch (format.parts[i]) {
              case 'dd':
              case 'd':
                date.setDate(value);
                break;

              default:
            }
          });
        }
      } // Ignore hours, minutes, seconds and milliseconds to avoid side effect (#192)


      return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    },

    /**
     * Format a date object to a string with the set date format
     *
     * @param {Date} date
     * @return {String} (formatted date)
     */
    formatDate: function formatDate(date) {
      var format = this.format;
      var formatted = '';

      if (isDate(date)) {
        var year = date.getFullYear();
        var month = date.getMonth();
        var day = date.getDate();
        var values = {
          d: day,
          dd: addLeadingZero(day, 2),
          m: month + 1,
          mm: addLeadingZero(month + 1, 2),
          yy: String(year).substring(2),
          yyyy: addLeadingZero(year, 4)
        };
        formatted = format.source;
        $.each(format.parts, function (i, part) {
          formatted = formatted.replace(part, values[part]);
        });
      }

      return formatted;
    },
    // Destroy the datepicker and remove the instance from the target element
    destroy: function destroy() {
      this.unbind();
      this.unbuild();
      this.$element.removeData(NAMESPACE);
    }
  };

  var handlers = {
    click: function click(e) {
      var $target = $(e.target);
      var options = this.options,
          date = this.date,
          viewDate = this.viewDate,
          format = this.format;
      e.stopPropagation();
      e.preventDefault();

      if ($target.hasClass('disabled')) {
        return;
      }

      var view = $target.data('view');
      var viewYear = viewDate.getFullYear();
      var viewMonth = viewDate.getMonth();
      var viewDay = viewDate.getDate();

      switch (view) {
        case 'years prev':
        case 'years next':
          {
            viewYear = view === 'years prev' ? viewYear - 10 : viewYear + 10;
            viewDate.setFullYear(viewYear);
            viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
            this.renderYears();
            break;
          }

        case 'year prev':
        case 'year next':
          viewYear = view === 'year prev' ? viewYear - 1 : viewYear + 1;
          viewDate.setFullYear(viewYear);
          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
          this.renderMonths();
          break;

        case 'year current':
          if (format.hasYear) {
            this.showView(VIEWS.YEARS);
          }

          break;

        case 'year picked':
          if (format.hasMonth) {
            this.showView(VIEWS.MONTHS);
          } else {
            $target.siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'year');
            this.hideView();
          }

          this.pick('year');
          break;

        case 'year':
          viewYear = parseInt($target.text(), 10); // Set date first to avoid month changing (#195)

          date.setDate(getMinDay(viewYear, viewMonth, viewDay));
          date.setFullYear(viewYear);
          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
          viewDate.setFullYear(viewYear);

          if (format.hasMonth) {
            this.showView(VIEWS.MONTHS);
          } else {
            $target.addClass(options.pickedClass).data('view', 'year picked').siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'year');
            this.hideView();
          }

          this.pick('year');
          break;

        case 'month prev':
        case 'month next':
          viewMonth = view === 'month prev' ? viewMonth - 1 : viewMonth + 1;

          if (viewMonth < 0) {
            viewYear -= 1;
            viewMonth += 12;
          } else if (viewMonth > 11) {
            viewYear += 1;
            viewMonth -= 12;
          }

          viewDate.setFullYear(viewYear);
          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
          viewDate.setMonth(viewMonth);
          this.renderDays();
          break;

        case 'month current':
          if (format.hasMonth) {
            this.showView(VIEWS.MONTHS);
          }

          break;

        case 'month picked':
          if (format.hasDay) {
            this.showView(VIEWS.DAYS);
          } else {
            $target.siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'month');
            this.hideView();
          }

          this.pick('month');
          break;

        case 'month':
          viewMonth = $.inArray($target.text(), options.monthsShort);
          date.setFullYear(viewYear); // Set date before month to avoid month changing (#195)

          date.setDate(getMinDay(viewYear, viewMonth, viewDay));
          date.setMonth(viewMonth);
          viewDate.setFullYear(viewYear);
          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
          viewDate.setMonth(viewMonth);

          if (format.hasDay) {
            this.showView(VIEWS.DAYS);
          } else {
            $target.addClass(options.pickedClass).data('view', 'month picked').siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'month');
            this.hideView();
          }

          this.pick('month');
          break;

        case 'day prev':
        case 'day next':
        case 'day':
          if (view === 'day prev') {
            viewMonth -= 1;
          } else if (view === 'day next') {
            viewMonth += 1;
          }

          viewDay = parseInt($target.text(), 10); // Set date to 1 to avoid month changing (#195)

          date.setDate(1);
          date.setFullYear(viewYear);
          date.setMonth(viewMonth);
          date.setDate(viewDay);
          viewDate.setDate(1);
          viewDate.setFullYear(viewYear);
          viewDate.setMonth(viewMonth);
          viewDate.setDate(viewDay);
          this.renderDays();

          if (view === 'day') {
            this.hideView();
          }

          this.pick('day');
          break;

        case 'day picked':
          this.hideView();
          this.pick('day');
          break;

        default:
      }
    },
    globalClick: function globalClick(_ref) {
      var target = _ref.target;
      var element = this.element,
          $trigger = this.$trigger;
      var trigger = $trigger[0];
      var hidden = true;

      while (target !== document) {
        if (target === trigger || target === element) {
          hidden = false;
          break;
        }

        target = target.parentNode;
      }

      if (hidden) {
        this.hide();
      }
    },
    keyup: function keyup() {
      this.update();
    },
    globalKeyup: function globalKeyup(_ref2) {
      var target = _ref2.target,
          key = _ref2.key,
          keyCode = _ref2.keyCode;

      if (this.isInput && target !== this.element && this.shown && (key === 'Tab' || keyCode === 9)) {
        this.hide();
      }
    },
    touchstart: function touchstart(_ref3) {
      var target = _ref3.target;

      // Emulate click in touch devices to support hiding the picker automatically (#197).
      if (this.isInput && target !== this.element && !$.contains(this.$picker[0], target)) {
        this.hide();
        this.element.blur();
      }
    }
  };

  var render = {
    render: function render() {
      this.renderYears();
      this.renderMonths();
      this.renderDays();
    },
    renderWeek: function renderWeek() {
      var _this = this;

      var items = [];
      var _this$options = this.options,
          weekStart = _this$options.weekStart,
          daysMin = _this$options.daysMin;
      weekStart = parseInt(weekStart, 10) % 7;
      daysMin = daysMin.slice(weekStart).concat(daysMin.slice(0, weekStart));
      $.each(daysMin, function (i, day) {
        items.push(_this.createItem({
          text: day
        }));
      });
      this.$week.html(items.join(''));
    },
    renderYears: function renderYears() {
      var options = this.options,
          startDate = this.startDate,
          endDate = this.endDate;
      var disabledClass = options.disabledClass,
          filter = options.filter,
          yearSuffix = options.yearSuffix;
      var viewYear = this.viewDate.getFullYear();
      var now = new Date();
      var thisYear = now.getFullYear();
      var year = this.date.getFullYear();
      var start = -5;
      var end = 6;
      var items = [];
      var prevDisabled = false;
      var nextDisabled = false;
      var i;

      for (i = start; i <= end; i += 1) {
        var date = new Date(viewYear + i, 1, 1);
        var disabled = false;

        if (startDate) {
          disabled = date.getFullYear() < startDate.getFullYear();

          if (i === start) {
            prevDisabled = disabled;
          }
        }

        if (!disabled && endDate) {
          disabled = date.getFullYear() > endDate.getFullYear();

          if (i === end) {
            nextDisabled = disabled;
          }
        }

        if (!disabled && filter) {
          disabled = filter.call(this.$element, date, 'year') === false;
        }

        var picked = viewYear + i === year;
        var view = picked ? 'year picked' : 'year';
        items.push(this.createItem({
          picked: picked,
          disabled: disabled,
          text: viewYear + i,
          view: disabled ? 'year disabled' : view,
          highlighted: date.getFullYear() === thisYear
        }));
      }

      this.$yearsPrev.toggleClass(disabledClass, prevDisabled);
      this.$yearsNext.toggleClass(disabledClass, nextDisabled);
      this.$yearsCurrent.toggleClass(disabledClass, true).html("".concat(viewYear + start + yearSuffix, " - ").concat(viewYear + end).concat(yearSuffix));
      this.$years.html(items.join(''));
    },
    renderMonths: function renderMonths() {
      var options = this.options,
          startDate = this.startDate,
          endDate = this.endDate,
          viewDate = this.viewDate;
      var disabledClass = options.disabledClass || '';
      var months = options.monthsShort;
      var filter = $.isFunction(options.filter) && options.filter;
      var viewYear = viewDate.getFullYear();
      var now = new Date();
      var thisYear = now.getFullYear();
      var thisMonth = now.getMonth();
      var year = this.date.getFullYear();
      var month = this.date.getMonth();
      var items = [];
      var prevDisabled = false;
      var nextDisabled = false;
      var i;

      for (i = 0; i <= 11; i += 1) {
        var date = new Date(viewYear, i, 1);
        var disabled = false;

        if (startDate) {
          prevDisabled = date.getFullYear() === startDate.getFullYear();
          disabled = prevDisabled && date.getMonth() < startDate.getMonth();
        }

        if (!disabled && endDate) {
          nextDisabled = date.getFullYear() === endDate.getFullYear();
          disabled = nextDisabled && date.getMonth() > endDate.getMonth();
        }

        if (!disabled && filter) {
          disabled = filter.call(this.$element, date, 'month') === false;
        }

        var picked = viewYear === year && i === month;
        var view = picked ? 'month picked' : 'month';
        items.push(this.createItem({
          disabled: disabled,
          picked: picked,
          highlighted: viewYear === thisYear && date.getMonth() === thisMonth,
          index: i,
          text: months[i],
          view: disabled ? 'month disabled' : view
        }));
      }

      this.$yearPrev.toggleClass(disabledClass, prevDisabled);
      this.$yearNext.toggleClass(disabledClass, nextDisabled);
      this.$yearCurrent.toggleClass(disabledClass, prevDisabled && nextDisabled).html(viewYear + options.yearSuffix || '');
      this.$months.html(items.join(''));
    },
    renderDays: function renderDays() {
      var $element = this.$element,
          options = this.options,
          startDate = this.startDate,
          endDate = this.endDate,
          viewDate = this.viewDate,
          currentDate = this.date;
      var disabledClass = options.disabledClass,
          filter = options.filter,
          months = options.months,
          weekStart = options.weekStart,
          yearSuffix = options.yearSuffix;
      var viewYear = viewDate.getFullYear();
      var viewMonth = viewDate.getMonth();
      var now = new Date();
      var thisYear = now.getFullYear();
      var thisMonth = now.getMonth();
      var thisDay = now.getDate();
      var year = currentDate.getFullYear();
      var month = currentDate.getMonth();
      var day = currentDate.getDate();
      var length;
      var i;
      var n; // Days of prev month
      // -----------------------------------------------------------------------

      var prevItems = [];
      var prevViewYear = viewYear;
      var prevViewMonth = viewMonth;
      var prevDisabled = false;

      if (viewMonth === 0) {
        prevViewYear -= 1;
        prevViewMonth = 11;
      } else {
        prevViewMonth -= 1;
      } // The length of the days of prev month


      length = getDaysInMonth(prevViewYear, prevViewMonth); // The first day of current month

      var firstDay = new Date(viewYear, viewMonth, 1); // The visible length of the days of prev month
      // [0,1,2,3,4,5,6] - [0,1,2,3,4,5,6] => [-6,-5,-4,-3,-2,-1,0,1,2,3,4,5,6]

      n = firstDay.getDay() - parseInt(weekStart, 10) % 7; // [-6,-5,-4,-3,-2,-1,0,1,2,3,4,5,6] => [1,2,3,4,5,6,7]

      if (n <= 0) {
        n += 7;
      }

      if (startDate) {
        prevDisabled = firstDay.getTime() <= startDate.getTime();
      }

      for (i = length - (n - 1); i <= length; i += 1) {
        var prevViewDate = new Date(prevViewYear, prevViewMonth, i);
        var disabled = false;

        if (startDate) {
          disabled = prevViewDate.getTime() < startDate.getTime();
        }

        if (!disabled && filter) {
          disabled = filter.call($element, prevViewDate, 'day') === false;
        }

        prevItems.push(this.createItem({
          disabled: disabled,
          highlighted: prevViewYear === thisYear && prevViewMonth === thisMonth && prevViewDate.getDate() === thisDay,
          muted: true,
          picked: prevViewYear === year && prevViewMonth === month && i === day,
          text: i,
          view: 'day prev'
        }));
      } // Days of next month
      // -----------------------------------------------------------------------


      var nextItems = [];
      var nextViewYear = viewYear;
      var nextViewMonth = viewMonth;
      var nextDisabled = false;

      if (viewMonth === 11) {
        nextViewYear += 1;
        nextViewMonth = 0;
      } else {
        nextViewMonth += 1;
      } // The length of the days of current month


      length = getDaysInMonth(viewYear, viewMonth); // The visible length of next month (42 means 6 rows and 7 columns)

      n = 42 - (prevItems.length + length); // The last day of current month

      var lastDate = new Date(viewYear, viewMonth, length);

      if (endDate) {
        nextDisabled = lastDate.getTime() >= endDate.getTime();
      }

      for (i = 1; i <= n; i += 1) {
        var date = new Date(nextViewYear, nextViewMonth, i);
        var picked = nextViewYear === year && nextViewMonth === month && i === day;
        var _disabled = false;

        if (endDate) {
          _disabled = date.getTime() > endDate.getTime();
        }

        if (!_disabled && filter) {
          _disabled = filter.call($element, date, 'day') === false;
        }

        nextItems.push(this.createItem({
          disabled: _disabled,
          picked: picked,
          highlighted: nextViewYear === thisYear && nextViewMonth === thisMonth && date.getDate() === thisDay,
          muted: true,
          text: i,
          view: 'day next'
        }));
      } // Days of current month
      // -----------------------------------------------------------------------


      var items = [];

      for (i = 1; i <= length; i += 1) {
        var _date = new Date(viewYear, viewMonth, i);

        var _disabled2 = false;

        if (startDate) {
          _disabled2 = _date.getTime() < startDate.getTime();
        }

        if (!_disabled2 && endDate) {
          _disabled2 = _date.getTime() > endDate.getTime();
        }

        if (!_disabled2 && filter) {
          _disabled2 = filter.call($element, _date, 'day') === false;
        }

        var _picked = viewYear === year && viewMonth === month && i === day;

        var view = _picked ? 'day picked' : 'day';
        items.push(this.createItem({
          disabled: _disabled2,
          picked: _picked,
          highlighted: viewYear === thisYear && viewMonth === thisMonth && _date.getDate() === thisDay,
          text: i,
          view: _disabled2 ? 'day disabled' : view
        }));
      } // Render days picker
      // -----------------------------------------------------------------------


      this.$monthPrev.toggleClass(disabledClass, prevDisabled);
      this.$monthNext.toggleClass(disabledClass, nextDisabled);
      this.$monthCurrent.toggleClass(disabledClass, prevDisabled && nextDisabled).html(options.yearFirst ? "".concat(viewYear + yearSuffix, " ").concat(months[viewMonth]) : "".concat(months[viewMonth], " ").concat(viewYear).concat(yearSuffix));
      this.$days.html(prevItems.join('') + items.join('') + nextItems.join(''));
    }
  };

  var CLASS_TOP_LEFT = "".concat(NAMESPACE, "-top-left");
  var CLASS_TOP_RIGHT = "".concat(NAMESPACE, "-top-right");
  var CLASS_BOTTOM_LEFT = "".concat(NAMESPACE, "-bottom-left");
  var CLASS_BOTTOM_RIGHT = "".concat(NAMESPACE, "-bottom-right");
  var CLASS_PLACEMENTS = [CLASS_TOP_LEFT, CLASS_TOP_RIGHT, CLASS_BOTTOM_LEFT, CLASS_BOTTOM_RIGHT].join(' ');

  var Datepicker =
  /*#__PURE__*/
  function () {
    function Datepicker(element) {
      var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

      _classCallCheck(this, Datepicker);

      this.$element = $(element);
      this.element = element;
      this.options = $.extend({}, DEFAULTS, LANGUAGES[options.language], $.isPlainObject(options) && options);
      this.$scrollParent = getScrollParent(element, true);
      this.built = false;
      this.shown = false;
      this.isInput = false;
      this.inline = false;
      this.initialValue = '';
      this.initialDate = null;
      this.startDate = null;
      this.endDate = null;
      this.init();
    }

    _createClass(Datepicker, [{
      key: "init",
      value: function init() {
        var $this = this.$element,
            options = this.options;
        var startDate = options.startDate,
            endDate = options.endDate,
            date = options.date;
        this.$trigger = $(options.trigger);
        this.isInput = $this.is('input') || $this.is('textarea');
        this.inline = options.inline && (options.container || !this.isInput);
        this.format = parseFormat(options.format);
        var initialValue = this.getValue();
        this.initialValue = initialValue;
        this.oldValue = initialValue;
        date = this.parseDate(date || initialValue);

        if (startDate) {
          startDate = this.parseDate(startDate);

          if (date.getTime() < startDate.getTime()) {
            date = new Date(startDate);
          }

          this.startDate = startDate;
        }

        if (endDate) {
          endDate = this.parseDate(endDate);

          if (startDate && endDate.getTime() < startDate.getTime()) {
            endDate = new Date(startDate);
          }

          if (date.getTime() > endDate.getTime()) {
            date = new Date(endDate);
          }

          this.endDate = endDate;
        }

        this.date = date;
        this.viewDate = new Date(date);
        this.initialDate = new Date(this.date);
        this.bind();

        if (options.autoShow || this.inline) {
          this.show();
        }

        if (options.autoPick) {
          this.pick();
        }
      }
    }, {
      key: "build",
      value: function build() {
        if (this.built) {
          return;
        }

        this.built = true;
        var $this = this.$element,
            options = this.options;
        var $picker = $(options.template);
        this.$picker = $picker;
        this.$week = $picker.find(selectorOf('week')); // Years view

        this.$yearsPicker = $picker.find(selectorOf('years picker'));
        this.$yearsPrev = $picker.find(selectorOf('years prev'));
        this.$yearsNext = $picker.find(selectorOf('years next'));
        this.$yearsCurrent = $picker.find(selectorOf('years current'));
        this.$years = $picker.find(selectorOf('years')); // Months view

        this.$monthsPicker = $picker.find(selectorOf('months picker'));
        this.$yearPrev = $picker.find(selectorOf('year prev'));
        this.$yearNext = $picker.find(selectorOf('year next'));
        this.$yearCurrent = $picker.find(selectorOf('year current'));
        this.$months = $picker.find(selectorOf('months')); // Days view

        this.$daysPicker = $picker.find(selectorOf('days picker'));
        this.$monthPrev = $picker.find(selectorOf('month prev'));
        this.$monthNext = $picker.find(selectorOf('month next'));
        this.$monthCurrent = $picker.find(selectorOf('month current'));
        this.$days = $picker.find(selectorOf('days'));

        if (this.inline) {
          $(options.container || $this).append($picker.addClass("".concat(NAMESPACE, "-inline")));
        } else {
          $(document.body).append($picker.addClass("".concat(NAMESPACE, "-dropdown")));
          $picker.addClass(CLASS_HIDE).css({
            zIndex: parseInt(options.zIndex, 10)
          });
        }

        this.renderWeek();
      }
    }, {
      key: "unbuild",
      value: function unbuild() {
        if (!this.built) {
          return;
        }

        this.built = false;
        this.$picker.remove();
      }
    }, {
      key: "bind",
      value: function bind() {
        var options = this.options,
            $this = this.$element;

        if ($.isFunction(options.show)) {
          $this.on(EVENT_SHOW, options.show);
        }

        if ($.isFunction(options.hide)) {
          $this.on(EVENT_HIDE, options.hide);
        }

        if ($.isFunction(options.pick)) {
          $this.on(EVENT_PICK, options.pick);
        }

        if (this.isInput) {
          $this.on(EVENT_KEYUP, $.proxy(this.keyup, this));
        }

        if (!this.inline) {
          if (options.trigger) {
            this.$trigger.on(EVENT_CLICK, $.proxy(this.toggle, this));
          } else if (this.isInput) {
            $this.on(EVENT_FOCUS, $.proxy(this.show, this));
          } else {
            $this.on(EVENT_CLICK, $.proxy(this.show, this));
          }
        }
      }
    }, {
      key: "unbind",
      value: function unbind() {
        var $this = this.$element,
            options = this.options;

        if ($.isFunction(options.show)) {
          $this.off(EVENT_SHOW, options.show);
        }

        if ($.isFunction(options.hide)) {
          $this.off(EVENT_HIDE, options.hide);
        }

        if ($.isFunction(options.pick)) {
          $this.off(EVENT_PICK, options.pick);
        }

        if (this.isInput) {
          $this.off(EVENT_KEYUP, this.keyup);
        }

        if (!this.inline) {
          if (options.trigger) {
            this.$trigger.off(EVENT_CLICK, this.toggle);
          } else if (this.isInput) {
            $this.off(EVENT_FOCUS, this.show);
          } else {
            $this.off(EVENT_CLICK, this.show);
          }
        }
      }
    }, {
      key: "showView",
      value: function showView(view) {
        var $yearsPicker = this.$yearsPicker,
            $monthsPicker = this.$monthsPicker,
            $daysPicker = this.$daysPicker,
            format = this.format;

        if (format.hasYear || format.hasMonth || format.hasDay) {
          switch (Number(view)) {
            case VIEWS.YEARS:
              $monthsPicker.addClass(CLASS_HIDE);
              $daysPicker.addClass(CLASS_HIDE);

              if (format.hasYear) {
                this.renderYears();
                $yearsPicker.removeClass(CLASS_HIDE);
                this.place();
              } else {
                this.showView(VIEWS.DAYS);
              }

              break;

            case VIEWS.MONTHS:
              $yearsPicker.addClass(CLASS_HIDE);
              $daysPicker.addClass(CLASS_HIDE);

              if (format.hasMonth) {
                this.renderMonths();
                $monthsPicker.removeClass(CLASS_HIDE);
                this.place();
              } else {
                this.showView(VIEWS.YEARS);
              }

              break;
            // case VIEWS.DAYS:

            default:
              $yearsPicker.addClass(CLASS_HIDE);
              $monthsPicker.addClass(CLASS_HIDE);

              if (format.hasDay) {
                this.renderDays();
                $daysPicker.removeClass(CLASS_HIDE);
                this.place();
              } else {
                this.showView(VIEWS.MONTHS);
              }

          }
        }
      }
    }, {
      key: "hideView",
      value: function hideView() {
        if (!this.inline && this.options.autoHide) {
          this.hide();
        }
      }
    }, {
      key: "place",
      value: function place() {
        if (this.inline) {
          return;
        }

        var $this = this.$element,
            options = this.options,
            $picker = this.$picker;
        var containerWidth = $(document).outerWidth();
        var containerHeight = $(document).outerHeight();
        var elementWidth = $this.outerWidth();
        var elementHeight = $this.outerHeight();
        var width = $picker.width();
        var height = $picker.height();

        var _$this$offset = $this.offset(),
            left = _$this$offset.left,
            top = _$this$offset.top;

        var offset = parseFloat(options.offset);
        var placement = CLASS_TOP_LEFT;

        if (isNaN(offset)) {
          offset = 10;
        }

        if (top > height && top + elementHeight + height > containerHeight) {
          top -= height + offset;
          placement = CLASS_BOTTOM_LEFT;
        } else {
          top += elementHeight + offset;
        }

        if (left + width > containerWidth) {
          left += elementWidth - width;
          placement = placement.replace('left', 'right');
        }

        $picker.removeClass(CLASS_PLACEMENTS).addClass(placement).css({
          top: top,
          left: left
        });
      } // A shortcut for triggering custom events

    }, {
      key: "trigger",
      value: function trigger(type, data) {
        var e = $.Event(type, data);
        this.$element.trigger(e);
        return e;
      }
    }, {
      key: "createItem",
      value: function createItem(data) {
        var options = this.options;
        var itemTag = options.itemTag;
        var item = {
          text: '',
          view: '',
          muted: false,
          picked: false,
          disabled: false,
          highlighted: false
        };
        var classes = [];
        $.extend(item, data);

        if (item.muted) {
          classes.push(options.mutedClass);
        }

        if (item.highlighted) {
          classes.push(options.highlightedClass);
        }

        if (item.picked) {
          classes.push(options.pickedClass);
        }

        if (item.disabled) {
          classes.push(options.disabledClass);
        }

        return "<".concat(itemTag, " class=\"").concat(classes.join(' '), "\" data-view=\"").concat(item.view, "\">").concat(item.text, "</").concat(itemTag, ">");
      }
    }, {
      key: "getValue",
      value: function getValue() {
        var $this = this.$element;
        return this.isInput ? $this.val() : $this.text();
      }
    }, {
      key: "setValue",
      value: function setValue() {
        var value = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
        var $this = this.$element;

        if (this.isInput) {
          $this.val(value);
        } else if (!this.inline || this.options.container) {
          $this.text(value);
        }
      }
    }], [{
      key: "setDefaults",
      value: function setDefaults() {
        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
        $.extend(DEFAULTS, LANGUAGES[options.language], $.isPlainObject(options) && options);
      }
    }]);

    return Datepicker;
  }();

  if ($.extend) {
    $.extend(Datepicker.prototype, render, handlers, methods);
  }

  if ($.fn) {
    var AnotherDatepicker = $.fn.datepicker;

    $.fn.datepicker = function jQueryDatepicker(option) {
      for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
        args[_key - 1] = arguments[_key];
      }

      var result;
      this.each(function (i, element) {
        var $element = $(element);
        var isDestroy = option === 'destroy';
        var datepicker = $element.data(NAMESPACE);

        if (!datepicker) {
          if (isDestroy) {
            return;
          }

          var options = $.extend({}, $element.data(), $.isPlainObject(option) && option);
          datepicker = new Datepicker(element, options);
          $element.data(NAMESPACE, datepicker);
        }

        if (isString(option)) {
          var fn = datepicker[option];

          if ($.isFunction(fn)) {
            result = fn.apply(datepicker, args);

            if (isDestroy) {
              $element.removeData(NAMESPACE);
            }
          }
        }
      });
      return !isUndefined(result) ? result : this;
    };

    $.fn.datepicker.Constructor = Datepicker;
    $.fn.datepicker.languages = LANGUAGES;
    $.fn.datepicker.setDefaults = Datepicker.setDefaults;

    $.fn.datepicker.noConflict = function noConflict() {
      $.fn.datepicker = AnotherDatepicker;
      return this;
    };
  }

}));


/***/ }),

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),

/***/ "./node_modules/setimmediate/setImmediate.js":
/*!***************************************************!*\
  !*** ./node_modules/setimmediate/setImmediate.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global, process) {(function (global, undefined) {
    "use strict";

    if (global.setImmediate) {
        return;
    }

    var nextHandle = 1; // Spec says greater than zero
    var tasksByHandle = {};
    var currentlyRunningATask = false;
    var doc = global.document;
    var registerImmediate;

    function setImmediate(callback) {
      // Callback can either be a function or a string
      if (typeof callback !== "function") {
        callback = new Function("" + callback);
      }
      // Copy function arguments
      var args = new Array(arguments.length - 1);
      for (var i = 0; i < args.length; i++) {
          args[i] = arguments[i + 1];
      }
      // Store and register the task
      var task = { callback: callback, args: args };
      tasksByHandle[nextHandle] = task;
      registerImmediate(nextHandle);
      return nextHandle++;
    }

    function clearImmediate(handle) {
        delete tasksByHandle[handle];
    }

    function run(task) {
        var callback = task.callback;
        var args = task.args;
        switch (args.length) {
        case 0:
            callback();
            break;
        case 1:
            callback(args[0]);
            break;
        case 2:
            callback(args[0], args[1]);
            break;
        case 3:
            callback(args[0], args[1], args[2]);
            break;
        default:
            callback.apply(undefined, args);
            break;
        }
    }

    function runIfPresent(handle) {
        // From the spec: "Wait until any invocations of this algorithm started before this one have completed."
        // So if we're currently running a task, we'll need to delay this invocation.
        if (currentlyRunningATask) {
            // Delay by doing a setTimeout. setImmediate was tried instead, but in Firefox 7 it generated a
            // "too much recursion" error.
            setTimeout(runIfPresent, 0, handle);
        } else {
            var task = tasksByHandle[handle];
            if (task) {
                currentlyRunningATask = true;
                try {
                    run(task);
                } finally {
                    clearImmediate(handle);
                    currentlyRunningATask = false;
                }
            }
        }
    }

    function installNextTickImplementation() {
        registerImmediate = function(handle) {
            process.nextTick(function () { runIfPresent(handle); });
        };
    }

    function canUsePostMessage() {
        // The test against `importScripts` prevents this implementation from being installed inside a web worker,
        // where `global.postMessage` means something completely different and can't be used for this purpose.
        if (global.postMessage && !global.importScripts) {
            var postMessageIsAsynchronous = true;
            var oldOnMessage = global.onmessage;
            global.onmessage = function() {
                postMessageIsAsynchronous = false;
            };
            global.postMessage("", "*");
            global.onmessage = oldOnMessage;
            return postMessageIsAsynchronous;
        }
    }

    function installPostMessageImplementation() {
        // Installs an event handler on `global` for the `message` event: see
        // * https://developer.mozilla.org/en/DOM/window.postMessage
        // * http://www.whatwg.org/specs/web-apps/current-work/multipage/comms.html#crossDocumentMessages

        var messagePrefix = "setImmediate$" + Math.random() + "$";
        var onGlobalMessage = function(event) {
            if (event.source === global &&
                typeof event.data === "string" &&
                event.data.indexOf(messagePrefix) === 0) {
                runIfPresent(+event.data.slice(messagePrefix.length));
            }
        };

        if (global.addEventListener) {
            global.addEventListener("message", onGlobalMessage, false);
        } else {
            global.attachEvent("onmessage", onGlobalMessage);
        }

        registerImmediate = function(handle) {
            global.postMessage(messagePrefix + handle, "*");
        };
    }

    function installMessageChannelImplementation() {
        var channel = new MessageChannel();
        channel.port1.onmessage = function(event) {
            var handle = event.data;
            runIfPresent(handle);
        };

        registerImmediate = function(handle) {
            channel.port2.postMessage(handle);
        };
    }

    function installReadyStateChangeImplementation() {
        var html = doc.documentElement;
        registerImmediate = function(handle) {
            // Create a <script> element; its readystatechange event will be fired asynchronously once it is inserted
            // into the document. Do so, thus queuing up the task. Remember to clean up once it's been called.
            var script = doc.createElement("script");
            script.onreadystatechange = function () {
                runIfPresent(handle);
                script.onreadystatechange = null;
                html.removeChild(script);
                script = null;
            };
            html.appendChild(script);
        };
    }

    function installSetTimeoutImplementation() {
        registerImmediate = function(handle) {
            setTimeout(runIfPresent, 0, handle);
        };
    }

    // If supported, we should attach to the prototype of global, since that is where setTimeout et al. live.
    var attachTo = Object.getPrototypeOf && Object.getPrototypeOf(global);
    attachTo = attachTo && attachTo.setTimeout ? attachTo : global;

    // Don't get fooled by e.g. browserify environments.
    if ({}.toString.call(global.process) === "[object process]") {
        // For Node.js before 0.9
        installNextTickImplementation();

    } else if (canUsePostMessage()) {
        // For non-IE10 modern browsers
        installPostMessageImplementation();

    } else if (global.MessageChannel) {
        // For web workers, where supported
        installMessageChannelImplementation();

    } else if (doc && "onreadystatechange" in doc.createElement("script")) {
        // For IE 6–8
        installReadyStateChangeImplementation();

    } else {
        // For older browsers
        installSetTimeoutImplementation();
    }

    attachTo.setImmediate = setImmediate;
    attachTo.clearImmediate = clearImmediate;
}(typeof self === "undefined" ? typeof global === "undefined" ? this : global : self));

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js"), __webpack_require__(/*! ./../process/browser.js */ "./node_modules/process/browser.js")))

/***/ }),

/***/ "./node_modules/timers-browserify/main.js":
/*!************************************************!*\
  !*** ./node_modules/timers-browserify/main.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var scope = (typeof global !== "undefined" && global) ||
            (typeof self !== "undefined" && self) ||
            window;
var apply = Function.prototype.apply;

// DOM APIs, for completeness

exports.setTimeout = function() {
  return new Timeout(apply.call(setTimeout, scope, arguments), clearTimeout);
};
exports.setInterval = function() {
  return new Timeout(apply.call(setInterval, scope, arguments), clearInterval);
};
exports.clearTimeout =
exports.clearInterval = function(timeout) {
  if (timeout) {
    timeout.close();
  }
};

function Timeout(id, clearFn) {
  this._id = id;
  this._clearFn = clearFn;
}
Timeout.prototype.unref = Timeout.prototype.ref = function() {};
Timeout.prototype.close = function() {
  this._clearFn.call(scope, this._id);
};

// Does not start the time, just sets up the members needed.
exports.enroll = function(item, msecs) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = msecs;
};

exports.unenroll = function(item) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = -1;
};

exports._unrefActive = exports.active = function(item) {
  clearTimeout(item._idleTimeoutId);

  var msecs = item._idleTimeout;
  if (msecs >= 0) {
    item._idleTimeoutId = setTimeout(function onTimeout() {
      if (item._onTimeout)
        item._onTimeout();
    }, msecs);
  }
};

// setimmediate attaches itself to the global object
__webpack_require__(/*! setimmediate */ "./node_modules/setimmediate/setImmediate.js");
// On some exotic environments, it's not clear which object `setimmediate` was
// able to install onto.  Search each possibility in the same order as the
// `setimmediate` library.
exports.setImmediate = (typeof self !== "undefined" && self.setImmediate) ||
                       (typeof global !== "undefined" && global.setImmediate) ||
                       (this && this.setImmediate);
exports.clearImmediate = (typeof self !== "undefined" && self.clearImmediate) ||
                         (typeof global !== "undefined" && global.clearImmediate) ||
                         (this && this.clearImmediate);

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./node_modules/webpack/buildin/amd-define.js":
/*!***************************************!*\
  !*** (webpack)/buildin/amd-define.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function() {
	throw new Error("define cannot be used indirect");
};


/***/ }),

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || new Function("return this")();
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),

/***/ "./resources/scripts/main.js":
/*!***********************************!*\
  !*** ./resources/scripts/main.js ***!
  \***********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _vendor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./vendor */ "./resources/scripts/vendor.js");
/* harmony import */ var _scripts__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scripts */ "./resources/scripts/scripts.js");
/* harmony import */ var _scripts__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_scripts__WEBPACK_IMPORTED_MODULE_1__);
/**
 * Import third party modules
 */

/**
 * Configure jQuery AJAX to send CSRF Token in every request
 */

var token = $('meta[name="csrf-token"]').attr('content');
if (token) $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': token
  }
});else console.error('CSRF token not found');
/**
 * Import custom scripts
 */



/***/ }),

/***/ "./resources/scripts/scripts.js":
/*!**************************************!*\
  !*** ./resources/scripts/scripts.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

// Configurar toastr
toastr.options.showMethod = 'slideDown';
toastr.options.hideEasing = 'swing';
toastr.options.timeOut = 10000; // Function to escape HTML

function escapeHTML(string) {
  if (string == undefined || string == null) return '';

  if (_typeof(string) === 'object') {
    var obj = Object.assign({}, string);

    for (var o in obj) {
      obj[o] = escapeHTML(obj[o]);
    }

    return obj;
  }

  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return String(string).replace(/[&<>"']/g, function (m) {
    return map[m];
  });
} // Colocar máscara nos formulários


var phoneMask = function phoneMask(value) {
  return value.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
};

var phoneConfig = {
  onKeyPress: function onKeyPress(value, event, field, options) {
    field.mask(phoneMask.apply({}, arguments), options);
  }
};
$('[name="first_name"]').mask('S'.repeat(30), {
  translation: {
    S: {
      pattern: /[A-Za-zÀ-ÖØ-öø-ÿ ]/
    }
  }
});
$('[name="last_name"]').mask('S'.repeat(150), {
  translation: {
    S: {
      pattern: /[A-Za-zÀ-ÖØ-öø-ÿ ]/
    }
  }
});
$('[name="cpf"]').mask('000.000.000-00', {
  reverse: true
});
$('[name="date_birth"]').mask('00/00/0000');
$('[name="email"]').mask('S'.repeat(255), {
  translation: {
    S: {
      pattern: /[\w\.@]/
    }
  }
});
$('[name="phone"]').mask(phoneMask, phoneConfig);
$('[name="zip_code"]').mask('00000-000');
$('[name="street"]').mask('S'.repeat(255), {
  translation: {
    S: {
      pattern: /[A-Za-zÀ-ÖØ-öø-ÿ\.\,\d ]/
    }
  }
});
$('[name="number"]').mask('999990', {
  reverse: true
});
$('[name="complement"]').mask('S'.repeat(30), {
  translation: {
    S: {
      pattern: /[A-Za-zÀ-ÖØ-öø-ÿ\.\,\d ]/
    }
  }
});
$('[name="city"]').mask('S'.repeat(80), {
  translation: {
    S: {
      pattern: /[A-Za-zÀ-ÖØ-öø-ÿ ]/
    }
  }
});
$('[name="weight"]').mask('999990', {
  reverse: true
});
$('[name="utc_code"]').mask('0000.0000.0000', {
  reverse: true
});
$('[name="ean_code"]').mask('0.000.000.000.000', {
  reverse: true
}); // Configurar DatePicker para campo de data

$('[name="date_birth"]').datepicker({
  format: 'dd/mm/yyyy',
  days: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
  daysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
  daysMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
  months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
  monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
  startView: 2,
  autoHide: true,
  zIndex: 2048
}); // Adicionar recurso de consulta de CEP

$('#find-zip_code').click(function () {
  var zipFormat = /([0-9]{5})-([0-9]{3})/;
  var zip = $('[name="zip_code"]').val();

  if (zip && zipFormat.test(zip)) {
    zip = zip.replace(zipFormat, '$1$2');
    $('[name="zip_code"]').prop('disabled', true);
    $('[name="street"]').val('');
    $('[name="number"]').val('');
    $('[name="complement"]').val('');
    $('[name="city"]').val('');
    $('[name="state"]').val('');
    $.ajax({
      method: 'GET',
      url: "https://viacep.com.br/ws/".concat(zip, "/json"),
      success: function success(response) {
        $('[name="street"]').val(response.logradouro);
        $('[name="city"]').val(response.localidade);
        $('select[name="state"] option').filter(function (index, el) {
          return el.text.substring(0, 2) === response.uf;
        }).prop('selected', true);
        $('[name="number"]').focus();
      },
      complete: function complete() {
        $('[name="zip_code"]').prop('disabled', false);
      }
    });
  }
}); // Função para extração dos dados do formulario

function extractDataForm(formSelector) {
  var data = {};
  $("".concat(formSelector, " [name]")).each(function (i, el) {
    return data[el.name] = el.value;
  });
  return data;
} // Limpar formulário


function cleanForm(formSelector) {
  $("".concat(formSelector, " [name]")).each(function (i, el) {
    var type = $(el).attr('type');
    if (type == 'radio' || type == 'checkbox') $(el).prop('checked', false);else $(el).val('');
  });
} // Função para colocar as credenciasi de acesso no formulário


function getRole(role) {
  $('#signin-login').val("".concat(role, "@email.com"));
  $('#signin-password').val('abcd1234');
  $('#access-modal').modal('hide');
} // VErificar se formulário de signin está preenchido


$('#form-signin').submit(function (e) {
  var email = $("#form-signin [name=\"email\"]").val();
  var pswd = $("#form-signin [name=\"password\"]").val();

  if (!email || !pswd) {
    e.preventDefault();
    e.target.classList.add('was-validated');
  }
}); // Enviar dados de signup via AJAX

$('#form-signup').submit(function (e) {
  e.preventDefault();
  $('#form-signup .is-invalid').removeClass('is-invalid');
  $('#form-signup [type="submit"]').prop('disabled', true);
  var userData = extractDataForm('#form-signup');
  userData.terms = !!$('[name="terms"]').prop('checked');
  $.ajax({
    method: 'POST',
    url: e.target.action,
    data: userData,
    success: function success() {
      var baseUrl = window.location.href.split('/');
      baseUrl[4] = 'cliente';
      window.location.href = baseUrl.join('/');
    },
    error: function error(_ref) {
      var responseJSON = _ref.responseJSON;
      console.error('Fail to register: review validation messages and try again');
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = responseJSON[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var err = _step.value;
          $("#invalid-".concat(err.field)).text(err.message);
          $("[name=\"".concat(err.field, "\"]")).addClass('is-invalid');
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator["return"] != null) {
            _iterator["return"]();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }
    },
    complete: function complete() {
      $('#form-signup [type="submit"]').removeAttr('disabled');
    }
  });
}); // Adicionar evento para checkbox

$('input[type="checkbox"]').on('change', function () {//$(this).prop('checked', !$(this).prop('checked'))
}); // Contador de caracteres

function charCounter(e, selector, max) {
  var count = e.target.value.length;
  $(selector).text("Caracteres digitados: ".concat(count, "/").concat(max));
  $('#message-sender').prop('disabled', count === 0);
} // Constantes do módulo de categorias


var CATEGORY_TABLE = '#category-table';
var CATEGORY_FORM = '#category-form';
var CATEGORY_MODAL = '#category-modal'; // Excluir categoria

function deleteCategory(id, e) {
  if (confirm("Tem certeza de que deseja excluir a categoria #".concat(id, "?"))) {
    var idStr = String(id).padStart(3, '0');
    $.ajax({
      method: 'POST',
      url: "".concat($(CATEGORY_FORM).attr('action'), "?action=delete"),
      data: {
        id: id
      },
      success: function success(response) {
        toastr.success(response.message);
        $(e.target).closest('tr').remove();
      },
      error: function error(_error) {
        var status = _error.status,
            responseJSON = _error.responseJSON;

        if (status == 422) {
          toastr.error(responseJSON.message);
        } else {
          console.error(_error);
        }
      }
    });
  }
} // Abrir modal/form para criação de categoria


function createCategory() {
  $("".concat(CATEGORY_FORM, "-title")).text('Nova Categoria');
  $(CATEGORY_MODAL).modal('show');
  cleanForm(CATEGORY_FORM);
  $('#category-name').focus();
} // Abrir modal/form para edição de categoria


function editCategory(id) {
  var idStr = String(id).padStart(3, '0');
  cleanForm(CATEGORY_FORM);
  $("".concat(CATEGORY_FORM, "-title")).text("Editando Categoria #".concat(idStr));
  $(CATEGORY_MODAL).modal('show');
  $.ajax({
    method: 'GET',
    url: "".concat($(CATEGORY_FORM).attr('action'), "?id=").concat(id),
    success: function success(response) {
      var category = escapeHTML(response);
      $("".concat(CATEGORY_FORM, " [name=\"id\"]")).val(category.id);
      $("".concat(CATEGORY_FORM, " [name=\"name\"]")).val(category.name).focus();
    },
    error: function error(_error2) {
      console.error(_error2);
      $(CATEGORY_MODAL).modal('hide');
      toastr.error("Falha ao tentar recuperar os dados da categoria #".concat(idStr));
    }
  });
} // Montar linha da tabela de categoria


function categoryRow() {
  var category = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var escapedId = escapeHTML(category.id);
  return "\n    <tr>\n      <th scope=\"row\" class=\"text-center\">".concat(escapedId.padStart(3, '0'), "</th>\n      <td>").concat(escapeHTML(category.name), "</td>\n      <td class=\"text-right\">\n        <button type=\"button\" class=\"btn btn-sm btn-info\" title=\"Editar\" onclick=\"editCategory(").concat(escapedId, ")\"><i class=\"fas fa-edit\"></i></button>\n        <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Excluir\" onclick=\"deleteCategory(").concat(escapedId, ", event)\"><i class=\"fas fa-trash-alt\"></i></button>\n      </td>\n    </tr>\n  ");
} // Configurar evento de submissão de formulário de categoria


$(CATEGORY_FORM).submit(function (e) {
  e.preventDefault();
  var category = extractDataForm(CATEGORY_FORM);
  $.ajax({
    method: 'POST',
    url: "".concat($(CATEGORY_FORM).attr('action'), "?action=").concat(!category.id ? 'new' : 'update'),
    data: category,
    success: function success(response) {
      if (!category.id) {
        toastr.success('Categoria criada com sucesso');
        $("".concat(CATEGORY_TABLE, " tbody")).append(categoryRow(response));
      } else {
        toastr.success('Categoria atualizada com sucesso');
        $("".concat(CATEGORY_TABLE, " tbody tr")).filter(function (i, el) {
          return Number($(el).children().first().text()) == category.id;
        }).replaceWith(categoryRow(response));
      }

      $(CATEGORY_MODAL).modal('hide');
    },
    error: function error(_error3) {
      var status = _error3.status,
          responseJSON = _error3.responseJSON;

      if (status == 422) {
        responseJSON.forEach(function (err) {
          return toastr.error(err.message);
        });
      } else {
        console.error(_error3);
      }
    }
  });
}); // Constantes do módulo de produtos

var PRODUCT_TABLE = '#product-table';
var PRODUCT_FORM = '#product-form';
var PRODUCT_MODAL = '#product-modal'; // Excluir produto

function deleteProduct(id, e) {
  if (confirm("Tem certeza de que deseja excluir o produto #".concat(id, "?"))) {
    $.ajax({
      method: 'POST',
      url: "".concat($(PRODUCT_FORM).attr('action'), "?action=delete"),
      data: {
        id: id
      },
      success: function success(response) {
        toastr.success(response.message);
        $(e.target).closest('tr').remove();
      },
      error: function error(_error4) {
        var status = _error4.status,
            responseJSON = _error4.responseJSON;

        if (status == 422) {
          toastr.error(responseJSON.message);
        } else {
          console.error(_error4);
        }
      }
    });
  }
} // Abrir modal/form para criação de produto


function createProduct() {
  $("".concat(PRODUCT_FORM, "-title")).text('Novo Produto');
  $(PRODUCT_MODAL).modal('show');
  cleanForm(PRODUCT_FORM);
  $('#product-name').focus();
} // Abrir modal/form para edição de produto


function editProduct(id) {
  var idStr = String(id).padStart(6, '0');
  cleanForm(PRODUCT_FORM);
  $("".concat(PRODUCT_FORM, "-title")).text("Editando Produto #".concat(idStr));
  $(PRODUCT_MODAL).modal('show');
  $.ajax({
    method: 'GET',
    url: "".concat($(PRODUCT_FORM).attr('action'), "?id=").concat(id),
    success: function success(response) {
      var product = escapeHTML(response);
      $("".concat(PRODUCT_FORM, " [name=\"id\"]")).val(product.id);
      $("".concat(PRODUCT_FORM, " [name=\"name\"]")).val(product.name).focus();
      $("".concat(PRODUCT_FORM, " [name=\"weight\"]")).val(product.weight);
      $("".concat(PRODUCT_FORM, " [name=\"category\"]")).val(product.category.id);
      $("".concat(PRODUCT_FORM, " [name=\"utc_code\"]")).val(product.utc);
      $("".concat(PRODUCT_FORM, " [name=\"ean_code\"]")).val(product.ean);
      $("".concat(PRODUCT_FORM, " [name=\"description\"]")).val(product.description);
    },
    error: function error(_error5) {
      console.error(_error5);
      $(PRODUCT_MODAL).modal('hide');
      toastr.error("Falha ao tentar recuperar os dados do produto #".concat(idStr));
    }
  });
} // Montar linha da tabela de produtos


function productRow() {
  var product = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var escapedId = escapeHTML(product.id);
  var escapedWeight = String(Number(escapeHTML(product.weight)).toFixed(1)).replace('.', ',');
  var escapedUtc = escapeHTML(product.utc).replace(/(\d{4})(\d{4})(\d{4})/, '$1.$2.$3');
  return "\n    <tr>\n      <th scope=\"row\" class=\"text-center\">".concat(escapedId.padStart(6, '0'), "</th>\n      <td class=\"text-left\">").concat(escapeHTML(product.name), "</td>\n      <td class=\"text-right\">").concat(escapedWeight, "g</td>\n      <td class=\"text-center\">").concat(escapeHTML(product.category.name), "</td>\n      <td class=\"text-center\">").concat(escapedUtc, "</td>\n      <td class=\"text-right\">\n        <button type=\"button\" class=\"btn btn-sm btn-info\" title=\"Editar\" onclick=\"editProduct(").concat(escapedId, ")\"><i class=\"fas fa-edit\"></i></button>\n        <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Excluir\" onclick=\"deleteProduct(").concat(escapedId, ", event)\"><i class=\"fas fa-trash-alt\"></i></button>\n      </td>\n    </tr>\n  ");
} // Configurar evento de submissão de formulário de produto


$(PRODUCT_FORM).submit(function (e) {
  e.preventDefault();
  var product = extractDataForm(PRODUCT_FORM);
  $.ajax({
    method: 'POST',
    url: "".concat($(PRODUCT_FORM).attr('action'), "?action=").concat(!product.id ? 'new' : 'update'),
    data: product,
    success: function success(response) {
      if (!product.id) {
        toastr.success('Produto criado com sucesso');
        $("".concat(PRODUCT_TABLE, " tbody")).append(productRow(response));
      } else {
        toastr.success('Produto atualizado com sucesso');
        $("".concat(PRODUCT_TABLE, " tbody tr")).filter(function (i, el) {
          return Number($(el).children().first().text()) == product.id;
        }).replaceWith(productRow(response));
      }

      $(PRODUCT_MODAL).modal('hide');
    },
    error: function error(_error6) {
      var status = _error6.status,
          responseJSON = _error6.responseJSON;

      if (status == 422) {
        responseJSON.forEach(function (err) {
          return toastr.error(err.message);
        });
      } else {
        console.error(_error6);
      }
    }
  });
}); // Constantes do módulo de usuários

var USER_TABLE = '#user-table';
var USER_MODAL = '#user-modal';
var USER_FORM = '#user-form';
var PSWD_MODAL = '#password-modal';
var PSWD_FORM = '#password-form'; // Formatar dados de usuário

function formatUserData(user) {
  var dateOptions = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  user.cpf = user.cpf.replace(/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})/, '$1.$2.$3-$4');
  user.dateBirth = new Date("".concat(user.dateBirth.year, "-").concat(user.dateBirth.month, "-").concat(user.dateBirth.day, " 00:00:00")).toLocaleDateString('pt-BR', dateOptions).replace(/ de /g, "-");
  user.phone = user.phone ? user.phone = user.phone.replace(/([0-9]{2})([0-9]{4,5})([0-9]{4})/, '($1) $2-$3') : '';
  user.address.zipCode = user.address.zipCode ? user.address.zipCode = user.address.zipCode.replace(/([0-9]{5})([0-9]{3})/, '$1-$2') : '';
} // Excluir usuário


function deleteUser(id, e) {
  if (confirm('Se você excluir este usuário, todos os atendimentos associados a ele serão reassociados a você.\nTem certeza de que quer prosseguir com a exclusão?')) {
    $.ajax({
      method: 'POST',
      url: "".concat($(USER_FORM).attr('action'), "?action=delete"),
      data: {
        id: id
      },
      success: function success(response) {
        toastr.success(response.message);
        $(e.target).closest('tr').remove();
      },
      error: function error(_error7) {
        var status = _error7.status,
            responseJSON = _error7.responseJSON;

        if (status == 422) {
          toastr.error(responseJSON.message);
        } else {
          console.error(_error7);
        }
      }
    });
  }
} // Abrir modal/form para criação de usuário


function createUser() {
  $('#password-creation').show();
  $("".concat(USER_FORM, "-title")).text('Cadastrar Colaborador');
  $("".concat(USER_FORM, " [name=\"cpf\"]")).prop('readonly', false);
  $("".concat(USER_FORM, " [name=\"email\"]")).prop('readonly', false);
  $(USER_MODAL).modal('show');
  cleanForm(USER_FORM);
  $('#user-first_name').focus();
} // Abrir modal/form para edição de dados cadastrais


function editUser(id) {
  cleanForm(USER_FORM);
  $('#password-creation').hide();
  $("".concat(USER_FORM, " [name=\"cpf\"]")).prop('readonly', true);
  $("".concat(USER_FORM, " [name=\"email\"]")).prop('readonly', true);
  $("".concat(USER_FORM, "-title")).text("Editar Colaborador (usu\xE1rio #".concat(id, ")"));
  $(USER_MODAL).modal('show');
  $.ajax({
    method: 'GET',
    url: "".concat($(USER_FORM).attr('action'), "?id=").concat(id),
    success: function success(response) {
      var user = escapeHTML(response);
      formatUserData(user);
      $("".concat(USER_FORM, " [name=\"id\"]")).val(user.id);
      $("".concat(USER_FORM, " [name=\"role\"][value=\"").concat(user.role, "\"]")).prop("checked", true);
      $("".concat(USER_FORM, " [name=\"first_name\"]")).val(user.firstName).focus();
      $("".concat(USER_FORM, " [name=\"last_name\"]")).val(user.lastName).focus();
      $("".concat(USER_FORM, " [name=\"cpf\"]")).val(user.cpf);
      $("".concat(USER_FORM, " [name=\"date_birth\"]")).val("".concat(user.dateBirth));
      $("".concat(USER_FORM, " [name=\"email\"]")).val(user.email);
      $("".concat(USER_FORM, " [name=\"phone\"]")).val(user.phone);
      $("".concat(USER_FORM, " [name=\"zip_code\"]")).val(user.address.zipCode);
      $("".concat(USER_FORM, " [name=\"street\"]")).val(user.address.street);
      $("".concat(USER_FORM, " [name=\"number\"]")).val(user.address.number);
      $("".concat(USER_FORM, " [name=\"complement\"]")).val(user.address.complement);
      $("".concat(USER_FORM, " [name=\"city\"]")).val(user.address.city);
      $("".concat(USER_FORM, " [name=\"state\"]")).val(user.address.state ? user.address.state.id : '');
    },
    error: function error(_error8) {
      console.error(_error8);
      $(USER_MODAL).modal('hide');
      toastr.error("Falha ao tentar recuperar os dados do usu\xE1rio #".concat(id));
    }
  });
} // Montar linha da tabela de usuários


function userRow() {
  var user = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  user = escapeHTML(user);
  formatUserData(user, {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
  user.role = user.role == 'gerente' ? '<i class="fas fa-user-check"></i>' : '';
  return "\n    <tr>\n      <th scope=\"row\" class=\"text-center\">".concat(user.cpf, "</th>\n      <td class=\"text-left\">").concat(user.firstName, " ").concat(user.lastName, "</td>\n      <td class=\"text-center\">").concat(user.dateBirth, "</td>\n      <td class=\"text-center\">").concat(user.phone, "</td>\n      <td class=\"text-center\">").concat(user.role, "</td>\n      <td class=\"text-right\">\n        <button type=\"button\" class=\"btn btn-sm btn-info\" title=\"Editar dados\" onclick=\"editUser(").concat(user.id, ")\"><i class=\"fas fa-edit\"></i></button>\n        <button type=\"button\" class=\"btn btn-sm btn-warning\" title=\"Alterar senha\" onclick=\"editPassword(").concat(user.id, ")\"><i class=\"fas fa-unlock-alt\"></i></button>\n        <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Excluir\" onclick=\"deleteUser(").concat(user.id, ", event)\"><i class=\"fas fa-trash-alt\"></i></button>\n      </td>\n    </tr>\n  ");
} // Configurar evento de submissão de formulário de usuário


$(USER_FORM).submit(function (e) {
  e.preventDefault();
  var user = extractDataForm(USER_FORM);
  user.role = $("".concat(USER_FORM, " [name=\"role\"]:checked")).val();
  $.ajax({
    method: 'POST',
    url: "".concat($(USER_FORM).attr('action'), "?action=").concat(!user.id ? 'new' : 'update'),
    data: user,
    success: function success(response) {
      if (!user.id) {
        toastr.success('Usuário criado com sucesso');
        $("".concat(USER_TABLE, " tbody")).append(userRow(response));
      } else {
        toastr.success('Usuário atualizado com sucesso');
        $("".concat(USER_TABLE, " tbody tr")).filter(function (i, el) {
          return $(el).children().first().text().trim() == user.cpf;
        }).replaceWith(userRow(response));
      }

      $(USER_MODAL).modal('hide');
    },
    error: function error(_error9) {
      var status = _error9.status,
          responseJSON = _error9.responseJSON;

      if (status == 422) {
        responseJSON.forEach(function (err) {
          return toastr.error(err.message);
        });
      } else {
        console.error(_error9);
      }
    }
  });
}); // Abrir modal/form para alteração de senha

function editPassword(id) {
  cleanForm(PSWD_FORM);
  $("".concat(PSWD_FORM, "-title")).text("Editar Senha (usu\xE1rio #".concat(id, ")"));
  $("".concat(PSWD_FORM, " [name=\"id\"]")).val(id);
  $("".concat(PSWD_FORM, " [name=\"password\"]")).focus();
  $(PSWD_MODAL).modal('show');
} // Configurar evento de submissão de formulário de alteração de senha


$(PSWD_FORM).submit(function (e) {
  e.preventDefault();
  var user = extractDataForm(PSWD_FORM);
  user.role = $("".concat(PSWD_FORM, " [name=\"role\"]:checked")).val();
  $.ajax({
    method: 'POST',
    url: $(PSWD_FORM).attr('action'),
    data: user,
    success: function success(response) {
      toastr.success('Senha alterada com sucesso');
      $(PSWD_MODAL).modal('hide');
    },
    error: function error(_error10) {
      var status = _error10.status,
          responseJSON = _error10.responseJSON;
      console.log(responseJSON);

      if (status == 422) {
        if (!(responseJSON instanceof Array)) responseJSON = [responseJSON];
        responseJSON.forEach(function (err) {
          return toastr.error(err.message);
        });
      } else {
        console.error(_error10);
      }
    }
  });
}); // Adicionar evento para linhas de tabelas

$('.c-clickable').click(function () {
  window.location = $(this).data('href');
}); // Ação para filtragem de atendimentos

function filterTickets() {
  var val = $(this).val();
  var none = $('tbody tr:first-child');
  var rows = $('.c-clickable');
  var open = $('td span.badge-warning').parents('tr');
  var closed = $('td span.badge-success').parents('tr');
  $(none).hide();
  $(rows).hide();

  if (!$(rows).length) {
    $(none).show();
  } else {
    switch (val) {
      case 'open':
        $(open).show();
        break;

      case 'closed':
        $(closed).show();
        break;

      default:
        $(rows).show();
    }
  }
} // Ação para ordenação de atendimentos


function sortTickets() {
  $('tbody').each(function () {
    var arr = $.makeArray($('tr', this).detach());
    arr.reverse();
    $(this).append(arr);
  });
} // Adicionar evento para filtro e ordenação de atendimentos


$('#ticket-filter').on('input', filterTickets);
$('#ticket-sorter').on('input', sortTickets); // Filtrar atendimentos por "abertos" inicialmente

$('#ticket-filter option:nth-child(2)').prop('selected', true);

if (window['ticket-filter']) {
  if ('createEvent' in document) {
    var e = document.createEvent('HTMLEvents');
    e.initEvent('input', false, true);
    window['ticket-filter'].dispatchEvent(e);
  } else window['ticket-filter'].fireEvent('oninput');
}

function buildMessage(msgObj) {
  var dateOptions = {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric'
  };
  var date = new Date("".concat(msgObj.sendDate.date.year, "-").concat(msgObj.sendDate.date.month, "-").concat(msgObj.sendDate.date.day, " ").concat(msgObj.sendDate.time.hour, ":").concat(msgObj.sendDate.time.minute, ":").concat(msgObj.sendDate.time.second)).toLocaleDateString('pt-BR', dateOptions).replace(/ de /g, "-");
  return "\n    <div class=\"c-message col-10 col-md-8 ml-auto\">\n      <div class=\"c-message-body rounded bg-primary\">\n        <div class=\"c-message-sender\">\n          ".concat(msgObj.sender.role != 'cliente' ? '<i class="fas fa-user-check"></i>' : '', "\n          ").concat(escapeHTML(msgObj.sender.firstName), " ").concat(escapeHTML(msgObj.sender.lastName)[0], ".\n        </div>\n        <p>").concat(escapeHTML(msgObj.message), "</p>\n        <div class=\"text-right c-message-time\">\n          Enviada em ").concat(date, "\n        </div>\n      </div>\n    </div>\n  ");
} // Rolar a caixa de conversa para baixo


$('#ticket-messages').animate({
  scrollTop: $('#ticket-messages').prop('scrollHeight')
}, 1000); // Definir ação de envio de mensagens

function sendMessage() {
  $.ajax({
    method: 'POST',
    url: $('#ticket-message-form').prop('action'),
    data: {
      message: $('#new-ticket-message').val()
    },
    success: function success(response) {
      cleanForm('#ticket-message-form');
      charCounter({
        target: {
          value: ''
        }
      }, '#char-counter', 255);
      $('#ticket-messages').append(buildMessage(response));
      $('#ticket-messages').animate({
        scrollTop: $('#ticket-messages').prop('scrollHeight')
      }, 800);
      toastr.success('Mensagem recebida');
    },
    error: function error(_error11) {
      var status = _error11.status,
          responseJSON = _error11.responseJSON;

      if (status == 422) {
        if (!(responseJSON instanceof Array)) responseJSON = [responseJSON];
        responseJSON.forEach(function (err) {
          return toastr.error(err.message);
        });
      } else {
        console.error(_error11);
      }
    }
  });
} // Procurar produto


function findProduct() {
  $('#product-details').hide();
  var url = $('#prodAPI').val();
  var productCode = $('#product-barcode').val();
  $.ajax({
    method: 'GET',
    url: "".concat(url, "?code=").concat(productCode),
    success: function success(product) {
      $('#product-id').val(product.id);
      $('#product-name').val(product.name);
      $('#product-category').val(product.category.name);
      $('#product-utc').val(product.utc);
      $('#product-ean').val(product.ean);
      $('#product-details').show();
    },
    error: function error(res) {
      toastr.error('Produto não encontrado');
    }
  });
}

$('#ticket-new-form').submit(function (e) {
  e.preventDefault();
  var url = $('#ticket-new-form').prop('action');
  var data = {
    product: $('[name="product"]').val(),
    type: $('[name="type"]').val(),
    message: $('[name="message"]').val()
  };
  console.log(data);
  $.ajax({
    method: 'POST',
    url: url,
    data: data,
    success: function success() {
      var baseUrl = window.location.href.split('/');
      baseUrl.pop();
      window.location.href = baseUrl.join('/');
    },
    error: function error(_error12) {
      var status = _error12.status,
          responseJSON = _error12.responseJSON;

      if (status == 422) {
        if (!(responseJSON instanceof Array)) responseJSON = [responseJSON];
        responseJSON.forEach(function (err) {
          return toastr.error(err.message);
        });
      } else {
        console.error(this);
      }
    }
  });
});

function closeTicket(url) {
  console.log(url);
  $.ajax({
    method: 'POST',
    url: url,
    success: function success() {
      window.location.href = window.location.href;
    },
    error: function error(_error13) {
      var status = _error13.status,
          responseJSON = _error13.responseJSON;

      if (status == 422) {
        if (!(responseJSON instanceof Array)) responseJSON = [responseJSON];
        responseJSON.forEach(function (err) {
          return toastr.error(err.message);
        });
      } else {
        console.error(_error13);
      }
    }
  });
}

function generateReport2(e) {
  var ini = new Date($('[name="dataIni"]').val());
  var fim = new Date($('[name="dataFim"]').val());

  if (ini > fim) {
    e.preventDefault();
    toastr.error('Data inicial tem que ser anterior da data final');
  }
}

/***/ }),

/***/ "./resources/scripts/vendor.js":
/*!*************************************!*\
  !*** ./resources/scripts/vendor.js ***!
  \*************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(bootstrap__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var jquery_mask_plugin__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! jquery-mask-plugin */ "./node_modules/jquery-mask-plugin/dist/jquery.mask.js");
/* harmony import */ var jquery_mask_plugin__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(jquery_mask_plugin__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _chenfengyuan_datepicker__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @chenfengyuan/datepicker */ "./node_modules/@chenfengyuan/datepicker/dist/datepicker.js");
/* harmony import */ var _chenfengyuan_datepicker__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_chenfengyuan_datepicker__WEBPACK_IMPORTED_MODULE_2__);
/*
 * Import Bootstrap dependencies
 */
window.$ = window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
window.popper = __webpack_require__(/*! popper.js */ "./node_modules/popper.js/dist/esm/popper.js")["default"];

/*
 * Import jQuery plugins
 */



/*
 * Import toastr
 */

window.toastr = __webpack_require__(/*! toastr */ "./node_modules/toastr/toastr.js");
/*
 * Import Vue.js framework
 */

window.Vue = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");

/***/ }),

/***/ "./resources/styles/main.scss":
/*!************************************!*\
  !*** ./resources/styles/main.scss ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!**********************************************************************!*\
  !*** multi ./resources/scripts/main.js ./resources/styles/main.scss ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! P:\Web\Sistema Reclame Ali\resources\scripts\main.js */"./resources/scripts/main.js");
module.exports = __webpack_require__(/*! P:\Web\Sistema Reclame Ali\resources\styles\main.scss */"./resources/styles/main.scss");


/***/ })

},[[0,"/js/manifest","/js/vendor"]]]);