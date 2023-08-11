<!-- Modal -->
  <div class="modal fade" id="exampleModalCo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Presentacion de Oferta de Obra.</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>¿Desea presentar la Oferta de Obra? Una vez presentado la oferta de obra ya no se podran realizar modificaciones en la oferta.</p>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="aceptarPre">
            <label class="form-check-label" for="flexCheckDefault">
              Acepto
            </label>
          </div>
        </div>
        <div class="modal-footer">
            {!! Form::open(['id'=>'presentar', 'method' => 'POST', 'style' => 'display:inline']) !!}
                    {!! Form::submit('Presentar', ['onclick' => '','class' => 'btn btn-success', 'disabled', 'id' => 'btnAceptar']) !!}
            {!! Form::close() !!}
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModalVa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Validar la Oferta de Obra.</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p id='contenidoModal'>¿Desea validar la Oferta de Obra de la empresa... ?</p>
        </div>
        <div class="modal-footer">
            {!! Form::open(['id'=>'validar', 'method' => 'POST', 'style' => 'display:inline']) !!}
                    {!! Form::submit('Validar', ['onclick' => '','class' => 'btn btn-success', 'id' => 'btnAceptar']) !!}
            {!! Form::close() !!}
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModalRe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Rechazar la Oferta de Obra.</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p id='contenidoModalRe'>¿Desea rechazar la Oferta de Obra de la empresa... ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="rechaz" style="display: inline">Rechazar</button>
            {{-- {!! Form::open(['id'=>'rechazar', 'method' => 'GET', 'style' => 'display:inline']) !!}
                    {!! Form::submit('Rechazar', ['onclick' => '','class' => 'btn btn-danger']) !!}
            {!! Form::close() !!} --}}
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>


  <script>
      const check = document.querySelector('#aceptarPre');
      const button = document.querySelector('#btnAceptar');

      const disableButton = () => {
        if(button.disabled){
          button.disabled = false;
        }else{
          button.disabled = true;
        }
      };

      check.addEventListener('click', disableButton);
  </script>