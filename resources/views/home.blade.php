@extends('layouts.app')

@section('content')
<home
    google-auth-url="{{ $google_auth_url }}"
    :auth-user="{{ $auth_user }}"
    :errors="{{ $errors }}"
/>
@endsection
