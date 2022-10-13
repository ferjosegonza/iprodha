@extends('layouts.app')

@section('content')
<style>
    .desvanecer:hover {
        opacity: 0.3;
        -webkit-transition: opacity 500ms;
        -moz-transition: opacity 500ms;
        -o-transition: opacity 500ms;
        -ms-transition: opacity 500ms;
        transition: opacity 500ms;
    }

    .mostrar{
        opacity: 0.1;
    }
    .mostrar:hover {
        opacity: 0.6;
        -webkit-transition: opacity 500ms;
        -moz-transition: opacity 500ms;
        -o-transition: opacity 500ms;
        -ms-transition: opacity 500ms;
        transition: opacity 500ms;
    }

</style>
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Ticket</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">         

                    {!! Form::open(array('route' => 'ticket.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Categoria:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                    <select class="form-select" name="categ" placeholder="Seleccionar" id='selected-categoria' required>
                                        <option disabled selected>Seleccionar</option>
                                        @foreach ($Categorias as $Categoria)
                                            <option value={{"$Categoria->idcatprob"}}>{{$Categoria->descatprob}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Sub-categoria:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                    <select class="form-select" name="subcateg" placeholder="Seleccionar" id='selected-subcategoria' required>
                                        <option disabled selected>Seleccionar</option>
                                    </select>
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('N° de interno:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::number('interno', null, array('class' => 'form-control', 'type' => 'number', 'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'maxlength' => '3', 'required')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Descripcion del requerimiento:</label>
                                    {!! Form::textarea('descrip', null, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh', 'required']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Imagen: </label>
                                    {!! Form::file('image', array('class' => 'form-control', 'type' => 'file', 'id' => "inputGroupFile03", 'aria-describedby' => 'inputGroupFileAddon03', 'aria-label' => 'Upload')) !!}
                                    <div class="div-padre mt-2" style="height: 350px; position: relative; background-color: #fff">
                                            <div class="hijo2" style="height: 350px; width:100%;position: absolute;">
                                                <img id="imagenpre" style="height: inherit; width: 100%;">
                                            </div>
                                            <a id='imageurl' target='_blank' style="text-decoration: none; color: #9c9b98">
                                                <div class="hijo1 d-flex mostrar" style="height: 350px; width:100%;; position: absolute;">
                                                    <i class="fas fa-search-plus m-auto" style="font-size: 8em"></i>
                                                </div>
                                            </a>
                                    </div>
                                </div>  
                                {{-- <div class="form-group">
                                    <label for="">Adjuntar imagen: </label>
                                    {!! Form::file('image', array('class' => 'form-control', 'type' => 'file', 'id' => "inputGroupFile03", 'aria-describedby' => 'inputGroupFileAddon03', 'aria-label' => 'Upload')) !!}
                                </div> --}}
                                
                            </div>       
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Enviar</button>
                        <a href="{{ route('ticket.index') }}"class="btn btn-secondary fo">Volver</a>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Coordinacion/Informatica/ticket/index_ticket.js') }}"></script>
    <script src="{{ asset('js/Coordinacion/Informatica/ticket/editar_ticket.js') }}"></script>
</section>
@endsection