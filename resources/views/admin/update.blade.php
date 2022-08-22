@extends('layouts.app')

@section('content')

    @if(session('asset-updated-message'))

        <div class="alert alert-success">{{Session::get('asset-updated-message')}}</div>

    @endif

    <div class="col-sm-4 mb-4">

        <form action="{{route('asset.update', $asset->id)}}" method="post">
            @method('PATCH')
            @csrf
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" aria-describeby=""
                       placeholder="Enter title"
                       value="{{$asset->title}}">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="crypto_currency">Crypto_currency</label>
                </div>
                <select class="custom-select" id="crypto_currency" name="crypto_currency">
                    @foreach ($currencies as $currency)
                        <option value="{{$currency->name}}">{{$currency->name}}</option>
                    @endforeach                </select>
            </div>


            <div class="form-group mb-3">
                <label for="paid_value">Paid Value</label>
                <input type="number" name="paid_value" class="form-control" id="paid_value" aria-describeby=""
                       placeholder="" value="{{$asset->paid_value}}">
            </div>
            <div class="form-group mb-3">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" class="form-control" id="quantitie" aria-describeby=""
                       placeholder="" value="{{$asset->quantity}}">
            </div>

            <div class="input-group mb-5">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="currency">Options</label>
                </div>
                <select class="custom-select" id="currency" name="currency">
                    <option selected value="USD">USD</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif

    </div>


@endsection
