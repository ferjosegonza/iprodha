<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        table {
            border: 2px solid #333333;
            width: 100%;
        }

        td {
            padding: 5px;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }

        body {
            font-family: Serif, Symbol, Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <div>
        <h1>Lista de Usuarios</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>E-mail</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                </tr>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>
                            @if (!empty($usuario->getRoleNames()))
                                @foreach ($usuario->getRoleNames() as $rolNombre)
                                    {{ $rolNombre }}
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Centramos la paginacion a la derecha -->
    <div>
        {!! $usuarios->links() !!}
    </div>

    <h1>Page 1</h1>
    <div class="page-break"></div>
    <h1>Page 2</h1>
</body>

</html>
