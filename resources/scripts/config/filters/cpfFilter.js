
Vue.filter('cpf', function(value) {

  if (!value) {
    return ''
  }

  const pattern = /(\d{3})(\d{3})(\d{3})(\d{2})/
  value = value.toString()

  if (value.match(pattern)) {
    return value.replace(pattern, '$1.$2.$3-$4')
  }

  return value
})
