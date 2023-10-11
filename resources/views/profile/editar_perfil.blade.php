<div id="editProfileModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Perfil</h5>
            </div>
            <div class="modal-body">
                {!! Form::model(Auth::user(), ['method' => 'POST','route' => ['emailedit.store', Auth::user()->id]]) !!}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group ">
                            <label for="">Nombre:</label>                                    
                            {!! Form::text('nombre', Auth::user()->name, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Correo:</label>                                    
                            {!! Form::text('email', Auth::user()->email, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Contraseña:</label>                                    
                            {!! Form::password('contraseña', array('class' => 'form-control', 'type' => 'password', 'required', 'autocomplete' => 'on')) !!}
                        </div>
                    </div>       
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-warning">Guardar</button>
                </div>
                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

{{-- <div id="editProfileModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Perfil</h5>
            </div>
            <form method="post" id="editProfileForm"  action="{{ route('emailedit.store') }}">
                @csrf
                
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="editProfileValidationErrorsBox"></div>
                    <input type="hidden" name="user_id" id="pfUserId">
                    <input type="hidden" name="is_active" value="1">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Nombre:</label><span class="required">*</span>
                            <input type="text" name="nombre" id="pfName" placeholder="{{\Illuminate\Support\Facades\Auth::user()->name}}" value="{{\Illuminate\Support\Facades\Auth::user()->name}}" class="form-control" required autofocus
                                   tabindex="1">
                        </div>
                    </div>
                    <div class="row ">
                        <div class="form-group col-sm-6">
                            <label>Email:</label><span class="required">*</span>
                            <input type="text" name="email" id="pfEmail" placeholder="{{\Illuminate\Support\Facades\Auth::user()->email}}" value="{{\Illuminate\Support\Facades\Auth::user()->email}}" class="form-control" required tabindex="3">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Contraseña :</label><span
                                    class="required confirm-pwd"></span><span class="required">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="pfCurrentPassword" type="password"
                                       name="contraseña" required>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-warning" id="btnPrEditSave"
                                data-loading-text="<span class='spinner-border spinner-border-sm'></span> Procesando..."
                                tabindex="5">Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> --}}
