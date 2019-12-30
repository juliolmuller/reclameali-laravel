
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
    <div class="mt-3">
      <table id="product-table" class="table table-hover">
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
          <c:choose>
            <c:when test="${empty products}">
              <tr><td colspan="6" class="h4 py-4">Nenhum producto cadastrado.</td></tr>
            </c:when>
            <c:otherwise>
              <c:forEach var="product" items="${products}">
                <tr>
                  <th scope="row" class="text-center">
                    <fmt:formatNumber type="number" value="${product.id}" pattern="000000"/>
                  </th>
                  <td class="text-left">
                    <c:out value="${product.name}" />
                  </td>
                  <td class="text-right">
                    <fmt:setLocale value="pt_BR"/>
                    <fmt:formatNumber type="number" value="${product.weight}" minFractionDigits="1" maxFractionDigits="1"/>g
                  </td>
                  <td class="text-center">
                    <c:choose>
                      <c:when test="${fn:length(product.category.name) > 12}">
                        <span title="<c:out value="${product.category.name}" />">
                          <c:out value="${fn:substring(product.category.name, 0, 10)}..." />
                        </span>
                      </c:when>
                      <c:otherwise>
                        <c:out value="${product.category.name}" />
                      </c:otherwise>
                    </c:choose>
                  </td>
                  <td class="text-center">
                    <c:out value="${fn:substring(product.utc, 0, 4)}.${fn:substring(product.utc, 4, 8)}.${fn:substring(product.utc, 8, 12)}" />
                  </td>
                  <td class="text-right">
                    <button type="button" class="btn btn-sm btn-info" title="Editar" onclick="editProduct(<c:out value="${product.id}" />)"><i class="fas fa-edit"></i></button>
                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="deleteProduct(<c:out value="${product.id}" />, event)"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              </c:forEach>
            </c:otherwise>
          </c:choose>
        </tbody>
      </table>
    </div>

    {{-- Form to manage products --}}
    <div id="product-modal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <form action="${pageContext.request.contextPath}/api/products" id="product-form" class="modal-content" novalidate>
          <div class="modal-header">
            <h2 id="product-form-title" class="modal-title"></h2>
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" value="" />
            <div class="row">
              <div class="col-12 form-group">
                <label for="product-name">Nome do produto:</label>
                <input type="text" id="product-name" class="form-control" name="name" minlengh="5" maxlengh="50" />
              </div>
              <div class="col-12 col-md-6 form-group">
                <label for="product-category">Categoria:</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-puzzle-piece"></i>
                    </span>
                  </div>
                  <select id="product-category" class="form-control" name="category">
                    <option value="" disabled>Selecione...</option>
                    <c:forEach var="category" items="${categories}">
                      <option value="${category.id}"><c:out value="${category.name}" /></option>
                    </c:forEach>
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
                  <input type="text" id="product-weight" class="form-control" name="weight" />
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
                    <input type="text" id="product-utc" class="form-control" name="utc_code" />
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
                  <input type="text" id="product-ean" class="form-control" name="ean_code" />
                </div>
              </div>
              <div class="col-12 form-group">
                <label for="product-description">Descrição:</label>
                <textarea id="product-description" class="form-control" name="description" rows="3" maxlength="255" oninput="charCounter(event, '#char-counter', 255)"></textarea>
                <small id="char-counter" class="form-text text-muted text-right">
                  Caracteres digitados: 0/255
                </small>
              </div>
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

  {{-- Rodapé da página --}}
  @footer()
  @endfooter

@endsection
