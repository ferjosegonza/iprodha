<div class="card rounded alert alert-dismissible fade show  @if (!Session::has('mensaje')&&(!Session::has('error'))&&(!$errors->any())&&!Session::has('alerta')) d-none @endif " role="alert">
    <div class="card-body">
        @if (Session::has('mensaje'))
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                {{ Session::get('mensaje') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (Session::has('alerta'))
            <div class="alert alert-warning alert-dismissible fade show " role="alert">
                {{ Session::get('alerta') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                <strong>¡Revise los campos!</strong>
                <div class="d-flex flex-column alert alert-danger col-xs-12  col-sm-6  col-md-4  col-lg-5 mb-3">
                    @foreach ($errors->all() as $error)
                        <div>- {{ $error }}</div>
                    @endforeach
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>