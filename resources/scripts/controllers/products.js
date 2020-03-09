import qs from 'querystring'

// Identify page controller
const apiUrl = $('meta[name="api-url"]')[0].content

export default new Vue({

  el: '#products-crud',

  data() {
    return {
      isLoading: true,
      requesting: false,
      currentPage: 1,
      currProduct: {},
      products: [],
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
      this.currProduct = {}
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
     * Fetch products API to return a page of items
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
          this.products = response.data
        },
        error: (response) => {
          toastr.error('Não foi possível carregar os itens desta página.')
          console.error(response)
        },
        complete: () =>this.isLoading = false,
      })
    },

    /**
     * Request a new product to be saved
     */
    post() {
      this.requesting = true
      $.ajax({
        url: apiUrl,
        method: 'POST',
        data: this.currProduct,
        success: () => {
          toastr.success('Produto criado com sucesso.')
          this.hideForm()
          this.get()
        },
        error: this.displayErrors,
        complete: () => this.requesting = false,
      })
    },

    /**
     * Open modal form and load product data for editing
     *
     * @param {object} product Product object to be editted
     */
    edit(product) {
      this.currProduct = {
        id: product.id,
        utc: product.utc,
        ean: product.ean,
        name: product.name,
        weight: product.weight,
        category: product.category.id,
        description: product.description,
        api: product.links.update
      }
      this.showForm()
    },

    /**
     * Request an existing product to be saved
     */
    put() {
      this.requesting = true
      $.ajax({
        url: this.currProduct.api.url,
        method: this.currProduct.api.method,
        data: this.currProduct,
        success: () => {
          toastr.success('Produto atualizado com sucesso.')
          this.hideForm()
          this.get()
        },
        error: this.displayErrors,
        complete: () => this.requesting = false,
      })
    },

    /**
     * Request the deletion of a product
     *
     * @param {object} product Product object to be deleted
     */
    destroy(product) {
      if (!confirm(`Tem certeza de que deseja excluir o produto #${product.id}?`)) {
        return
      }
      $.ajax({
        url: product.links.delete.url,
        method: product.links.delete.method,
        success: () => {
          toastr.success('Produto excluído com sucesso.')
          this.get()
        },
        error: (response) => {
          toastr.error(`Não foi possível exlcuir o produto #${product.id}.`)
          console.error(response)
        }
      })
    },
  },

  created() {
    const querystring = qs.parse(window.location.search.substring(1))
    this.currentPage = querystring.page || localStorage.productPage || 1
    this.get()
    $.ajax({
      url: $('#product-category').data('api'),
      method: 'GET',
      success: (response) => {
        this.categories = response.data
      },
      error: (response) => {
        console.error(response)
      },
    })
  }
})
