<!-- Modal -->
<style>
    #dvtxtarea{
        /* display:inline-block; */
        position:relative;
    }

    #btntxtarea{
        position:absolute;
        /* bottom:10px; */
        top: 45px;
        right:10px;
    }
    /* #codigo{
        display:block;
    } */
</style>
<div class="modal fade" id="exampleModalCo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Ruta y codigo AppScript.</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="Ruta:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Ruta:</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="ruta">
                        <button class="btn btn-outline-secondary" type="button" id="btn_copiar_ruta" onclick="copiarRuta()">Copiar</button>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group" id="dvtxtarea">
                    <label for="Codigo:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Codigo: </label>
                    <textarea id="codigo" class="form-control" rows="54" cols="54" style="resize:none; height: 45vh" readonly></textarea>
                    <button id="btntxtarea" onclick="copiarCodigo()">Copiar</button>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer m-auto">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>