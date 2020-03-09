/*
 * Load the necessary controller for the page
 */
(function() {

  // Identify page controller
  const controller = $('meta[name="controller"]')[0].content

  // Instantiate Vue according to controller
  require(`./${controller}`)

})()
