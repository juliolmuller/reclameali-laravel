
Vue.filter('append', function(value, tail = '') {

  return `${value}${tail}`
})
