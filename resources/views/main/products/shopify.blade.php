@extends('layouts.master')

@section('pagetitle')Shopify Products @endsection

@section('styles')
<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endsection

@section('headertitle')Shopify Products @endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <table id="tbl-products" class="table table-bordered table-striped">
          <thead>
            <tr>
              <!--th>No.</th-->
              <th>Name</th>
              <th>Quantity</th>
              <th>Category</th>
              <th>Brand</th>
              <th>URL</th>
              <th>Actions</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="edit-quantity">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="#eq-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-edit-quantity">
          @csrf
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" id="id" name="id">
          <h5 id="ptitle" class="mb-4"></h5>
          <div class="form-group">
            <label for="quantity">Inventory quantity</label>
            <input type="number" class="form-control" min="0" id="quantity" name="quantity" placeholder="#">
          </div>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btn-save-qty" class="btn btn-primary">Save changes</button>
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
<script src="/plugins/toastr/toastr.min.js"></script>

<script src="/dist/js/adminlte.min.js"></script>

<script src="/dist/js/demo.js"></script>

<script>
  $(document).ready(function () {
    var table = $("#tbl-products").DataTable({
      "responsive": true,
      "autoWidth": false,
      "pageLength": 100,
      "ajax": '/products/shopify/ajax',
      "columnDefs": [
        { "targets": [4,5], "orderable": false }
      ],
      "drawCallback": function(){
        $(".edit-link").click(function(){
          var ptitle = $(this).data('title');
          var id = $(this).data('id');
          var quantity = $(this).data('qty');

          $('#ptitle').text(ptitle);
          $('#id').val(id);
          $('#quantity').val(quantity);
        });
      }
    });

    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "600",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }

    $('#btn-save-qty').click(function(){
      var form = $('#form-edit-quantity');
      var id = form.find('#id').val();
      var data = form.serialize();
      
      $.ajax({
        url: '/products/shopify/'+id+'/update',
        type: 'POST',
        data: data,
        success: function(response) {
          var res = JSON.parse(response);
          console.log(res);
          if (res.status == 'success') {
            table.ajax.reload();
            $('#edit-quantity').modal('toggle');
            toastr.success(res.message, res.product);
          } else {
            toastr.error(res.message, res.product);
          }
        }
      });

    });

  });
</script>
@endsection