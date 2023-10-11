<div id="changePasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Contraseña</h5>
            </div>
            <form method="POST" action="{{ route('passwordedit.store') }}" id='changePasswordForm'>
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id=""></div>
                    <input type="hidden" name="is_active" value="1">
                    <input type="hidden" name="user_id" id="editPasswordValidationErrorsBox">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Contraseña Actual:</label><span
                                    class="required confirm-pwd"></span><span class="required">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="pfCurrentPassword2" type="password"
                                       name="contraseña_actual" required autocomplete="on">
                                
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Nueva Contraseña:</label><span
                                    class="required confirm-pwd"></span><span class="required">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="pfNewPassword" type="password"
                                       name="contraseña" required autocomplete="on">
                                
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Confirmar Contraseña:</label><span
                                    class="required confirm-pwd"></span><span class="required">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="pfNewConfirmPassword" type="password"
                                       name="contraseña_confirmacion" required autocomplete="on">
                                
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-warning " id="btnPrPasswordEditSave"
                                data-loading-text="<span class='sr-only'>Procesando...</span> ">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
