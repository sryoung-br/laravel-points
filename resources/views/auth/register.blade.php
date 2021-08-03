@extends('layouts.app')

@section('content')
    <register-component
        token="{{ csrf_token() }}"
        label-json="{{ json_encode(array(
            "register" => __('Register'),
            "name" => __('Nome'),
            "email" => __('E-mail Address'),
            "password" => __('Password'),
            "password_confirm" => __('Confirm Password'),
        ))}}">
    </register-component>
@endsection
