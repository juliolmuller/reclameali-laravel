
@extends('layout.baseLayout', [
    'apiUrl'     => route('api.categories.index'),
    'controller' => 'categories',
])

@section('body')

  {{-- Page header --}}
  @header
  @endheader

  {{-- Page content --}}
  <main id="categories-crud" class="container c-main">
    <div class="d-flex flex-wrap justify-content-between align-items-start">
      <div>
        <h1 class="mb-4">
          Categorias de Produtos
        </h1>
      </div>

      {{-- Button to create new category --}}
      <button type="button" class="btn btn-primary mt-1" onclick="createCategory()">
        <i class="fa fa-plus"></i>
        Criar Nova Categoria
      </button>
    </div>

    {{-- Categories table --}}
    <div class="mt-3 h-100">
      <div class="d-flex h-100 justify-content-center align-items-center" v-if="isLoading">
        <img src="{{ asset('img/loading.svg') }}" alt="Loading animation" style="max-height:100px;" />
      </div>
      <table id="category-table" class="table table-hover" v-show="!isLoading">
        <thead class="c-thead">
          <tr class="text-center">
            <th scope="col">#</th>
            <th scope="col">Descrição da Categoria</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="!categories.length">
            <td colspan="3" class="h4 py-4">Nenhuma categoria cadastrada.</td>
          </tr>
          <template v-else>
            <tr v-for="category in categories" :key="category.id">
              <th scope="row" class="text-center">@{{ category.id }}</th>
              <td>@{{ category.name }}</td>
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

  {{-- Page footer --}}
  @footer
  @endfooter

@endsection
