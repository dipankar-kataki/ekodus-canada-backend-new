@extends('layout.layout')
@section('title', 'All Blogs')
@section('content')
    <div class="row">
        @forelse ($blogs as $item)
            <div class="col-md-3 col-sm-12">
                <div class="card mb-3">
                    <img src="{{asset($item->image)}}" class="card-img-top" alt="Blog Image">
                    <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
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