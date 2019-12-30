
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
    <c:choose>
      <c:when test="${error != null}">
        <div class="alert alert-danger text-center font-weight-bold" role="alert">
          Acesso indevido aos detalhes de atendimentos (<c:out value="${error}" />)
        </div>
        <p class="text-center">
          <i class="fas fa-sm fa-arrow-left"></i>
          <a href="${baseUri}/atendimentos">
            Voltar para atendimentos
          </a>
        </p>
      </c:when>
      <c:otherwise>
        <div>
          <div class="d-flex flex-wrap justify-content-between align-items-start">
            <div class="d-inline">
              <h2 class="mb-4">
                Atendimento #<fmt:formatNumber type="number" value="${ticket.id}" pattern="000000"/>
              </h2>
            </div>

            {{-- Button to create new ticket --}}
            <c:choose>
              <c:when test="${userCredentials.role == 'cliente' || ticket.closingDate != null}">
                <a href="${baseUri}/atendimentos" class="btn btn-default mt-1">
                  <i class="fas fa-arrow-left"></i>
                  Voltar
                </a>
              </c:when>
              <c:otherwise>
                <button type="button" class="btn btn-outline-primary mt-1" onclick="closeTicket('${pageContext.request.contextPath}/api/tickets?action=update&id=${ticket.id}')">
                  <i class="fas fa-check"></i>
                  Encerrar Atendimento
                </button>
              </c:otherwise>
            </c:choose>
          </div>

          {{-- Form to manage tickets --}}
          <div class="mt-3">
            <c:set var="id" value="${fn:escapeXml(ticket.id)}" />
            <input type="hidden" name="${id}" />
            <div class="row">
              <div class="col-6">
                <div class="form-group row">
                  <label for="ticket-id" class="col-6"># do atendimento:</label>
                  <div class="col-6">
                    <fmt:formatNumber type="number" value="${id}" pattern="000000"/>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="ticket-opening_date" class="col-6">Enviado em:</label>
                  <div class="col-6">
                    <span id="ticket-opening_date">
                      <t:printLocalDateTime value="${ticket.openingDate}" pattern="dd-MMM-yyyy HH:mm" />
                    </span>
                  </div>
                </div>
                <c:if test="${ticket.closingDate != null}">
                  <div class="form-group row">
                    <label for="ticket-closing_date" class="col-6">Fechado em:</label>
                    <div class="col-6">
                      <span id="ticket-closing_date">
                        <t:printLocalDateTime value="${ticket.closingDate}" pattern="dd-MMM-yyyy HH:mm" />
                      </span>
                    </div>
                  </div>
                </c:if>
              </div>
              <div class="col-6">
                <div class="form-group row">
                  <label for="ticket-type" class="col-6">Tipo de atendimento:</label>
                  <div class="col-6">
                    <span id="ticket-type">
                      <c:out value="${ticket.type.name}" />
                    </span>
                  </div>
                </div>
                <c:if test="${userCredentials.role != 'cliente'}">
                  <div class="form-group row">
                    <label for="ticket-customer" class="col-6">Cliente:</label>
                    <div class="col-6">
                      <span id="ticket-customer">
                        <fmt:formatNumber var="customerId" type="number" value="${ticket.openBy.id}" pattern="0000"/>
                        <c:out value="#${customerId} - ${ticket.openBy.firstName} ${fn:substring(ticket.openBy.lastName, 0, 1)}." />
                      </span>
                    </div>
                  </div>
                </c:if>
                <div class="form-group row">
                  <label for="ticket-product" class="col-6">Produto:</label>
                  <div class="col-6">
                    <span id="ticket-product">
                      <fmt:formatNumber var="productId" type="number" value="${ticket.product.id}" pattern="000000"/>
                      <c:out value="#${productId} - ${ticket.product.name}" />
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="ticket-messages" class="col-3">Histórico de mensagens:</label>
              <div class="col-9">
                <div class="border border-secondary rounded mx-2 p-2">
                  <div id="ticket-messages" class="row">
                    <c:forEach var="msg" items="${ticket.messages}">
                      <div class="c-message col-10 col-md-8 ${userCredentials == msg.sender ? 'ml' : 'mr'}-auto">
                        <div class="c-message-body rounded bg-${userCredentials == msg.sender ? 'primary' : 'secondary'}">
                          <div class="c-message-sender">
                            <c:if test="${msg.sender.role != 'cliente'}">
                              <i class="fas fa-user-check"></i>
                            </c:if>
                            <c:out value="${msg.sender.firstName} ${fn:substring(msg.sender.lastName, 0, 1)}." />
                          </div>
                          <p><c:out value="${msg.message}" /></p>
                          <div class="text-right c-message-time">
                            Enviada em
                            <t:printLocalDateTime value="${msg.sendDate}" pattern="dd-MMM-yyyy" />,
                            às <t:printLocalDateTime value="${msg.sendDate}" pattern="HH:mm" />
                          </div>
                        </div>
                      </div>
                    </c:forEach>
                  </div>
                </div>
                <c:if test="${ticket.closingDate == null}">
                  <div class="col-10 col-md-8 offset-2 offset-md-4 mt-2">
                    <form action="${pageContext.request.contextPath}/api/tickets?action=message&id=${ticket.id}" id="ticket-message-form">
                      <div class="input-group">
                        <textarea id="new-ticket-message" class="form-control border-secondary" rows="3" name="message" placeholder="Nova mensagem..." maxlength="255" oninput="charCounter(event, '#char-counter', 255)"></textarea>
                        <div class="input-group-append">
                          <button type="button" class="btn btn-primary" id="message-sender" disabled onclick="sendMessage()">
                            <i class="fas fa-paper-plane"></i>
                          </button>
                        </div>
                      </div>
                      <small id="char-counter" class="form-text text-muted text-right">
                        Caracteres digitados: 0/255
                      </small>
                    </form>
                  </div>
                </c:if>
              </div>
            </div>
          </div>
        </div>
      </c:otherwise>
    </c:choose>
  </main>

  {{-- Page footer --}}
  @footer()
  @endfooter

@endsection
