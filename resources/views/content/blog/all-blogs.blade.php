@extends('layout.layout')
@section('title', 'All Blogs')
@section('content')
    <div class="row">
        @forelse ($blogs as $item)
            <div class="col-md-4 col-sm-12">
                <div class="card mb-3">
                    <img src="{{asset($item->image)}}" class="card-img-top" alt="Blog Image" style="height:250px;object-fit:cover;">
                    <div class="card-body" style="border: 1px solid #f4f4f4;">
                        <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                            <span style="font-size:13px;font-weight:600;">Posted on: {{ Carbon\Carbon::parse($item->created_at)->format('M-d, Y') }}</span>
                            <div>
                                <i class='bx bx-show text-primary align-self-center'></i> <span class="text-primary">Public</span>
                                <div class="btn-group mx-2">
                                    <button type="button"  class="btn btn-xs btn-secondary btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        <li><a class="dropdown-item" href="javascript:void(0);">Change Visibility</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr class="dropdown-divider">
                        <h5 class="card-title mt-3 mb-4">{{ Str::limit($item->title, 60) }}</h5>
                        <div class="d-flex flex-row-reverse align-items-center">
                            <a href="#" class="btn btn-md btn-primary mx-3">View</a>
                            <a href="#" class="btn btn-md btn-warning">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="mx-auto flex-row justify-content-around align-items-center">
                <h5>Oops! No Blogs To Show.</h5>
            </div>
        @endforelse
    </div>
    
    
@endsection