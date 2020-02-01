/**
 * Import third party modules
 */
import './vendor'

/**
 * Configure jQuery AJAX to send CSRF Token in every request
 */
const token = $('meta[name="csrf-token"]').attr('content')
if (token)
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token } })
else
  console.error('CSRF token not found')

/**
 * Import custom scripts
 */
import './scripts'
