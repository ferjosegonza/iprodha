@extends('layouts.app')

@section('content')
    
        <div class="section-header">
            <h1> Estado Civil</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col">
                {!! Form::open(['method' => 'GET', 'class' => 'd-flex col-sm-6', 'route' => ['estadocivil.index'], 'style' => 'display:inline']) !!}
                </div>
            </div>
        </div>
       
@endsection
