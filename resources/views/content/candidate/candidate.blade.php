@extends('layout.layout')
@section('title', 'Candidates')
@section('custom-css')
    <style>
        #allCandidatesTable{
            border: 1px solid #f0f0f0;
            border-radius: 5px;
        }

        #allCandidatesTable{
            margin-right: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <h5 class="card-header">All Candidates</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-bordered mt-2" id="allCandidatesTable">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Resume</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_of_candidates as $key=> $item)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$item->first_name}} {{$item->last_name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->gender}}</td>
                                <td>{{$item->phone}}</td>
                                <td><a href="{{asset($item->resume)}}" target="_blank">Download</a></td>
                                <td>{{Carbon\Carbon::parse($item->created_at)->format('M d, Y')}}</td>
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
            $('#allCandidatesTable').DataTable();
        });

       
    </script>
@endsection

