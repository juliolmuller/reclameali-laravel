
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
      <button type="button" class="btn btn-primary mt-1" @@click="showForm()">
        <i class="fa fa-plus"></i>
        Criar Nova Categoria
      </button>
    </div>

    {{-- Categories table --}}
    <div class="mt-3 h-100">
      <div class="d-flex h-100 justify-content-center align-items-center" v-if="isLoading">
        <img src="{{ asset('img/loading.svg') }}" alt="Loading animation" style="max-height:100px;" />
      </div>
      <table id="category-table" class="table table-hover" v-else>
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
                <button type="button" class="btn btn-sm btn-info" title="Editar" @@click="edit(category)">
                  <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger" title="Excluir" @@click="destroy(category)">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    {{-- Form to manage categories --}}
    <div class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" novalidate>
          <div class="modal-header">
            <h2 class="modal-title" v-if="!currCategory.id">Nova Categoria</h2>
          <h2 class="modal-title" v-else>Editando Categoria #@{{ currCategory.id }}</h2>
            <button type="button" class="close" @@click="hideForm()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" v-model="currCategory.id" />
            <div class="form-group">
              <label for="category-name">Nome da categoria:</label>
              <textarea id="category-name" class="form-control char-counter" rows="3" maxlength="255" v-model="currCategory.name"></textarea>
              <small class="form-text text-muted text-right char-counter">
                Caracteres digitados: 0/255
              </small>
            </div>
          </div>
          <div class="modal-footer c-sign-buttons">
            <button type="button" class="btn btn-lg btn-light" @@click="hideForm()">
              <i class="far fa-times-circle"></i>
              Cancelar
            </button>
            <button type="submit" class="btn btn-lg btn-primary" :disabled="requesting" @@click="!!currCategory.id ? put() : post()">
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

  {{-- Page footer --}}
  @footer
  @endfooter

@endsection
