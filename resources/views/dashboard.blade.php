@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <!-- Navigation  -->

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link btn btn-outline-secondary" href="{{route('asset.create')}}">Create
                                        Asset</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-secondary" href="{{route('asset.index')}}">View
                                        Wallet</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>


            </div>
        </div>
    </div>
    </div>
@endsection
