
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">





<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <h2>View "views/zsintaxis/LaravelCollective.blade.php"</h2>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-start align-items-center my-5">
        <div class="col-xs-12 col-sm-10 col-md-6 col-lg-2 ">
            <div class="row ">
                <a href="{{ route('inicio') }}" class="btn btn-success w-100" style="font-size:2em;text-decoration:none;">Volver</a>
            </div>
        </div>
    </div>
</div>


<div class="container mt-5 mb-2">
    <h2>Para Crear - GET</h2>

    <div class="row">
        <div class="col-md-6 ">
            {!! Form::open(['method' => 'GET', 'route' => ['alumnos.create'], 'class' => 'justify-content-evenly']) !!}
                
                {!! Form::button('Nuevo', ['class' => 'btn btn-warning']) !!}
                {{-- {!! Form::submit('Nuevo', ['class' => 'ms-5 btn btn-warning']) !!} --}}
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        {\!! Form::open(['method' => 'GET', 'route' => ['alumnos.create'], 'class' => 'justify-content-evenly'])  !!}
        <br>                                  
        {\!! Form::submit('Nuevo', ['class' => 'btn btn-warning']) !!}                                 
        <br>
        {\!! Form::close() !!}  
    </div>
</div> 


@php
    $alumno['nombre']='Diego';
    $alumno['apellido']='zitelli';
    $alumno['id']=23;
@endphp

<div class="container mt-5 mb-2">
    <h2>Para Editar - GET</h2>

    <div class="row">
        <div class="col-md-6 ">
            {!! Form::open(['method' => 'GET','route' => ['alumnos.edit', $alumno['id']],'style' => 'display:inline']) !!}
                {!! Form::button('Editar', ['class' => 'btn btn-primary']) !!}
                {{-- {!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!} --}}
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        {\!! Form::open(['method' => 'GET','route' => ['alumnos.edit', $alumno->dni],'style' => 'display:inline'])  !!}
        <br>                                  
        {\!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!}                                 
        <br>
        {\!! Form::close() !!}  
    </div>
</div> 




<div class="container mt-5 mb-2">
    <h2>Para Borrar - DELETE</h2>

    <div class="row">
        <div class="col-md-6 ">
            {!! Form::open(['method' => 'DELETE','class' => 'formulario','route' => ['alumnos.destroy', $alumno['id']],'style' => 'display:inline']) !!}
                {!! Form::button('Borrar', ['class' => 'btn btn-danger']) !!}
                {{-- {!! Form::submit('Editar', ['class' => 'btn btn-danger']) !!} --}}
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        {\!! Form::open(['method' => 'DELETE','class' => 'formulario','route' => ['alumnos.destroy', $alumno->dni],'style' => 'display:inline'])  !!}
        <br>                                  
        {\!! Form::submit('Editar', ['class' => 'btn btn-danger']) !!}                                 
        <br>
        {\!! Form::close() !!}  
    </div>
</div> 




<div class="container mt-5 mb-2">
    <h2>Para Crear - POST</h2>

    <div class="row">
        <div class="col-md-6 ">
            {!! Form::open(['method' => 'POST','route' => 'alumnos.store', 'class' => 'd-flex formulario']) !!}
                {!! Form::text('nombre', null, ['placeholder' => 'Ingrese su Nombre', 'class' => 'form-control  ']) !!}
                {!! Form::text('apellido', null, ['placeholder' => 'Ingrese su Apellido', 'class' => 'form-control  ']) !!}

                {!! Form::button('Crear', ['class' => 'ms-5 btn btn-warning']) !!}
                {{-- {!! Form::submit('Crear', ['class' => 'ms-5 btn btn-warning']) !!} --}}
        {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        {\!! Form::open(['method' => 'POST','route' => 'alumnos.store', 'class' => 'formulario'])  !!}
        <br>                                  
        {\!! Form::text('nombre', null, ['placeholder' => 'Ingrese su Nombre', 'class' => 'form-control  ']) !!}                                 
        <br>                               
        {\!! Form::text('apellido', null, ['placeholder' => 'Ingrese su Apellido', 'class' => 'form-control  ']) !!}                                 
        <br>                             
        {\!! Form::submit('Crear', ['class' => 'ms-5 btn btn-warning']) !!}                                 
        <br>
        {\!! Form::close() !!}  
    </div>
</div> 

@php
    $alumno['nombre']='Diego';
    $alumno['apellido']='zitelli';
    $alumno['id']=23;
@endphp

<div class="container mt-5 mb-2">
    <div class="row">
        <div class="col-md-6">
            <h2>Para Modificar - PUT</h2>

            {!! Form::model($alumno,['method' => 'PUT', 'route' => ['alumnos.update',$alumno['id']], 'class' => 'd-flex justify-content-start']) !!}
    
                {!! Form::text('nombre', null, ['placeholder' => 'Ingrese su Nombre', 'class' => 'form-control  ']) !!}
                {!! Form::text('apellido', null, ['placeholder' => 'Ingrese su Apellido', 'class' => 'form-control  ']) !!}

                {!! Form::button('Editar', ['class' => 'ms-5 btn btn-success']) !!}
                {{-- {!! Form::submit('Editar', ['class' => 'ms-5 btn btn-warning']) !!} --}}

            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="container mb-5">
    <div class="row">

        {\!! Form::model($alumno,['method' => 'PUT', 'route' => ['alumnos.update',$alumno->id], 'class' => 'd-flex justify-content-start'])  !!}
        <br>                                  
        {\!! Form::text('nombre', null, ['placeholder' => 'Ingrese su Nombre', 'class' => 'form-control  ']) !!}                  
        <br>                
        {\!! Form::text('apellido', null, ['placeholder' => 'Ingrese su Apellido', 'class' => 'form-control  ']) !!}              
        <br>                    
        {\!! Form::submit('Editar', ['class' => 'ms-5 btn btn-success']) !!}                                  
        <br>
        {\!! Form::close() !!}  
    </div>
</div>                                
 


<div class="container my-5">
    <div class="row border border-5 border-dark mb-5"></div>


    {!! Form::label('local','Localidades:', ['class' => 'control-label me-2', 'style' => 'width:100%']) !!}
    <br>
       {\!! Form::label('local','Localidades:', ['class' => 'control-label me-2', 'style' => 'width:100%']) !!}
    <br>
    <br>
    <br>
    {!! Form::file('image') !!} 
    <br>
    {\!! Form::file('image') !!}
    
    <br>
    <br>
    <br>
    @php
        $ciudades=['1'=>'Posadas',
                    '2'=>'Apostoles',
                    '3'=>'3-Apostoles',
                    '4'=>'4-Apostoles',
                    '5'=>'5-Apostoles',
                    '6'=>'6-Apostoles',
                    '7'=>'7-Apostoles',
                    '8'=>'8-Apostoles',
                    '9'=>'9-Apostoles'];
    @endphp
    <br>
    <div class="col-md-2">
        {!! Form::select('Ciudad', ['1' => 'Posadas', '2' => 'Garupa'], null, ['placeholder' => '','class'=>'form-select']) !!}
    </div>
    {\!! Form::select('Ciudad', ['1' => 'Posadas', '2' => 'Garupa'], null, ['placeholder' => '','class'=>'form-select']) !!}
    <br>
    <br>
    <div class="col-md-2">
        {!! Form::select('Ciudad', ['1' => 'Posadas', '2' => 'Garupa'], 2, ['placeholder' => '','class'=>'form-select']) !!}
    </div>
    {\!! Form::select('Ciudad', ['1' => 'Posadas', '2' => 'Garupa'], 2, ['placeholder' => '','class'=>'form-select']) !!}                                   
    <br><br>
    
    <div class="col-md-2">
        {!! Form::select('Ciudad', $ciudades, 7, ['placeholder' => '','class'=>'form-select']) !!}
    </div>
    {\!! Form::select('Ciudad', $ciudades, 7, ['placeholder' => '','class'=>'form-select']) !!}                                           
    <br><br>
    <div class="col-md-2">
        {!! Form::number('dni',null,['placeholder' => 'Ingrese dni','class'=>'form-control']) !!}
    </div>
    {\!! Form::number('dni',null,['placeholder' => 'Ingrese dni','class'=>'form-control']) !!}                                             
    <br><br>
    <div class="col-md-2">
        {!! Form::number('dni',252,['placeholder' => '','class'=>'form-control']) !!}
    </div>
    {\!! Form::number('dni',252,['placeholder' => '','class'=>'form-control']) !!}                                           
    <br><br>
    <div class="col-md-2">
        {!! Form::select('Ciudad', $ciudades, 2, ['placeholder' => '','class'=>'form-select']) !!}
    </div>
    {\!! Form::select('Ciudad', $ciudades, 2, ['placeholder' => '','class'=>'form-select']) !!}                                           
    <br><br>
    <div class="col-md-2">
        {!! Form::select('Ciudad', $ciudades, 7, ['placeholder' => '','class'=>'form-select']) !!}
    </div>
    {\!! Form::select('Ciudad', $ciudades, 7, ['placeholder' => '','class'=>'form-select']) !!}                                   
    <br>
    <br>
    {!! Form::label('check1','check 1:', ['class' => 'control-label me-2', 'style' => 'width:100%']) !!}                                   
    {!! Form::checkbox('tilde', 'value', false,['class'=>'','id'=>'tilde','checked']) !!}
    <br>
    {\!! Form::checkbox('tilde', 'value', false,['class'=>'','id'=>'tilde','checked']) !!}
    <br><br>
    {!! Form::label('check2','check 2:', ['class' => 'control-label me-2', 'style' => 'width:100%']) !!}                                   
    {!! Form::checkbox('tilde', 'value', true,['class'=>'','id'=>'tilde']) !!}
    <br>
    {\!! Form::checkbox('tilde', 'value', true,['class'=>'','id'=>'tilde']) !!}
    <br><br>
    {!! Form::label('check3','check 3:', ['class' => 'control-label me-2', 'style' => 'width:100%']) !!}                                   
    {!! Form::checkbox('tilde', 'value', false,['class'=>'','id'=>'tilde']) !!}
    <br>
    {\!! Form::checkbox('tilde', 'value', false,['class'=>'','id'=>'tilde']) !!}
    <br><br>
    <br>
    
    <div class="col-md-2">
        {!! Form::selectRange('number', 10, 20, null,['class'=>'form-select']) !!}
    </div>
    {\!! Form::selectRange('number', 10, 20, null,['class'=>'form-select']) !!}                                   
    <br><br>
    <div class="col-md-2">
        {!! Form::selectMonth('mes',null,['class'=>'form-select']) !!}
    </div>
    {\!! Form::selectMonth('mes',null,['class'=>'form-select']) !!}                                 
    <br><br>
    <div class="col-md-2">
        {!! Form::date('fecha',\Carbon\Carbon::now(),['class'=>'form-control']) !!} 
    </div>
    {\!! Form::date('fecha',\Carbon\Carbon::now(),['class'=>'form-control']) !!}                                  
    </div>
    <br>
    
    
    
</div>    




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
