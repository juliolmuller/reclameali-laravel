import qs from 'querystring'

// Identify page controller
const apiUrl = $('meta[name="api-url"]')[0].content

export default new Vue({

  el: '#categories-crud',

  data() {
    return {
      isLoading: true,
      requesting: false,
      currentPage: 1,
      currCategory: {},
      categories: [],
    }
  },

  methods: {

    /**
     * Display the form
     */
    showForm() {
      $('.modal').modal('show')
    },

    /**
     * Hide the form
     */
    hideForm() {
      $('.modal').modal('hide')
      this.currCategory = {}
    },

    /**
     * Display the error through toasts or at the console
     *
     * @param {object} response Error response
     */
    displayErrors(response) {
      if (response.responseJSON && response.responseJSON.errors) {
        Object.values(response.responseJSON.errors).forEach(error => toastr.error(error[0]))
      } else {
        console.error(response)
      }
    },

    /**
     * Fetch categories API to return a page of items
     *
     * @param {number} page Number of the page to be fetched
     */
    get(page) {
      this.isLoading = true
      this.currentPage = page || this.currentPage
      $.ajax({
        url: `${apiUrl}?page=${this.currentPage}`,
        method: 'GET',
        success: (response) => {
          this.categories = response.data
        },
        error: (response) => {
          toastr.error('Não foi possível carregar os itens desta página.')
          console.error(response)
        },
        complete: () =>this.isLoading = false,
      })
    },

    /**
     * Request a new category to be saved
     */
    post() {
      this.requesting = true
      $.ajax({
        url: apiUrl,
        method: 'POST',
        data: this.currCategory,
        success: () => {
          toastr.success('Categoria criada com sucesso.')
          this.hideForm()
          this.get()
        },
        error: this.displayErrors,
        complete: () => this.requesting = false,
      })
    },

    /**
     * Open modal form and load category data for editing
     *
     * @param {object} category Category object to be editted
     */
    edit(category) {
      this.currCategory = {
        id: category.id,
        name: category.name,
        api: category.links.update
      }
      this.showForm()
    },

    /**
     * Request an existing category to be saved
     */
    put() {
      this.requesting = true
      $.ajax({
        url: this.currCategory.api.url,
        method: this.currCategory.api.method,
        data: this.currCategory,
        success: () => {
          toastr.success('Categoria atualizada com sucesso.')
          this.hideForm()
          this.get()
        },
        error: this.displayErrors,
        complete: () => this.requesting = false,
      })
    },

    /**
     * Request the deletion of a category
     *
     * @param {object} category Category object to be deleted
     */
    destroy(category) {
      if (!confirm(`Tem certeza de que deseja excluir a categoria #${category.id}?`)) {
        return
      }
      $.ajax({
        url: category.links.delete.url,
        method: category.links.delete.method,
        success: () => {
          toastr.success('Categoria excluída com sucesso.')
          this.get()
        },
        error: (response) => {
          toastr.error(`Não foi possível exlcuir a categoria #${category.id}.`)
          console.error(response)
        }
      })
    },
  },

  created() {
    const querystring = qs.parse(window.location.search.substring(1))
    this.currentPage = querystring.page || localStorage.categoryPage || 1
    this.get()
  }
})
