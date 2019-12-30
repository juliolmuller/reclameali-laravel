
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
    <h2 class="mb-4">
      Relatórios
    </h2>
    <div class="row mt-5">
      <div class="col-12 col-md-10">
        <label for="employees-report h4">
          Relatório com dados dos empregados:
        </label>
      </div>
      <div class="col-12 col-md-2">
        <a href="${pageContext.request.contextPath}/relatorio?action=empl" id="employees-report" class="btn btn-outline-primary d-block">
          <i class="fas fa-newspaper"></i>
          Gerar
        </a>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-12 col-md-10">
        <label for="products-report h4">
          Top 3 produtos mais reclamados:
        </label>
      </div>
      <div class="col-12 col-md-2">
        <a href="${pageContext.request.contextPath}/relatorio?action=top" id="products-report" class="btn btn-outline-primary d-block">
          <i class="fas fa-newspaper"></i>
          Gerar
        </a>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <label for="h4" id="tickets-report-1">Relatório de atendimentos:</label>
        <form action="${pageContext.request.contextPath}/relatorio?action=recl" method="POST" id="tickets-report-1">
          <div class="row">
            <div class="col-12 col-md-10">
              <div class="form-check form-check-inline">
                <input type="radio" id="ticket-report-all" class="form-check-input" name="tStatus" value="todos" checked/>
                <label for="ticket-report-all" class="form-check-label my-1 mr-3" style="font-weight:unset;">Todos</label>
                <input type="radio" id="ticket-report-open" class="form-check-input" name="tStatus" value="abertos" />
                <label for="ticket-report-open" class="form-check-label my-1 mr-3" style="font-weight:unset;">Abertos</label>
                <input type="radio" id="ticket-report-closed" class="form-check-input" name="tStatus" value="fechados" />
                <label for="ticket-report-closed" class="form-check-label my-1 mr-3" style="font-weight:unset;">Fechados</label>
              </div>
            </div>
            <div class="col-12 col-md-2">
              <button type="submit" class="btn btn-outline-primary w-100">
                <i class="fas fa-newspaper"></i>
                Gerar
              </button>
            </div>
            <div class="col-12 form-group" style="margin-top:-10px;">
              <small class="form-text text-muted">Selecione o status do atendimento</small>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <label for="h4" id="tickets-report-2">Atendimentos em determinado período:</label>
        <form action="${pageContext.request.contextPath}/relatorio?action=tickts" method="POST" id="tickets-report-2" onsubmit="generateReport2(event)">
          <div class="row">
            <div class="col-12 col-md-10 form-inline">
              <label for="tickets-report-from" class="my-1 mr-2" style="font-weight:unset;">de</label>
              <input type="date" id="tickets-report-from" class="form-control mb-2 mr-sm-2" name="dataIni" required />
              <label for="tickets-report-to" class="my-1 mr-2" style="font-weight:unset;">até</label>
              <input type="date" id="tickets-report-to" class="form-control mb-2 mr-sm-2" name="dataFim" required />
            </div>
            <div class="col-12 col-md-2">
              <button type="submit" class="btn btn-outline-primary w-100">
                <i class="fas fa-newspaper"></i>
                Gerar
              </button>
            </div>
            <div class="col-12 form-group" style="margin-top:-10px;">
              <small class="form-text text-muted">Selecione o período de criação de atendimento</small>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>

  {{-- Rodapé da página --}}
  @footer()
  @endfooter

@endsection
