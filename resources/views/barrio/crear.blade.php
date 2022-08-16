
@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta Barrios</h3>
        </div>
        <form method="post" action="{{ route('barrio.store') }}">
            <div class="card-body">    

            @include('layouts.modal.mensajes')
            </div>

            @csrf
            @method('POST')
            <div style="width:99%;float:left;">
                <div style="width:30%;float:left;margin-left:1%;">
                    {!! Form::label('Nombre:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::text('nombarrio', old('nombarrio'), ['type'=>'text','class' => 'form-control','placeholder'=>'']) !!}
                </div>
                <div style="width:30%;float:left;margin-left:1%;">
                    {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::select('empresa', ['1' => 'SI', '0' => 'NO'], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                </div>
                <div style="width:30%;float:left;margin-left:1%;">
                    {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::select('web', ['1' => 'SI', '0' => 'NO'], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                </div>

            </div>
            <!--div class="form-group d-flex align-items-center ">

            </div-->
            <!--div class="form-group d-flex align-items-left" style="width:95%;float:left;"-->
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:20%;float:left;margin-left:1%;">
                    {!! Form::label('Es uvi:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;margin-left:1%;']) !!}
                    {{ Form::radio('uvi', 'Si', true,['style' => 'white-space: nowrap;']) }} <span>Si</span>
                    {{ Form::radio('uvi', 'No',false,['style' => 'white-space: nowrap;']) }} <span>No</span>
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!! Form::label('Factura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {{ Form::radio('factura', 'Si', true,['style' => 'white-space: nowrap;']) }} <span>Si</span>
                    {{ Form::radio('factura', 'No',false,['style' => 'white-space: nowrap;']) }} <span>No</span>
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                    {!! Form::select('obra', ['1' => 'SI', '0' => 'NO'], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!! Form::label('Fec.Entrega:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:10%; ']) !!}
                    {!! Form::text('fec_entrega', old('fec_entrega'), ['type'=>'text','class' => 'form-control','placeholder'=>'']) !!}
                </div>
            </div>
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:20%;float:left;margin-left:1%;">
                    {!! Form::label('Zona:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::select('zonaBarrio', ['1' => 'SI', '0' => 'NO'], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!! Form::label('Programa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::select('programaBarrio', ['1' => 'SI', '0' => 'NO'], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!! Form::label('Tipo Barrio:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::select('tipoBarrio', ['1' => 'SI', '0' => 'NO'], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!! Form::label('Tipología:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::select('tipologiaBarrio', ['1' => 'SI', '0' => 'NO'], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                </div>
                <div style="width:10%;float:left;margin-left:1%;">
                    {!! Form::label('Tipo de Precio:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::select('tipoPrecioBarrio', ['1' => 'SI', '0' => 'NO'], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                </div>                
            </div>            
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:10%;float:left;margin-left:1%;">
                    {!! Form::label('Cta.Bano:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::text('ctaBancoBarrio', old('nombarrio'), ['type'=>'text','class' => 'form-control','placeholder'=>'10384']) !!}
                </div>                
                <div style="width:10%;float:left;margin-left:1%;">
                    {!! Form::label('Porc.Finan:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::text('porceFinanBarrio', old('nombarrio'), ['type'=>'text','class' => 'form-control','placeholder'=>'']) !!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!! Form::label('Cant. Viv.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::text('cantVivBarrio', old('nombarrio'), ['type'=>'text','class' => 'form-control','placeholder'=>'']) !!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!! Form::label('Nro. Resol:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::text('nroResolBarrio', old('nombarrio'), ['type'=>'text','class' => 'form-control','placeholder'=>'']) !!}
                </div>

            </div>


            @can('CREAR-BARRIO')
            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
            @endcan

        </div>


        </form>
    </section>
@endsection
