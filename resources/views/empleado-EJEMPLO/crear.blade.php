@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Crear Empleado</h3>
  </div>
  <div class="section-body">
      <div class="row">
          <div class="col-lg-6">
              <div class="card">
                    <div class="card-body">                                   
                        @if ($errors->any())                                                
                            <div class="alert alert-light alert-dismissible fade show" role="alert">
                                <div><strong>¡Revise los campos!</strong></div>
                                <div>
                                    @foreach ($errors->all() as $error)                                    
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach                        
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                      @endif
                      <form class="row g-3" action="{{url('/empleado')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include("empleado.formulario",['modo'=>'Agregar'])
                      </form>

                
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection