@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Welcome to DSWD FOXI Portal</div>

                <div class="card-body">
                    <login-form />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection