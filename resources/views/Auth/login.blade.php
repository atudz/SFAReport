@extends('layout.wide')
@section('title','Login SFA Report')
@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="logo-login">
                    <img src="img/sfi_logo.jpg" />
                </div>
                <div class="panel-heading">SFA Reports - LOGIN</div>
                <div class="panel-body">

                <div class="alert-danger no-padding">
                @foreach($errors->all() as $error)
                    <div class="error-list">{!!$error!!}</div>
                @endforeach
                </div>

                  {!!Form::open(['url'=>'/controller/login','class'=>'login-form'])!!}
                  <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail or Username" name="login" type="text" autofocus="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                </label>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Login">
                        </fieldset>
                    {!!Form::close()!!}
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->    
@stop