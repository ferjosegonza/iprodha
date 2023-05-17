<!-- Modal -->
<div class="modal fade" id="exampleModalCo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Crear una Obra con viviendas.</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Verifique que los datos esten correctos.</p>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="Numero:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Numero:</label>
                    <input id="num_obr_m" class="form-control" name="num_obr_m" type="number" disabled>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="Obra:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Obra: </label>
                    <textarea id="nom_obr_m" class="form-control" rows="54" cols="54" style="resize:none; height: 10vh" disabled></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="Viviendas:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Total de viviendas: </label>
                    <input id="can_viv_m" class="form-control" style="text-transform:uppercase" name="nom_obra" type="text" disabled>
                </div>
            </div>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="aceptarPre">
            <label class="form-check-label" for="flexCheckDefault">
              Confirmar los datos.
            </label>
          </div>
        </div>
        <div class="modal-footer">
            {{-- {!! Form::open(['id'=>'presentar', 'method' => 'POST', 'style' => 'display:inline']) !!} --}}
                    {!! Form::submit('Crear', ['onclick' => 'enviarDatos()','class' => 'btn btn-success', 'disabled', 'id' => 'btnAceptar']) !!}
            {{-- {!! Form::close() !!} --}}
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
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