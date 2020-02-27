
/*
 * Import Bootstrap dependencies
 */
window.$ = window.jQuery = require('jquery')
window.popper = require('popper.js').default
import 'bootstrap'

/*
 * Import jQuery plugins
 */
import 'jquery-mask-plugin'
import '@chenfengyuan/datepicker'

/*
 * Import toastr
 */
window.toastr = require('toastr')

/*
 * Import numeral
 */
window.numeral = require('numeral')

/*
 * Import Vue.js framework
 */
window.Vue = require('vue')

/*
 * Import cpfFmt function
 */
window.cpfFmt = require('@lacussoft/cpf-fmt')
