
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
          Cadastro de Colaboradores
        </h1>
      </div>

      {{-- Button to create new employee --}}
      <button type="button" class="btn btn-primary mt-1" onclick="createUser()">
        <i class="fa fa-plus"></i>
        Novo Colaborador
      </button>
    </div>

    {{-- Table of employees --}}
    <div class="mt-3">
      <table id="user-table" class="table table-hover">
        <thead class="c-thead">
          <tr class="text-center">
            <th scope="col">CPF</th>
            <th scope="col">Nome Completo</th>
            <th scope="col">Nascido em</th>
            <th scope="col">Telefone</th>
            <th scope="col">Gerente</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <c:choose>
            <c:when test="${empty users}">
              <tr><td colspan="6" class="h4 py-4">Nenhum colaborador cadastrado.</td></tr>
            </c:when>
            <c:otherwise>
              <c:forEach var="user" items="${users}">
                <tr>
                  <th scope="row" class="text-center">
                    <t:printCpf value="${user.cpf}" />
                  </th>
                  <td class="text-left">
                    <c:out value="${user.firstName} ${user.lastName}" />
                  </td>
                  <td class="text-center">
                    <fmt:setLocale value="pt_BR"/>
                    <fmt:parseDate value="${user.dateBirth}" pattern="yyyy-MM-dd" var="parsedDate" type="date"/>
                    <fmt:formatDate value="${parsedDate}" type="date" pattern="dd-MMM-yyyy" />
                  </td>
                  <td class="text-center">
                    <t:printPhoneNumber value="${user.phone}" />
                  </td>
                  <td class="text-center">
                    <c:if test="${user.role == 'gerente'}">
                      <i class="fas fa-user-check"></i>
                    </c:if>
                  </td>
                  <td class="text-right">
                    <button type="button" class="btn btn-sm btn-info" title="Editar dados" onclick="editUser(<c:out value="${user.id}" />)"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-warning" title="Alterar senha" onclick="editPassword(<c:out value="${user.id}" />)"><i class="fas fa-unlock-alt"></i></button>
                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="deleteUser(<c:out value="${user.id}" />, event)"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              </c:forEach>
            </c:otherwise>
          </c:choose>
        </tbody>
      </table>
    </div>

    {{-- Form to update passwords --}}
    <div id="password-modal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form action="${pageContext.request.contextPath}/api/users?action=password" id="password-form" class="modal-content" novalidate>
          <div class="modal-header">
            <h2 class="modal-title"></h2>
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" value="" />
            <div class="row">
              <div class="col-12 form-group">
                <label for="user-password">Senha atual:</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-unlock-alt"></i>
                    </span>
                  </div>
                  <input type="password" id="user-password" class="form-control" name="password" placeholder="Informe a sua senha atual" />
                </div>
              </div>
              <div class="col-12 form-group">
                <label for="user-password1">Nova senha:</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-unlock-alt"></i>
                    </span>
                  </div>
                  <input type="password" id="user-password1" class="form-control" name="password1" placeholder="Nova senha (entre 6 e 32 caracteres)" />
                </div>
              </div>
              <div class="col-12 form-group">
                <label for="user-password2">Repetir nova senha:</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-unlock-alt"></i>
                    </span>
                  </div>
                  <input type="password" id="user-password2" class="form-control" name="password2" placeholder="Repita a nova senha" />
                </div>
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

    {{-- {Form to manage users} --}}
    <div id="user-modal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <form action="${pageContext.request.contextPath}/api/users" id="user-form" class="modal-content" novalidate>
          <div class="modal-header">
            <h2 class="modal-title"></h2>
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" value="" />
            <div class="form-group row">
              <label for="user-role" class="col-sm-4 col-form-label">Tipo de cadastro:</label>
              <div id="user-role" class="col-sm-8 mt-2">
                <div class="form-check form-check-inline">
                  <input type="radio" id="user-role-funcionario" class="form-check-input" name="role" value="funcionario">
                  <label for="user-role-funcionario" class="form-check-label">Funcionário</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" id="user-role-gerente" class="form-check-input" name="role" value="gerente">
                  <label for="user-role-gerente" class="form-check-label">Gerente</label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="user-first_name" class="col-sm-4 col-form-label">Nome:</label>
              <div class="col-sm-8">
                <input type="text" id="user-first_name" class="form-control" name="first_name" placeholder="Nome do usuário" autocapitalize="words" />
              </div>
            </div>
            <div class="form-group row">
              <label for="user-last_name" class="col-sm-4 col-form-label">Sobrenome:</label>
              <div class="col-sm-8">
                <input type="text" id="user-last_name" class="form-control" name="last_name" placeholder="Sobrenome do usuário" autocapitalize="words" />
              </div>
            </div>
            <div class="form-group row">
              <label for="user-cpf" class="col-sm-4 col-form-label">CPF:</label>
              <div class="input-group col-sm-8">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fab fa-slack-hash"></i>
                  </span>
                </div>
                <input type="text" id="user-cpf" class="form-control" name="cpf" placeholder="CPF (apenas números)" />
              </div>
            </div>
            <div class="form-group row">
              <label for="user-date_birth" class="col-sm-4 col-form-label">Data de nascimento:</label>
              <div class="input-group col-sm-8">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                </div>
                <input type="text" id="user-date_birth" class="form-control" name="date_birth" placeholder="dd/mm/aaaa" readonly />
              </div>
            </div>
            <div class="form-group row">
              <label for="user-email" class="col-sm-4 col-form-label">Email do usuário:</label>
              <div class="input-group col-sm-8">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-at"></i>
                  </span>
                </div>
                <input type="text" id="user-email" class="form-control" name="email" placeholder="Email para acesso ao sistema" />
              </div>
            </div>
            <div class="form-group row">
              <label for="user-phone" class="col-sm-4 col-form-label">Telefone de contato:</label>
              <div class="input-group col-sm-8">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-mobile-alt"></i>
                  </span>
                </div>
                <input type="text" id="user-phone" class="form-control" name="phone" placeholder="Telefone com DDD (apenas números)" />
              </div>
            </div>
            <div class="form-group row">
              <label for="user-zip_code" class="col-sm-4 col-form-label">CEP da residência:</label>
              <div class="input-group col-sm-8">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="text" id="user-zip_code" class="form-control" name="zip_code" placeholder="CEP (apenas números)" />
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" type="button" id="find-zip_code">
                    Buscar CEP
                  </button>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="user-street" class="col-sm-4 col-form-label">Rua:</label>
              <div class="input-group col-sm-8">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" id="user-street" class="form-control" name="street" placeholder="Rua, avenida, alameda..." />
              </div>
            </div>
            <div class="form-group row">
              <label for="user-number" class="col-sm-4 col-form-label">Número e complemento:</label>
              <div class="input-group col-sm-8">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map-marked-alt"></i>
                  </span>
                </div>
                <input type="text" id="user-number" class="form-control" name="number" placeholder="Número" />
                <input type="text" id="user-complement" class="form-control" name="complement" placeholder="Complemento (opcional)" />
              </div>
            </div>
            <div class="form-group row">
              <label for="user-city" class="col-sm-4 col-form-label">Cidade e estado:</label>
              <div class="input-group col-sm-8">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-globe-americas"></i>
                  </span>
                </div>
                <input type="text" id="user-city" class="form-control" name="city" placeholder="Cidade" />
                <select id="user-state" class="form-control" name="state">
                  <option value="">Estado</option>
                  <c:forEach var="state" items="${states}">
                    <option value="${state.id}">
                      <c:out value="${state.abrev}" /> - <c:out value="${state.name}" />
                    </option>
                  </c:forEach>
                </select>
              </div>
            </div>
            <div id="password-creation">
              <div class="form-group row">
                <label for="user-password1" class="col-sm-4 col-form-label">Senha de acesso:</label>
                <div class="input-group col-sm-8">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-unlock-alt"></i>
                    </span>
                  </div>
                  <input type="password" id="user-password1" class="form-control" name="password1" placeholder="Defina uma senha entre 6 e 32 caracteres" />
                </div>
              </div>
              <div class="form-group row">
                <label for="user-password2" class="col-sm-4 col-form-label">Repetir senha:</label>
                <div class="input-group col-sm-8">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-unlock-alt"></i>
                    </span>
                  </div>
                  <input type="password" id="user-password2" class="form-control" name="password2" placeholder="Deve ser igual à senha de acesso" />
                </div>
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

  {{-- Page footer --}}
  @footer()
  @endfooter

@endsection
