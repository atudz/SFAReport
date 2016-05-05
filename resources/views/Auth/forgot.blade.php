@extends('layout.wide')
@section('title','Login SFA Report')
@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="logo-login">
                    <img src="img/sfi_logo.jpg" />
                </div>
                <div class="panel-heading">SFA SFI Reports - Forgot Password</div>
                <div class="panel-body">

                <div class="alert-danger no-padding">
                @foreach($errors->all() as $error)
                    <div class="error-list">{!!$error!!}</div>
                @endforeach
                </div>
                <br />
                    {!!Form::open(['url'=>'/controller/resetpass','class'=>'forgot-form'])!!}
                    <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Enter your E-mail Address" name="email" type="text" autofocus="">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Send"> 
                            <br /><br />
                            <a class="forgot-password" href="{{route('login')}}">&larr; Back</a>
                        </fieldset>
                    {!!Form::close()!!}
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->    
@stop