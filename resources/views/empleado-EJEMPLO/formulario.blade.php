
<div class="col-md-6 mb-3">
    <label for="Nombre" class="form-label">Nombre</label>
    <input type="text" name="Nombre" value="{{ isset($empleado->nombre)?$empleado->nombre:old('Nombre') }}" class="form-control" id="Nombre">
  </div>
  <div class="col-md-6 mb-3">
    <label for="Apellido" class="form-label">Apellido</label>
    <input type="text" name="Apellido" value="{{ isset($empleado->apellido)?$empleado->apellido:old('Apellido') }}" class="form-control" id="Apellido">
  </div>
  <div class="col-12 mb-3">
      <label for="Domicilio" class="form-label">Domicilio</label>
      <input type="text" name="Domicilio" value="{{ isset($empleado->domicilio)?$empleado->domicilio:old('Domicilio') }}" class="form-control" id="Domicilio">
  </div>
  <div class="col-12 mb-3">
    @if (isset($empleado->foto))
    <img class="my-2" src="{{ asset('storage').'/'.$empleado->foto }}" style="width:100px;height:100px;"  alt="">
    @endif
    <div class=" custom-file">
        <div class="d-flex">
            <label class="custom-file-label" for="Foto">Seleccionar Foto: {{ isset( $empleado->foto)?$empleado->foto:'' }}</label>
            <input type="file" name="Foto" value="{{ isset( $empleado->foto)?$empleado->foto:'' }}" class="custom-file-input  mb-3" id="Foto">      
        </div>
    </div>
    
  </div>

  <div class="col-12">
    <button type="submit"  class="btn btn-primary">{{$modo}} Datos</button>
    
    <a href="{{ route('empleado.index') }}"class="btn btn-secondary fo">Volver</a>
  </div>