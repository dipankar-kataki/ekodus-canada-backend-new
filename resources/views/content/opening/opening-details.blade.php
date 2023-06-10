@extends('layout.layout')
@section('title', 'Opening Details')
@section('custom-css')
@endsection
@section('content')
    <a href="{{route('admin.active.opening')}}" class="btn btn-icon btn-secondary mb-3">
        <span class="bx bx-home"></span>
    </a>
    <div class="card mb-4">
        <div class="card-body">
            <div class="mb-3">
                <h5>{{$opening_details->job_title}}</h5>
            </div>
            <hr class="dropdown-divider">
            <div class="d-flex flex-row flex-wrap align-items-center mt-3">
                <p class="me-3"><span style="font-weight:600;">Location</span> : {{$opening_details->job_location}}</p>
                <p class="me-3"><span style="font-weight:600;">Experience</span> : {{$opening_details->job_experience}} Yrs</p>
                <p><span style="font-weight:600;">Shift</span> : 
                    @if ( $opening_details->job_shift === 'Full Time')
                        <span class="badge bg-label-primary me-1">{{$opening_details->job_shift}}</span>                                        
                    @else
                        <span class="badge bg-label-dark me-1">{{$opening_details->job_shift}}</span>                                        
                    @endif
                </p>
            </div>
            
            <p><span style="font-weight:600;">About Job</span> :</p>
            {!! $opening_details->job_description !!}
        </div>
    </div>

@endsection
@section('custom-scripts')
@endsection