
@extends('layout.baseLayout', [
    'apiUrl'     => route('api.products.index'),
    'controller' => 'products',
])

@section('body')

  {{-- Page header --}}
  @header
  @endheader

  {{-- Page content --}}
  <main id="products-crud" class="container c-main">
    <div class="d-flex flex-wrap justify-content-between align-items-start">
      <div>
        <h1 class="mb-4">
          Produtos
        </h1>
      </div>

      {{-- Button to create new product --}}
      <button type="button" class="btn btn-primary mt-1" @@click="showForm()">
        <i class="fa fa-plus"></i>
        Criar Novo Produto
      </button>
    </div>

    {{-- Products table --}}
    <div class="mt-3 h-100">
      <div class="d-flex h-100 justify-content-center align-items-center" v-if="isLoading">
        <img src="{{ asset('img/loading.svg') }}" alt="Loading animation" style="max-height:100px;" />
      </div>
      <table id="product-table" class="table table-hover" v-else>
        <thead class="c-thead">
          <tr class="text-center">
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Peso</th>
            <th scope="col">Categoria</th>
            <th scope="col">Código de Barras</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="!products.length">
            <td colspan="6" class="h4 py-4">Nenhum producto cadastrado.</td>
          </tr>
          <template v-else>
            <tr v-for="product in products" :key="product.id">
              <th scope="row" class="text-center">@{{ product.id }}</th>
              <td class="text-left">@{{ product.name }}</td>
              <td class="text-right">@{{ product.weight | numeric | append(' g') }}</td>
              <td class="text-center">@{{ product.category.name }}</td>
              <td class="text-center">@{{ product.utc | utc }}</td>
              <td class="text-right">
                <button type="button" class="btn btn-sm btn-info" title="Editar" @@click="edit(product)">
                  <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger" title="Excluir" @@click="destroy(product)">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    {{-- Form to manage products --}}
    <div class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" novalidate>
          <div class="modal-header">
            <h2 class="modal-title" v-if="!currProduct.id">Novo Produto</h2>
            <h2 class="modal-title" v-else>Editando Produto #@{{ currProduct.id }}</h2>
            <button type="button" class="close" @@click="hideForm()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12 form-group">
                <label for="product-name">Nome do produto:</label>
                <input type="text" id="product-name" class="form-control" v-model="currProduct.name" />
              </div>
              <div class="col-12 col-md-6 form-group">
                <label for="product-category">Categoria:</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-puzzle-piece"></i>
                    </span>
                  </div>
                  <select id="product-category" class="form-control" data-api="{{ route('api.categories.index') }}" v-model="currProduct.category">
                    {{-- <option value="" disabled>Selecione...</option> --}}
                    <option v-for="category in  categories" :key="category.id" :value="category.id">@{{ category.name }}</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6 form-group">
                <label for="product-weight">Peso líquido (em gramas):</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-weight"></i>
                    </span>
                  </div>
                  <input type="text" id="product-weight" class="form-control" v-model="currProduct.weight" />
                </div>
              </div>
              <div class="col-12 col-md-6 form-group">
                <div class="form-group">
                  <label for="product-utc">Código UTC (12 digitos):</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-barcode"></i>
                      </span>
                    </div>
                    <input type="text" id="product-utc" class="form-control" v-model="currProduct.utc" />
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 form-group">
                <label for="product-ean">Código EAN (13 digitos):</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-barcode"></i>
                    </span>
                  </div>
                  <input type="text" id="product-ean" class="form-control" v-model="currProduct.ean" />
                </div>
              </div>
              <div class="col-12 form-group">
                <label for="product-description">Descrição:</label>
                <textarea id="product-description" class="form-control char-counter" rows="3" maxlength="255" v-model="currProduct.description"></textarea>
                <small class="form-text text-muted text-right char-counter">
                  Caracteres digitados: <span>0/255</span>
                </small>
              </div>
            </div>
          </div>
          <div class="modal-footer c-sign-buttons">
            <button type="button" class="btn btn-lg btn-light" @@click="hideForm()">
              <i class="far fa-times-circle"></i>
              Cancelar
            </button>
            <button type="submit" class="btn btn-lg btn-primary" :disabled="requesting" @@click.prevent="!!currProduct.id ? put() : post()">
              <template v-if="requesting">
                <i class="fa fa-spinner fa-spin"></i>
              </template>
              <template v-else>
                <i class="far fa-save"></i>
                Salvar
              </template>
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>

  {{-- Rodapé da página --}}
  @footer
  @endfooter

@endsection
