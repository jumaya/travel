@extends('main')

@section('title') Suricatum Test - Travel @endsection

@include('partials.logbar')

@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-3">

            <div class="panel panel-primary">
                <div class="panel-heading">XML Travels File </div>
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

                    @if(\Session::has('errorT'))
                    <div class="alert alert-dismissible alert-danger fontbig">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{Session::get('alert')}}</strong>
                    </div>
                    @endif

                    <form class="form-horizontal crolsant" role="form" enctype="multipart/form-data" method="POST" action="{{action('TravelController@store')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="col-lg-12">
                                <a title="Do click and see info about xml file" class="pull-left" href="#ConfirmDelete" data-toggle="modal" data-target="#ConfirmDelete">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x "></i>
                                        <i class="fa fa-info fa-stack-1x fa-inverse "></i>
                                    </span>
                                </a><br><br>
                                <input data-buttonText="Upload File" accept="text/xml" name="xml_travel" type="file" required class="form-control-file">
                                <small id="fileHelp" class="form-text text-muted"> Please input you xml file. Use the correctly structure. See the info icon</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-">
                                <button type="submit" class="btn btn-primary">
                                    SAVE DATA
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>


        <div class="col-lg-9">

            <div class="panel panel-primary">
                <div class="panel-heading">Travel List </div>
                <div class="panel-body">
                    <table class="table table-bordered" id="tTravel">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Travel Date</th>
                                <th>Country</th>
                                <th>City</th>
                                <th width="50px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelete" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <blockquote class="blockquote">
                        <p class="mb-0"> <strong> 
                            You should use the next xml structure to load travels succesfully.
                        </strong>
                        </p>
                      
                        <textarea readonly rows="18" cols="60" style="border:none;">
                <?xml version="1.0" encoding="UTF-8" ?>
                <data>
                    <travel>
                        <travel_date> yyyy-mm-dd </travel_date>
                        <country> Country1 </country>
                        <city> City1 </city>
                        <email> someone@example.com </email>
                    </travel>
                    <travel>
                        <travel_date> yyyy-mm-dd </travel_date>
                        <country> Country2 </country>
                        <city> City2 </city>
                        <email> someone@example.com </email>
                    </travel>	
                </data>
                        </textarea>                    
                    </blockquote>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/clientFunction.js')}}"></script>
@stop