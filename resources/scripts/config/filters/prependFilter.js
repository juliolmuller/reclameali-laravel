
Vue.filter('prepend', function(value, head = '') {

  return `${head}${value}`
})
