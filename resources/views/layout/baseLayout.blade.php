<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="author" content="Julio L. Muller" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
      BEIBE :: Reclame Ali - Serviço de Atendimento ao Cliente
    </title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @yield('style')
  </head>
  <body>
    @yield('body')

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
  </body>
</html>
