
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
    <h1 class="mb-4">
      Novo Atendimento
    </h1>

    {{-- Form to create new tickets --}}
    <div class="mt-5">
      <form action="${baseUri}/atendimentos/novo" method="POST" id="ticket-new-form">
        <div class="row">
          <div class="col-12 col-md-6">
            <input type="hidden" id="prodAPI" value="${pageContext.request.contextPath}/api/products">
            <div class="form-group">
              <label for="product-barcode">Código de barras do produto:</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-barcode"></i>
                  </span>
                </div>
                <input type="number" id="product-barcode" class="form-control" placeholder="12 ou 13 digitos" />
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="button" onclick="findProduct()">
                    Buscar Produto
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div id="product-details" class="col-12 col-md-6" style="display:none">
            <input type="hidden" id="product-id" name="product" value="" />
            <div class="form-group">
              <label for="product-name">Nome do produto:</label>
              <input type="text" id="product-name" class="form-control" readonly />
            </div>
            <div class="form-group">
              <label for="product-category">Categoria:</label>
              <input type="text" id="product-category" class="form-control" readonly />
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="product-utc">Código UTC:</label>
                  <input type="number" id="product-utc" class="form-control" readonly />
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="product-ean">Código EAN:</label>
                  <input type="number" id="product-ean" class="form-control" readonly />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-8">
            <div class="form-group">
              <label for="ticket-type">Tipo do atendimento:</label>
              <select id="ticket-type" class="form-control" name="type">
                <option value="" disabled selected>Selecione...</option>
                <c:forEach var="type" items="${types}">
                  <option value="${type.id}"><c:out value="${type.name}" /></option>
                </c:forEach>
              </select>
            </div>
            <div class="form-group">
              <label for="ticket-message">Descrição:</label>
              <textarea id="ticket-message" class="form-control" rows="5" name="message" maxlength="255" oninput="charCounter(event, '#char-counter', 255)"></textarea>
              <small id="char-counter" class="form-text text-muted text-right">
                Caracteres digitados: 0/255
              </small>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-lg btn-primary w-25">
          <i class="fas fa-paper-plane"></i>
          Enviar
        </button>
      </form>
    </div>
  </main>

  {{-- Page footer --}}
  @footer()
  @endfooter

@endsection
