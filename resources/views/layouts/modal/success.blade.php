<style>
    .modal-confirm {
        color: #636363;
        width: 400px;
        margin: 30px auto;
    }

    .modal-confirm .modal-content {
        padding: 20px;
        border-radius: 5px;
        border: none;
        text-align: center;
        font-size: 14px;
    }

    .modal-confirm .modal-header {
        border-bottom: none;
        position: relative;
    }

    .modal-confirm h4 {
        text-align: center;
        font-size: 26px;
        margin: 30px 0 -10px;
    }

    .modal-confirm .close {
        position: absolute;
        top: -5px;
        right: -2px;
    }

    .modal-confirm .modal-body {
        color: #999;
    }

    .modal-confirm .modal-footer {
        border: none;
        text-align: center;
        border-radius: 5px;
        font-size: 13px;
    }

    .modal-confirm .modal-footer a {
        color: #999;
    }

    #myModal .modal-confirm .icon-box {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border-radius: 50%;
        z-index: 9;
        text-align: center;
        border: 3px solid #47c9a2;
    }

    #myModal .modal-confirm .icon-box i {
        color: #47c9a2;
        font-size: 46px;
        display: inline-block;
        margin-top: 13px;
    }

	#myModal .modal-confirm .btn, .modal-confirm .btn:active {
	color: #fff;
	border-radius: 4px;
	background: #47c9a2 !important;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	border-radius: 30px;
	margin-top: 10px;
	padding: 6px 20px;
	border: none;
	opacity: 0.7;
	}
	#myModal .modal-confirm .btn:hover, .modal-confirm .btn:focus {
		background: #47c9a2 !important;
		outline: none;
		opacity: 1;
	}
</style>
<div class="text-center">
	<!-- Button HTML (to Trigger Modal) -->
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
		Prueba Modal
	</button>
</div>
<!-- Modal HTML -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="icon-box">
                    <i class="fas fa-check"></i>
                </div>
                <h4 class="modal-title" id="exampleModalLabel">ÉXITO</h4>
                
            </div>
            <div class="modal-body">
                <h6 id='contenidoModal'>{{ Session::get('mensaje') }}</h6>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
