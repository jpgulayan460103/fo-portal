@extends('layouts.app')

@section('content')
<register
:user-data="{{ json_encode($user_data) }}"
:positions="{{ json_encode($positions) }}"
:offices="{{ json_encode($offices) }}"
/>
@endsection
