@extends('layouts.app')

@section('content')
    <login-component
        token="{{ csrf_token() }}"
        label-json="{{ json_encode(array(
            "login" => __('Login'),
            "email" => __('E-mail Address'),
            "password" => __('Password'),
            "remember" => __('Remember Me'),
            "forget" => __('Forgot Your Password?')
        ))}}">
    </login-component>
@endsection
