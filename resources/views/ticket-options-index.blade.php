
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
          Atendimentos
        </h1>
      </div>

      {{-- Button to create new ticket --}}
      <c:if test="${userCredentials.role == 'cliente'}">
        <a href="${baseUri}/atendimentos/novo" class="btn btn-primary mt-1">
          <i class="fa fa-plus"></i>
          Novo Atendimento
        </a>
      </c:if>
    </div>

    {{-- Filter for viewing tickets --}}
    <div class="mt-1">
      <div class="d-flex">
        <div class="form-inline ml-auto my-3">
          <div class="form-group">
            <label for="ticket-filter">
              <i class="fas fa-filter"></i>
              <span class="mx-2">Filtrar por</span>
            </label>
            <select id="ticket-filter" class="form-control">
              <option value="0">Todos</option>
              <option value="open">Abertos</option>
              <option value="closed">Fechados</option>
            </select>
          </div>
          <div class="form-group ml-4">
            <label for="ticket-sorter">
              <i class="fas fa-sort-amount-down-alt"></i>
              <span class="mx-2">Ordenar</span>
            </label>
            <select id="ticket-sorter" class="form-control">
              <option value="asc">do mais antigo para o mais novo</option>
              <option value="desc">do mais novo para o mais antigo</option>
            </select>
          </div>
        </div>
      </div>

      {{-- Table of tickets --}}
      <table id="ticket-table" class="table table-hover">
        <thead class="c-thead">
          <tr class="text-center">
            <th scope="col">#</th>
            <th scope="col">Produto</th>
            <th scope="col">Tipo</th>
            <th scope="col">Data de Criação</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr style="display:none;"><td colspan="6" class="h4 py-4">Nenhum atendimento.</td></tr>
          <c:forEach var="ticket" items="${tickets}">
            <c:url var="details" value="/${userCredentials.role}/atendimentos/acompanhar">
              <c:param name="id" value="${ticket.id}" />
            </c:url>
            <tr class="c-clickable" style="display:none;" data-href="${details}">
              <th scope="row" class="text-center">
                <fmt:formatNumber type="number" value="${ticket.id}" pattern="000000"/>
              </th>
              <td class="text-left">
                <c:out value="${ticket.product.name}" />
              </td>
              <td class="text-center">
                <c:out value="${ticket.type.name}" />
              </td>
              <td class="text-center">
                <t:printLocalDateTime value="${ticket.openingDate}" pattern="dd-MMM-yyyy HH:mm" />
              </td>
              <td class="text-center">
                <c:choose>
                  <c:when test="${ticket.status == 'ABERTO'}">
                    <span class="badge badge-sm badge-warning c-status">Aberto</span>
                  </c:when>
                  <c:when test="${ticket.status == 'FECHADO'}">
                    <span class="badge badge-sm badge-success c-status">Fechado</span>
                  </c:when>
                </c:choose>
              </td>
            </tr>
          </c:forEach>
        </tbody>
      </table>
    </div>
  </main>

  {{-- Page footer --}}
  @footer()
  @endfooter

@endsection
