
export default /* window.initVue = */ function(pageName, apiUrl) {

  return new Vue({

    el: `#${pageName}-crud`,

    data() {
      return {
        isLoading: true,
        [pageName]: []
      }
    },

    created() {
      $.ajax({
        url: apiUrl,
        method: 'GET',
        success: response => {
          this[pageName] = response.data
          this.isLoading = false
        }
      })
    }
  })
}
