
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
      <button type="button" class="btn btn-primary mt-1" onclick="createProduct()">
        <i class="fa fa-plus"></i>
        Criar Novo Produto
      </button>
    </div>

    {{-- Products table --}}
    <div class="mt-3 h-100">
      <div class="d-flex h-100 justify-content-center align-items-center" v-if="isLoading">
        <img src="{{ asset('img/loading.svg') }}" alt="Loading animation" style="max-height:100px;" />
      </div>
      <table id="product-table" class="table table-hover" v-show="!isLoading">
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
                <button type="button" class="btn btn-sm btn-info" title="Editar"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-sm btn-danger" title="Excluir"><i class="fas fa-trash-alt"></i></button>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
  </main>

  {{-- Rodapé da página --}}
  @footer
  @endfooter

@endsection
