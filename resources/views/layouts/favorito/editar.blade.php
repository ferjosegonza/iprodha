<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Favorito</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {{-- {!! Form::model($Favorito, ['method' => 'PATCH','route' => ['categorialaboral.update', $Favorito->id]]) !!} --}}
            <div class="modal-body">
                {{-- <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Titulo</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                </div> --}}
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Descripcion</label>
                    <textarea id="descrip" class="form-control" id="exampleFormControlTextarea1" rows="3" style='resize:none; height: 30vh;'></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        {{-- {!! Form::close() !!} --}}
        </div>
    </div>
</div>

<script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
      integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
      crossorigin="anonymous"
></script>

<script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
      integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
      crossorigin="anonymous"
></script>