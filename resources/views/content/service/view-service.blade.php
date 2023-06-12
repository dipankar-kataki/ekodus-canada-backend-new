@extends('layout.layout')
@section('title', 'Service Details')
@section('custom-css')
    <style>
        #serviceDetailsImage{
            border-radius:5px 5px 0px 0px;
            height:500px;
            object-fit:cover;
            object-position:top;
            width:100%;
        }
    </style>
@endsection
@section('content')
    <a href="{{route('admin.get.all.services')}}" class="btn btn-icon btn-secondary mb-3">
        <span class="bx bx-home"></span>
    </a>
    <div class="row">
        <div class="col-12">
            <img src="{{asset($service_details->image)}}" alt="service-image" id="serviceDetailsImage">
        </div>
    </div>
    <div class="bg-white" style="border-radius:0px 0px 5px 5px;">
        <div class="col-12 px-3 py-3">
            <div class="d-flex flex-row align-items-center justify-content-between">
                <p class="text-primary">
                    <strong>Posted on: {{Carbon\Carbon::parse($service_details->created_at)->format('M-d, Y')}}</strong>
                </p>
                <p>
                    @if ($service_details->status === 1)
                        <strong><i class='bx bx-show text-secondary align-self-center'></i> <span class="text-primary">Public</span></strong>
                    @else
                        <strong><i class='bx bx-hide text-secondary align-self-center'></i> <span class="text-danger">Private</span></strong>                                               
                    @endif
                </p>
                
            </div>
            
            <h3 class="mt-2">{{$service_details->title}}</h3>
        </div>
        <hr class="dropdown-divider">
        <div class="col-12 pt-4 px-3 py-3">
            {!! $service_details->full_description !!}
        </div>
    </div>
@endsection