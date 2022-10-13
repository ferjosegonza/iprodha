@extends('layouts.app')

@section('content')

<section class="section">
<div> <h1> Conceptos a Certificar </h1></div>
    <div >

    <table class="table table-hover mt-2">
        <thead style="background-color:#6777ef">                                     
            <th scope="col" style="color:#fff;">ID CONCEPTO</th>
            <th scope="col" style="color:#fff;">DESCRIPCION</th>
            <th scope="col" style="color:#fff;">SUMA O RESTA</th>   
            <th scope="col" style="color:#fff;">ORDEN</th>                                        
            <th scope="col" style="color:#fff;">ACCIONES</th>                                                                   
        </thead>
        <tbody>                                
            @foreach ($vConceptos as $vConcepto)
                <tr>
                    <td>{{ $vConcepto->id_concepto }}</td>
                    <td>{{ $vConcepto->descripcion }}</td>
                    <td>{{ $vConcepto->signo }}</td>
                    <td>{{ $vConcepto->orden_pie }}</td>
                    <td><a class="btn btn-info" href="{{ route('ob_concepto.editar',$vConcepto->id_concepto) }}">Editar</a></td>
                </tr>
            @endforeach 
        </tbody>
    </table>
    </div>


    {{-- --------------------------------------------------------------------- --}}
   {{-- {{
    {{ Form::open()}}

    {!! Form::text('nombre', null, ['placeholder' => 'Buscar por Nombre', 'class' => 'form-control  ']) !!}
    {!! Form::checkbox('chech1','value',false) !!}
    {!! Form::radio('radio1','value',true) !!}
    {!! Form::number('numero1','value') !!}    
    {!! Form::select('sumaoresta', array('S' => 'Suma', 'R' => 'Resta', 'N' => 'Neutro')) !!}
    {!! Form::select('sumaoresta', array('S' => 'Suma', 'R' => 'Resta', 'N' => 'Neutro'),'R') !!}
    {!! Form::select('desdeBD', $vConceptos->pluck('descripcion'), $vConceptos->pluck('id_concepto')
     ,['placeholder' => 'Seleccionar', 'class' => 'form-select','onClick' => 'show1();']) !!}
    {!! Form::selectMonth('month') !!} 
    {!! Form::selectRange('numer_2',2000,2025) !!}
    
     $vConceptos->id_concepto 

    
         
    @foreach ($vConceptos as $vConcepto)
    {{ Form::open()}}
        {!! Form::text('nombre',$vConcepto->id_concepto, ) !!}
        {!! Form::text('con',$vConcepto['descripcion'] ) !!}
        
    {{ Form::close() }}            
    @endforeach

     -- botones
     {!! Form::submit('Buscar') !!} 

     {{ Form::close() }}

    }} --}}
    

</section>
   
  
@endsection