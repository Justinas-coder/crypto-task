@extends('layouts.app')

@section('content')

    @if(session('message'))
        <div class="alert alert-success">{{Session::get('message')}}</div>
    @endif

    @if(session('asset-updated-message'))
        <div class="alert alert-success">{{Session::get('asset-updated-message')}}</div>
    @endif

    @if(session('asset-created-message'))
        <div class="alert alert-success">{{Session::get('asset-created-message')}}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Crypto_Currency</th>
                    <th>Total Quantity</th>
                    <th>Paid Total Value</th>
                    <th>Current Total Value</th>
                    <th>Currency</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($asset_quantities as $asset_quantity)
                    <tr>
                        <td>
                            <a href="{{route('asset.index', ['asset' => $asset_quantity['currency']])}}">{{$asset_quantity['currency']}}</a>
                        </td>
                        <td>{{$asset_quantity['total_qty']}}</td>
                        <td>{{$asset_quantity['total_value']}}</td>
                        <td>{{$asset_quantity['current_value']}}</td>
                        <td>USD</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Crypto</th>
                    <th>Label</th>
                    <th>Quantity</th>
                    <th>Paid Total Value</th>
                    <th>Currency</th>
                    <th>Transaction Date</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($queried_asset as $asset)
                    <tr>
                        <td><a href="{{route('asset.edit', ['asset'=>$asset->id])}}">{{$asset->crypto_currency}}</a>
                        </td>
                        <td>{{$asset->title}}</td>
                        <td>{{$asset->quantity}}</td>
                        <td>{{$asset->paid_value * $asset->quantity}}</td>
                        <td>{{$asset->currency}}</td>
                        <td>{{$asset->created_at}}</td>
                        <td>
                            <form method="post" action="{{route('asset.destroy', $asset->id)}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
