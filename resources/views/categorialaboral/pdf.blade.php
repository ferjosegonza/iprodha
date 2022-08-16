<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categorias Laborales</title>
    
    <style>
        table {
             width: 100%;
            border: 1px solid #999;
            text-align: center;
            border-collapse: collapse;
            margin: 0 0 1em 0;
            caption-side: top;
        }
        caption, td, th {
        padding: 0.3em;
        }
        th, td {
        border-bottom: 1px solid #999;
        width: 25%;
        }
        caption {
        font-weight: bold;
        font-style: italic;
        }
        .page-break {
            page-break-after: always;
        }
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>    
  <div>
    <h1>Lista de Categorias</h1>
    <table>
        <thead>
            <tr>
              <th>Cat. Laboral</th>
              <th>WEB</th>
              <th>Suma Ingreso</th>
              <th>Datos lab.</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($categorialaboral as $categoria)
          <tr>
            <td>{{ $categoria->catlaboral }}</td>
            @if ($categoria->web == 1)
                <td>SI</td>
            @else
                <td>NO</td>
            @endif

            @if ($categoria->sumaingreso == 1)
                <td>SI</td>
            @else
                <td>NO</td>
            @endif

            @switch($categoria->datolab)
            @case(1)
                <td>SI</td>
            @break

            @case(3)
                <td>SIN OPCION</td>
            @break

            @default
                <td>NO</td>
            @endswitch
          </tr>
      @endforeach
        </tbody>
    </table>
</div>
   
    <!-- Centramos la paginacion a la derecha -->
    <div>
        {!! $categorialaboral->links() !!}
    </div>

    {{-- <h1>Page 1</h1>
    <div class="page-break"></div>
    <h1>Page 2</h1> --}}
</body>

</html>