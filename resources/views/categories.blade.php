
@extends('layout.baseLayout')

@section('body')

  {{-- Page header --}}
  @header([
    'activePage'      => 1,
    'navigationLinks' => $user->headerLinks,
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
  </main>

  {{-- Page footer --}}
  @footer()
  @endfooter

@endsection
