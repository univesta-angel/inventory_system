@extends('layouts.master')

@section('pagetitle')Audit Trail @endsection

@section('styles')
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endsection

@section('headertitle')Audit Trail @endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

            <div class="input-group-append">
              <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body table-responsive p-0" style="height: 660px;">
        <table class="table table-head-fixed text-nowrap">
          <thead>
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>User</th>
              <th>Product</th>
              <th>Platform</th>
              <th class="text-center">Old Quantity</th>
              <th class="text-center">New Quantity</th>
            </tr>
          </thead>
          <tbody>
            @php $i = 1; @endphp
            @foreach($audits as $audit)
            <tr>
              <td>{{ date('M j, Y', strtotime($audit->created_at)) }}</td>
              <td>{{ date('h:i a', strtotime($audit->created_at)) }}</td>
              <td>{{ $audit->user() }} </td>
              <td>{{ $audit->product() }}</td>
              <td>{{ $audit->platform() }}</td>
              <td class="text-center">{{ $audit->old_value() }}</td>
              <td class="text-center">{{ $audit->new_value() }}</td>
            </tr>
            @php $i++; @endphp
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $audits->links() }}
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
@endsection