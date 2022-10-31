
@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Detalle de Obras</h3>
        </div>
        <div class="section-body">
            <div class="">
                <div class="row">
                    <div class="col">
                        <div>
                            @if (Session::has('mensaje'))                                                        
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ Session::get('mensaje') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <table class="table table-hover mt-2">
                            <thead style="background-color:#6777ef">                                     
                                <th scope="col" style="color:#fff;">NRO_CER_PAG</th>
                                <th scope="col" style="color:#fff;">NRO_CER_OBR</th>
                                <th scope="col" style="color:#fff;">SUB_TOT1_VIV</th>   
                                <th scope="col" style="color:#fff;">SUB_TOT1_INF</th>                                                                   
                            </thead>
                            <tbody>                                
                                @foreach ($certificados as $certificado)
                                    <tr>
                                        <td>{{ $certificado->nro_cer_pag }}</td>
                                        <td>{{ $certificado->nro_cer_obr }}</td>
                                        <td>{{ $certificado->sub_tot1_viv }}</td>
                                        <td>{{ $certificado->sub_tot1_inf }}</td>
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection