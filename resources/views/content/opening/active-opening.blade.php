@extends('layout.layout')
@section('title', 'Active Opening')
@section('custom-css')
    <style>
        #activeOpeningTable{
            border: 1px solid #c1c1c1;
            border-radius: 3px;
        }

        #activeOpeningTable_filter{
            margin-right: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <h5 class="card-header">Active Openings</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-bordered mt-2" id="activeOpeningTable">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Job Title</th>
                            <th>Location</th>
                            <th>Experience</th>
                            <th>Job Shift</th>
                            <th>Posted On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($active_openings as $key => $item)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>
                                    <strong>{{$item->job_title}}</strong>
                                </td>
                                <td>{{$item->job_location}}</td>
                                <td>
                                    {{$item->job_experience}} Yrs
                                </td>
                                <td>
                                    @if ( $item->job_shift === 'Full Time')
                                        <span class="badge bg-label-primary me-1">{{$item->job_shift}}</span>                                        
                                    @else
                                        <span class="badge bg-label-dark me-1">{{$item->job_shift}}</span>                                        
                                    @endif
                                </td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('M,d Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> View</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-hide me-1"></i> Change Status</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('custom-scripts')
    <script>
        $(document).ready( function(){
            $('#activeOpeningTable').DataTable();
        });
    </script>
@endsection