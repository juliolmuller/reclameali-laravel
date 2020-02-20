
Vue.filter('numeric', function(value, decimals = 0) {

  if (!value) {
    return ''
  }

  if (isNaN(value)) {
    return value
  }

  const number = numeral(value)
  const format = '0,0.' + '0'.repeat(decimals)
  numeral.locale('pt-BR')

  return number.format(format)
})
