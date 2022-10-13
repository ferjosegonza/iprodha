{{-- <style>
    .modal-ticket {
        color: #636363;
        width: 400px;
        margin: 30px auto;
    }

    .modal-ticket .modal-content {
        padding: 20px;
        border-radius: 5px;
        border: none;
        text-align: center;
        font-size: 14px;
    }

    .modal-ticket .modal-header {
        border-bottom: none;
        position: relative;
    }

    .modal-ticket h4 {
        text-align: center;
        font-size: 26px;
        margin: 30px 0 -10px;
    }

    .modal-ticket .close {
        position: absolute;
        top: -5px;
        right: -2px;
    }

    .modal-ticket .modal-body {
        color: #999;
    }

    .modal-ticket .modal-footer {
        border: none;
        text-align: center;
        border-radius: 5px;
        font-size: 13px;
    }

    .modal-ticket .modal-footer a {
        color: #999;
    }

    .modal-ticket .icon-box {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border-radius: 50%;
        z-index: 9;
        text-align: center;
        border: 3px solid #f15e5e;
    }

    .modal-ticket .icon-box i {
        color: #f15e5e;
        font-size: 46px;
        display: inline-block;
        margin-top: 13px;
    }

    .modal-ticket .btn {
        color: #fff;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.4s;
        line-height: normal;
        min-width: 120px;
        border: none;
        min-height: 40px;
        border-radius: 3px;
        margin: 0 5px;
        outline: none !important;
    }

    .modal-ticket .btn-info {
        background: #c1c1c1;
    }

    .modal-ticket .btn-info:hover,
    .modal-ticket .btn-info:focus {
        background: #a8a8a8;
    }

    .modal-ticket .btn-danger {
        background: #f15e5e;
    }
</style> --}}
<!-- Modal -->
<div class="modal fade" id="modalTicketReAsignar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        {!! Form::open(['id'=>'asignar', 'method' => 'GET', 'style' => 'display:inline']) !!}
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">¿Desea abrir nuevamente el ticket? <i class="far fa-sad-tear fs-3"></i></h3>
          
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="">
            <label class="fs-5">Agregar un comentario:</label>
            {!! Form::textarea('observ', null, ['class'=>'form-control', 'rows' => 10, 'cols' => 50, 'style' => 'resize:none; height: 30vh']) !!}
            {{-- <textarea class="form-control" type="text" cols="50" rows="10" style='resize:none; height: 30vh'></textarea> --}}
          </div>
        </div>
        <div class="modal-footer">
            {{-- {!! Form::open(['id'=>'asignar', 'method' => 'GET', 'style' => 'display:inline']) !!} --}}
            {!! Form::submit('SI', ['onclick' => '','class' => 'btn btn-success', 'style' => 'width: 100px']) !!}
            {{-- {!! Form::close() !!} --}}
        {{-- <button type="button" class="btn btn-success" style="width: 100px">SI</button> --}}
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NO</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

<div class="modal fade" id="modalTicketValidar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        {!! Form::open(['id'=>'cerrar', 'method' => 'GET', 'style' => 'display:inline']) !!}
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Confirma que el ticket fue completado exitosamente. <i class="far fa-smile fs-3"></i></h3>
          
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="">
            <label class="fs-5">Agregar un comentario:</label>
            {!! Form::textarea('observ', null, ['class'=>'form-control', 'rows' => 10, 'cols' => 50, 'style' => 'resize:none; height: 30vh']) !!}
            {{-- <textarea class="form-control" type="text" cols="50" rows="10" style='resize:none; height: 30vh'></textarea> --}}
          </div>
        </div>
        <div class="modal-footer">
            {{-- {!! Form::open(['id'=>'cerrar', 'method' => 'GET', 'style' => 'display:inline']) !!} --}}
            {!! Form::submit('SI', ['onclick' => '','class' => 'btn btn-success', 'style' => 'width: 100px']) !!}
            {{-- {!! Form::close() !!} --}}
            {{-- <button type="button" class="btn btn-success" style="width: 100px">SI</button> --}}
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NO</button>
        </div>
        {!! Form::close() !!}

      </div>
    </div>
</div>