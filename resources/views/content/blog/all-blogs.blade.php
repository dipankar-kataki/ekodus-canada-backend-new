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
                                @if ($item->status === 1)
                                    <i class='bx bx-show text-secondary align-self-center'></i> <span class="text-primary">Public</span>
                                @else
                                    <i class='bx bx-hide text-secondary align-self-center'></i> <span class="text-danger">Private</span>                                                
                                @endif
                               
                                <div class="btn-group mx-2">
                                    <button type="button"  class="btn btn-xs btn-secondary btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        <li>
                                            @if ($item->status === 0)
                                                <a class="dropdown-item changeStatus" href="javascript:void(0);" data-id="{{encrypt($item->id)}}" data-status="1">Make Public</a>
                                            @else
                                                <a class="dropdown-item changeStatus" href="javascript:void(0);" data-id="{{encrypt($item->id)}}" data-status="0">Make Private</a>                                                
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr class="dropdown-divider">
                        <h5 class="card-title mt-3 mb-4">{{ Str::limit($item->title, 70) }}</h5>
                        <div class="d-flex flex-row-reverse align-items-center">
                            <a href="{{route('admin.view.blog.details',['id' => encrypt($item->id)])}}" class="btn btn-md btn-primary mx-3">View</a>
                            <a href="{{route('admin.edit.blog.details.page',['id' => encrypt($item->id)])}}" class="btn btn-md btn-warning">Edit</a>
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
@section('custom-scripts')
    <script>
        $('.changeStatus').on('click', function(){
        
            const id = $(this).data('id');
            const status = $(this).data('status')


            $.ajax({
                url:"{{route('admin.blog.change.status')}}",
                type:"POST",
                data:{
                    id: id,
                    status: status,
                    '_token': "{{csrf_token()}}"
                },
                success:function(data){

                    if(data.status === 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Great!',
                            text: data.message,
                        })

                        location.reload(true)
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: data.message,
                        })
                    }
                    
                }, error:function(error){
                    Swal.fire({
                        icon: 'error',
                        text: 'Oops! Something Went Wrong.',
                    })
                }
            })
        })
    </script>
@endsection