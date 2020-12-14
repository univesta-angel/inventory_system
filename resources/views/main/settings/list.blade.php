@extends('layouts.master')

@section('pagetitle')Settings @endsection

@section('styles')
<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endsection

@section('headertitle')Settings @endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered">
          <thead>                  
            <tr>
              <th>Platform</th>
              <th>API Key</th>
              <th>Password</th>
              <th>Shop URL</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($platforms as $platform)
            <tr>
              <td>{{ $platform->name }}</td>
              <td>
                @if($platform->api_key != '')
                {{ Crypt::decryptString($platform->api_key) }}
                @endif
              </td>
              <td>
                @if($platform->password != '')
                {{ Crypt::decryptString($platform->password) }}
                @endif
              </td>
              <td><a href="{{ $platform->shop_url }}">{{ $platform->shop_url }}</a></td>
              <td>
                <a href="/settings/{{ $platform->id }}">Edit</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="/plugins/jquery/jquery.min.js"></script>

<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="/dist/js/adminlte.min.js"></script>

<script src="/dist/js/demo.js"></script>

<script>
  $(function () {
    $("#tbl-products").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
@endsection