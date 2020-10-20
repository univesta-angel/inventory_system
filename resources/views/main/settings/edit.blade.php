@extends('layouts.master')

@section('pagetitle')Settings @endsection

@section('styles')
<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endsection

@section('headertitle')Settings @endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@if(session()->has('errors'))
    <div class="alert alert-danger">
        {{ session()->get('errors') }}
    </div>
@endif
<div class="row">
  <div class="col-6">
    <div class="card">
      <div class="card-body">

        <form role="form" action="/settings/{{ $platform->id }}/update">
          @csrf
          <input type="hidden" name="_method" value="PUT">
          <div class="card-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $platform->name }}">
            </div>
            <div class="form-group">
              <label for="api_key">API Key</label>
              <input type="text" class="form-control" id="api_key" name="api_key" placeholder="API Key" value="{{ Crypt::decryptString($platform->api_key) }}">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="{{ Crypt::decryptString($platform->password) }}">
            </div>
            @if($platform->id == 3)
            <div class="form-group">
              <label for="base_shop_name">Base shop name</label>
              <input type="text" class="form-control" id="password" name="base_shop_name" placeholder="Shop Name" value="{{ $platform->base_shop_name }}">
            </div>
            @endif
            <div class="form-group">
              <label for="shop_url">Shop URL</label>
              <input type="text" class="form-control" id="password" name="shop_url" placeholder="Shop URL" value="{{ $platform->shop_url }}">
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
@endsection