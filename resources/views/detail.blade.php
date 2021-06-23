@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('home') }}" class="btn btn-primary">Back</a>
            <div class="card">
                <div class="card-header">
                    {{ $data->type }} / {{ $data->location }}
                    <h4>{{ $data->title }}</h4> 
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                {!! $data->description !!}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                              <div class="card-header">
                                <strong>{{ $data->company }}</strong>
                              </div>
                              <div class="card-body">
                                <img src="{{ $data->company_logo }}" width="100%">
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header">
                                <strong>How to apply</strong>
                              </div>
                              <div class="card-body">
                                Visit our website <a href="{{ $data->company_url }}">{{ $data->company_url }}</a>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
