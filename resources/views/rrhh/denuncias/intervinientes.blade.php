@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
    </head>
    <section class="section">
        <div class="section-header d-flex justify-content-between">
            <h4 class="page__heading">Denuncia</h4>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group min-height-20" style="margin-bottom: 35px">
                                <h4>Datos de la Denuncia</h4>
                                <div>Fecha: <b>{{$denuncia->fecha ? \Carbon\Carbon::parse($denuncia->fecha)->format('d-m-Y') : 'No hay fecha cargada.' }}</b></div>
                                <div>Extracto: <b>{{$denuncia->extracto ?? 'No hay extracto cargado.'}}</b></div>
                                <div>Descripción: <b>{{$denuncia->descripcion ?? 'No hay descripción cargada.'}}</b></div>
                            </div>
                            <div class="row">
                                <h4>En relación a la Denuncia. Denunciante, Denunciado y Víctima:</h4>
                                <div class="form-group" style="margin-top: 12px;">
                                    <h5>Datos del Denunciante</h5>
                                    @if ($denunciante)
                                        <div>Apellido y Nombre: <b>{{ $denunciante->apellido }} {{ $denunciante['nombre'] }}</b></div>
                                        <div>Tipo de Documento y Número: <b>{{ $denunciante->tipoDni->des_abr }} ({{ $denunciante->tipoDni->destipdoc }}) {{ number_format($denunciante['nro_doc'], 0, ',', '.') }}</b></div>
                                        <div>Sexo: <b>{{ $denunciante->sexo->descsexo ?? $denunciante->id_sexo }}</b></div>
                                        <div>Fecha de Nacimiento: <b>{{ \Carbon\Carbon::parse($denunciante['fecha_nac'])->format('d-m-Y') }}</b></div>
                                        <div>Domicilio: <b>{{ $denunciante['domicilio'] }}</b></div>
                                        <div>Mail: <b>{{ $denunciante['mail'] }}</b></div>
                                        <div>Teléfono: <b>{{ $denunciante['telefono'] }}</b></div>
                                        <div>Vínculo con la Institución: <b>{{ $denunciante->vinculo->descripcion ?? 'Información no encontrada' }}</b></div>
                                        <div>¿El Denunciante es también la Víctima?: <b>{{ $denunciante['es_victima'] ? 'Si':'No' }}</b></div>
                                    @else
                                        <div>No hay datos cargados del denunciante</div>
                                    @endif
                                </div>
    
                                <div class="form-group">
                                    <h5>Datos del Denunciado</h5>
                                    @if ($denunciado)
                                        <div>Apellido y Nombre: <b>{{ $denunciado['apellido'] }} {{ $denunciado['nombre'] }}</b></div>
                                        <div>Tipo de Documento y Número: <b>{{ $denunciado->tipoDni->des_abr }} ({{ $denunciado->tipoDni->destipdoc }}) {{ number_format($denunciado['nro_doc'], 0, ',', '.') }}</b></div>
                                        <div>Sexo: <b>{{ $denunciado->sexo->descsexo ?? 'Información no encontrada' }}</b></div>
                                        <div>Fecha de Nacimiento: <b>{{ \Carbon\Carbon::parse($denunciado['fecha_nac'])->format('d-m-Y') }}</b></div>
                                        <div>Domicilio: <b>{{ $denunciado['domicilio'] }}</b></div>
                                        <div>Mail: <b>{{ $denunciado['mail'] }}</b></div>
                                        <div>Teléfono: <b>{{ $denunciado['telefono'] }}</b></div>
                                        <div>Vínculo con la Institución: <b>{{ $denunciado->vinculo->descripcion ?? 'Información no encontrada' }}</b></div>
                                        <div>Vínculo con la Víctima: <b>{{ $denunciado['vinculo_vict'] }}</b></div>
                                    @else
                                        <div>No hay datos cargados del denunciado</div>
                                    @endif
                                </div>
    
                                <div class="form-group">
                                    <h5>Datos de la Víctima</h5>
                                    @if ($victima)
                                        @if ($denunciante['es_victima'])
                                            <div><b><i>La víctima y el denunciante son la misma persona.</i></b></div>
                                        @endif
                                        <div>Apellido y Nombre: <b>{{ $victima['apellido'] }} {{ $victima['nombre'] }}</b></div>
                                        <div>Tipo de Documento y Número: <b>{{ $victima->tipoDni->des_abr }} ({{ $victima->tipoDni->destipdoc }}) {{ number_format($victima['nro_doc'], 0, ',', '.') }}</b></div>
                                        <div>Sexo: <b>{{ $victima->sexo->descsexo ?? 'Información no encontrada' }}</b></div>
                                        <div>Fecha de Nacimiento: <b>{{ \Carbon\Carbon::parse($victima['fecha_nac'])->format('d-m-Y') }}</b></div>
                                        <div>Domicilio: <b>{{ $victima['domicilio'] }}</b></div>
                                        <div>Mail: <b>{{ $victima['mail'] }}</b></div>
                                        <div>Teléfono: <b>{{ $victima['telefono'] }}</b></div>
                                        <div>Vínculo con la Institución: <b>{{ $victima->vinculo->descripcion ?? 'Información no encontrada' }}</b></div>
                                    @else
                                        <div>No hay datos cargados de la víctima</div>
                                    @endif
                                </div>
    
                            </div>
                        </div>

                        <div class="section-header d-flex">
                            <h5>Gestionar Denunciado, Denunciante y Víctima relacionadas a la Denuncia:</h5>
                            <div class="gropo-botones d-flex">
                                <div class="btn-group m-1">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        DENUNCIANTE
                                    </button>
                                    <div class="dropdown-menu">
                                        @php
                                            $denuncianteVacio = empty($denuncia->denunciante) ? true : false;
                                        @endphp
                                        @if ($denuncianteVacio)
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.denunciante.crear', $denuncia->id_denuncia],
                                                /*'style' => 'display:inline',
                                                'class' => 'd-flex justify-content-evenly'*/
                                                ]) !!}
                                                {!! Form::submit('Agregar Nuevo', ['class' => 'formulario dropdown-item btn btn-success my-1']) !!}
                                            {!! Form::close() !!}
                                        @else
                                            {{-- {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.denunciante.ver', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Ver', ['class' => 'formulario dropdown-item btn btn-info']) !!}
                                            {!! Form::close() !!} --}}
                                
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.denunciante.modificar', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Modificar', ['class' => 'formulario dropdown-item btn btn-warning']) !!}
                                            {!! Form::close() !!}
                                
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'class' => 'formulario',
                                                'route' => ['rrhh.denuncias.denunciante.borrar', $denuncia->id_denuncia],
                                                'style' => 'display:inline'])!!}
                                                {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="btn-group m-1">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        DENUNCIADO
                                    </button>
                                    <div class="dropdown-menu">
                                        @php
                                            $denunciadoVacio = empty($denuncia->denunciado) ? true : false;
                                        @endphp
                                        @if ($denunciadoVacio)
                                            {!! Form::open(['method' => 'GET', 'route' => ['rrhh.denuncias.denunciado.crear'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Agregar Nuevo', ['class' => 'formulario dropdown-item btn btn-success my-1']) !!}
                                            {!! Form::close() !!}
                                        @else
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.denunciado.ver', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Ver', ['class' => 'formulario dropdown-item btn btn-info']) !!}
                                            {!! Form::close() !!}
                                
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.denunciado.modificar', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Modificar', ['class' => 'formulario dropdown-item btn btn-warning']) !!}
                                            {!! Form::close() !!}
                                
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'class' => 'formulario',
                                                'route' => ['rrhh.denuncias.denunciado.borrar', $denuncia->id_denuncia],
                                                'style' => 'display:inline'])!!}
                                                {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="btn-group m-1">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        VÍCTIMA
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- @php
                                            $denunciadoVacio =  ? true : false;
                                        @endphp --}}
                                        @if (empty($denuncia->victima))
                                            {!! Form::open(['method' => 'GET', 'route' => ['rrhh.denuncias.victima.crear'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Agregar Nuevo', ['class' => 'formulario dropdown-item btn btn-success my-1']) !!}
                                            {!! Form::close() !!}
                                        @else
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.victima.ver', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Ver', ['class' => 'formulario dropdown-item btn btn-info']) !!}
                                            {!! Form::close() !!}
                                
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.victima.modificar', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Modificar', ['class' => 'formulario dropdown-item btn btn-warning']) !!}
                                            {!! Form::close() !!}
                                
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'class' => 'formulario',
                                                'route' => ['rrhh.denuncias.victima.borrar', $denuncia->id_denuncia],
                                                'style' => 'display:inline'])!!}
                                                {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            {!! link_to_route('rrhh.denuncias.listar',$title = 'Volver',$parameters = [],$attributes = ['class' => 'btn btn-secondary fo']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection