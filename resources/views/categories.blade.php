
@extends('layout.baseLayout')

@section('body')

  {{-- Page header --}}
  @header([
    'activePage'      => 1,
    'navigationLinks' => [
      ['label' => 'Home',         'href' => url('/')],
      ['label' => 'Atendimentos', 'href' => url('/atendimentos')],
      ['label' => 'Categorias',   'href' => url('/categorias')],
      ['label' => 'Produtos',     'href' => url('/produtos')],
    ],
  ])
  @endheader

  {{-- Page content --}}
  <main class="container c-main">
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
    <div class="mt-3">
      <table id="category-table" class="table table-hover">
        <thead class="c-thead">
          <tr class="text-center">
            <th scope="col">#</th>
            <th scope="col">Descrição da Categoria</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <c:choose>
            <c:when test="${empty categories}">
              <tr><td colspan="3" class="h4 py-4">Nenhuma categoria cadastrada.</td></tr>
            </c:when>
            <c:otherwise>
              <c:forEach var="category" items="${categories}">
                <tr>
                  <th scope="row" class="text-center"><fmt:formatNumber type="number" value="${category.id}" pattern="000"/></th>
                  <td><c:out value="${category.name}" /></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-sm btn-info" title="Editar" onclick="editCategory(<c:out value="${category.id}" />)"><i class="fas fa-edit"></i></button>
                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="deleteCategory(<c:out value="${category.id}" />, event)"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              </c:forEach>
            </c:otherwise>
          </c:choose>
        </tbody>
      </table>
    </div>

    {{-- Form to manage categories --}}
    <div id="category-modal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <form action="${pageContext.request.contextPath}/api/categories" id="category-form" class="modal-content" novalidate>
          <div class="modal-header">
            <h2 id="category-form-title" class="modal-title"></h2>
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" value="" />
            <div class="form-group">
              <label for="category-name">Nome da categoria:</label>
              <textarea id="category-name" class="form-control" name="name" rows="3" maxlength="255" oninput="charCounter(event, '#char-counter', 255)"></textarea>
              <small id="char-counter" class="form-text text-muted text-right">
                Caracteres digitados: 0/255
              </small>
            </div>
          </div>
          <div class="modal-footer c-sign-buttons">
            <button type="button" class="btn btn-lg btn-light" data-dismiss="modal">
              <i class="far fa-times-circle"></i>
              Cancelar
            </button>
            <button type="submit" class="btn btn-lg btn-primary">
              <i class="far fa-save"></i>
              Salvar
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>

  {{-- Page footer --}}
  @footer()
  @endfooter

@endsection
