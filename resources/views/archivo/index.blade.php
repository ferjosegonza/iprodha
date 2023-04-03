@extends('layouts.app')

@section('content')  
    <section class="section">
        <div class="section-header">
            <div class="titulo page__heading">Búsqueda de Archivos Digitalizados</div>
            @include('layouts.favorito.fav', ['modo' => 'Agregar'])
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="barraBusqueda">
                    {!! Form::open(['method' => 'GET', 'route' => ['archivos.buscar']]]) !!}

                    {!! Form::label('Año:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}                    
                    @php $year = date("Y") @endphp
                    {!! Form::select('ano', for($i=1999; $i<=$year){$i;}, null, ['class' => 'form-select']) !!}
                                        
                    {!! Form::label('Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::select('idtipodocumento', $TipoDocumento, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}

                    {!! Form::label('Sub tipo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::select('idsubtipodocumento', $SubTipoDocumento, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                    
                    {!! Form::submit('Buscar', ['class' => 'btn btn-success']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection