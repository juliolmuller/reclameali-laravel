
@extends('layout.baseLayout')

@section('body')

  {{-- Page header --}}
  @header
  @endheader

  {{-- Page content --}}
  <main class="container c-main">
    <h1 class="mb-4">
      Bem-vind@, <strong>{{-- $currentUser->first_name --}}</strong>
    </h1>

    {{-- Display useful info/links to the user --}}
    <div class="mt-5">
      <div class="d-flex">
        <c:forEach var="f" items="${feed}">
          <div class="card border border-dark c-card">
            <div class="card-body text-center c-card-body">
              <p class="card-text display-2 text-${f.color}">
                ${f.icon}<strong>${f.main}</strong>
              </p>
              <p class="card-text h5 text-${f.color}">
                ${f.text}
              </p>
            </div>
            <a href="${baseUri}${f.link}" class="stretched-link h-0"></a>
          </div>
        </c:forEach>
      </div>
    </div>
  </main>

  {{-- Page footer --}}
  @footer()
  @endfooter

@endsection
