
Vue.filter('utc', function(value) {

  if (!value) {
    return ''
  }

  const pattern = /(\d{4})(\d{4})(\d{4})/
  value = value.toString()

  if (value.match(pattern)) {
    return value.replace(pattern, '$1.$2.$3')
  }

  return value
})
