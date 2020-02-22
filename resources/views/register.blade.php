@extends('main')

@section('title') Suricatum Test - CLient @endsection

@section('content')

@include('partials.logbar')

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Register Form </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger" , style="background-color:#ff4a3d">
                        <strong>Ups!</strong> something wasn't right. <br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(\Session::has('alert'))
                    <div class="alert alert-dismissible alert-success fontbig">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{Session::get('alert')}}</strong>
                    </div>
                    @endif

                    <form class="form-horizontal crolsant" role="form" enctype="multipart/form-data" method="POST" action="{{action('ClientController@store')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" required class="form-control" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" required class="form-control" name="last_name" placeholder="Last Name" value="{{ old('last_name')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" required class="form-control" name="email" placeholder="Email " value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" required class="form-control" name="phone" placeholder="Phone" value="{{ old('phone')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" required class="form-control" name="address" placeholder="Address" value="{{ old('address') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <label for="exampleInputFile">Photo File: </label>
                                <input data-buttonText="Upload File" name="photo" type="file" class="form-control-file">
                                <small id="fileHelp" class="form-text text-muted">The image file support jpeg,png,jpg,gif,svg formats, and maximun size of 8mb.</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="panel panel-primary">
                <div class="panel-heading">Client List </div>
                <div class="panel-body">
                    <table class="table table-bordered" id="tClient">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Photo</th>
                                <th width="50px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-md-8 col-md-offset-2">
            <div id="ajaxModel" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">

                            <div class="">
                                <div class="panel-heading"><strong> CLIENT EDIT </strong> </div>
                                <div class="panel-body">

                                    <form id="productForm" name="productForm" class="form-horizontal" role="form" enctype="multipart/form-data" method="POST">
                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="client_id" id="client_id">

                                        <div class="row">
                                            <div class="form-group col-xs-6">
                                                <input id="first_name" type="text" required class="form-control" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
                                            </div>

                                            <div class="form-group col-xs-1">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input id="last_name" type="text" required class="form-control" name="last_name" placeholder="Last Name" value="{{ old('last_name')}}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-xs-6">
                                                <input id="email" type="text" required class="form-control" name="email" placeholder="Email " value="{{ old('email') }}">
                                            </div>

                                            <div class="form-group col-xs-1">
                                            </div>

                                            <div class="form-group col-xs-6">
                                                <input id="phone" type="text" required class="form-control" name="phone" placeholder="Phone" value="{{ old('phone')}}">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 col-md-offset-6">
                                            <input id="address" type="text" required class="form-control" name="address" placeholder="Address" value="{{ old('address') }}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="exampleInputFile">Photo File: </label>
                                            <input id="photo" data-buttonText="Upload File" name="photo" type="file" class="form-control-file">
                                            <small id="fileHelp" class="form-text text-muted">The image file support jpeg,png,jpg,gif,svg formats, and maximun size of 8mb.</small>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('js')
    <script type="text/javascript" src="{{asset('js/clientFunction.js')}}"></script>
    @stop