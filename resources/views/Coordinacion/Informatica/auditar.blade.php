<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="noindex, nofollow">
  <title>Laravel log viewer</title>
  <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
  <style>
    body {
      padding: 25px;
    }

    h1 {
      font-size: 1.5em;
      margin-top: 0;
    }

    #table-log {
        font-size: 0.85rem;
    }

    .sidebar {
        font-size: 0.85rem;
        line-height: 1;
    }

    .btn {
        font-size: 0.7rem;
    }

    .stack {
      font-size: 0.85em;
    }

    .date {
      min-width: 75px;
    }

    .text {
      word-break: break-all;
    }

    a.llv-active {
      z-index: 2;
      background-color: #f5f5f5;
      border-color: #777;
    }

    .list-group-item {
      word-break: break-word;
    }

    .folder {
      padding-top: 15px;
    }

    .div-scroll {
      height: 80vh;
      overflow: hidden auto;
    }
    .nowrap {
      white-space: nowrap;
    }
    .list-group {
            padding: 5px;
        }




    /**
    * DARK MODE CSS
    */

    body[data-theme="dark"] {
      background-color: #151515;
      color: #cccccc;
    }

    [data-theme="dark"] a {
      color: #4da3ff;
    }

    [data-theme="dark"] a:hover {
      color: #a8d2ff;
    }

    [data-theme="dark"] .list-group-item {
      background-color: #1d1d1d;
      border-color: #444;
    }

    [data-theme="dark"] a.llv-active {
        background-color: #0468d2;
        border-color: rgba(255, 255, 255, 0.125);
        color: #ffffff;
    }

    [data-theme="dark"] a.list-group-item:focus, [data-theme="dark"] a.list-group-item:hover {
      background-color: #273a4e;
      border-color: rgba(255, 255, 255, 0.125);
      color: #ffffff;
    }

    [data-theme="dark"] .table td, [data-theme="dark"] .table th,[data-theme="dark"] .table thead th {
      border-color:#616161;
    }

    [data-theme="dark"] .page-item.disabled .page-link {
      color: #8a8a8a;
      background-color: #151515;
      border-color: #5a5a5a;
    }

    [data-theme="dark"] .page-link {
      background-color: #151515;
      border-color: #5a5a5a;
    }

    [data-theme="dark"] .page-item.active .page-link {
      color: #fff;
      background-color: #0568d2;
      border-color: #007bff;
    }

    [data-theme="dark"] .page-link:hover {
      color: #ffffff;
      background-color: #0051a9;
      border-color: #0568d2;
    }

    [data-theme="dark"] .form-control {
      border: 1px solid #464646;
      background-color: #151515;
      color: #bfbfbf;
    }

    [data-theme="dark"] .form-control:focus {
      color: #bfbfbf;
      background-color: #212121;
      border-color: #4a4a4a;
  }

  </style>

  <script>
    function initTheme() {
      const darkThemeSelected =
        localStorage.getItem('darkSwitch') !== null &&
        localStorage.getItem('darkSwitch') === 'dark';
      darkSwitch.checked = darkThemeSelected;
      darkThemeSelected ? document.body.setAttribute('data-theme', 'dark') :
        document.body.removeAttribute('data-theme');
    }

    function resetTheme() {
      if (darkSwitch.checked) {
        document.body.setAttribute('data-theme', 'dark');
        localStorage.setItem('darkSwitch', 'dark');
      } else {
        document.body.removeAttribute('data-theme');
        localStorage.removeItem('darkSwitch');
      }
    }
  </script>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col sidebar mb-3">
      <h1><i class="fa fa-calendar text-warning" aria-hidden="true"></i> Laravel Auditor App</h1>

      <div class="custom-control custom-switch" style="padding-bottom:20px;">
        <input type="checkbox" class="custom-control-input" id="darkSwitch">
        <label class="custom-control-label" for="darkSwitch" style="margin-top: 6px;">Dark Mode</label>
      </div>
      <div class="row justify-content-center align-items-center mb-3">
        <a href="{{ route('inicio') }}" class="btn btn-success w-100" style="font-size:2em;text-decoration:none;">Volver</a>
       
      </div>
    </div>
    <div class="col-10 table-container ">
       <!-- Centramos la paginacion a la derecha -->
       <div class="pagination justify-content-start mt-5">
        {!! $auditados->links() !!}
      </div>
      <div class="table-responsive">
        <table id="table-log" class="table table-striped mt-2 nowrap" >
          <thead>
          <tr>
              <th>ID</th>
              <th>USER_TYPE</th>
              <th>USER_ID</th>
              <th >EVENT</th>
              <th>AUDITABLE_TYPE</th>
              <th>AUDITABLE_ID</th>
              <th>OLD_VALUES</th>
              <th>NEW_VALUES</th>
              <th><div>URL</div></th>
              <th>IP_ADDRESS</th>
              <th>USER_AGENT</th>
              <th>TAGS</th>
              <th>CREATED_AT</th>
              <th>UPDATED_AT</th>
          </tr>
          </thead>
          <tbody>

          @foreach($auditados as $auditado)
            <tr data-display="stack{{{$auditado->id}}}" >
              <td class="text">{{$auditado->id}}</td>
              <td class="text">{{$auditado->user_type}}</td>
              <td class="text">{{$auditado->user_id}}</td>
              {{--<td class="text"><div class="  d-flex text-wrap"style="width: 100px;"><div>{{$auditado->event}}</div></div></td>--}}
              <td class="text">{{$auditado->event}}</td>
              <td class="text">{{$auditado->auditable_type}}</td>
              <td class="text">{{$auditado->auditable_id}}</td>
              <td class="text">{{$auditado->old_values}}</td>
              <td class="text">{{$auditado->new_values}}</td>
              <td class="text">{{$auditado->url}}</td>

               {{--<td class="text"><div class="  d-flex text-wrap"style="width: 120px;"><div>{{$auditado->old_values}}</div></div></td>--}}
               {{--<td class="text"><div class="  d-flex text-wrap"style="width: 120px"><div>{{$auditado->new_values}}</div></div></td>--}}
               {{--<td class="text" ><div class="  d-flex text-wrap"style="width: 300px;"><div>{{$auditado->url}}</div></div></td>--}}
              <td class="text">{{$auditado->ip_address}}</td>
              <td class="text">{{$auditado->user_agent}}</td>

               {{--<td class="text"><div class="  d-flex text-wrap"style="width: 200px;  "><div>{{$auditado->}}</div></div></td>--}}
              <td class="text">{{$auditado->tags}}</td>
              <td class="date">{{$auditado->created_at}}</td>
              <td class="date">{{$auditado->updated_at}}</td>
            </tr>
          @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- jQuery for Bootstrap -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<!-- FontAwesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script>

  // dark mode by https://github.com/coliff/dark-mode-switch
  const darkSwitch = document.getElementById('darkSwitch');

  // this is here so we can get the body dark mode before the page displays
  // otherwise the page will be white for a second... 
  initTheme();

  window.addEventListener('load', () => {
    if (darkSwitch) {
      initTheme();
      darkSwitch.addEventListener('change', () => {
        resetTheme();
      });
    }
  });

  // end darkmode js
        
  $(document).ready(function () {
    
  });
</script>
</body>
</html>