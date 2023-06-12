@extends('layout.layout')
@section('title', 'Add New Service')
@section('custom-css')
    <style>
        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 300px;
        }

        #previewServiceImage{
            border-radius:5px 5px 0px 0px;
            height:400px;
            width:100%;
            object-fit: contain;
            border:1px solid rgb(223, 223, 223);
            margin-bottom:10px;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <h5 class="card-header">Edit Service</h5>
        <div class="card-body">
            <form id="editServiceForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{encrypt($service_details->id)}}">
                <div class="mb-3">
                    <label for="serviceTitle" class="form-label">Enter Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="e.g Manual Testing" maxlength="100" value="{{$service_details->title}}">
                </div>
                <div class="mb-3">
                    <label for="serviceImage" class="form-label">Select Service Image</label>
                    <img src="{{asset($service_details->image)}}" alt="Service Image" id="previewServiceImage">
                    <input class="form-control" type="file" name="serviceImage" id="serviceImage" accept=".png, .jpg, .jpeg" placeholder="Select Image">
                </div>
                <div class="mb-3">
                    <label for="editor" class="form-label">Enter Short Description</label>
                    <div id="shortDescriptionEditor"></div>
                </div>

                <div class="mb-3">
                    <label for="editor" class="form-label">Enter Full Description</label>
                    <div id="fullDescriptionEditor"></div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Change Visibility</label>
                    <select name="status" id="status" class="form-control">
                        <option value="{{$service_details->status}}" selected>
                            @if ($service_details->status === 1)
                                <span class="text-success">Active</span>
                            @else
                                <span class="text-danger">De-Active</span>
                            @endif
                        </option>
                        <option value="1" class="text-success">Active</option>
                        <option value="0" class="text-danger">De-Active</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-md btn-primary" id="editServiceBtn" style="float:right;">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('custom-scripts')


    <script>
        let myShortEditor;
        let myFullEditor;
        
        $(document).ready( () => {
            
            ClassicEditor
                .create( document.querySelector( '#shortDescriptionEditor' ),{
                    toolbar: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                }).then( editor => {
                    myShortEditor = editor;
                    myShortEditor.setData("{!! $service_details->short_description !!}");
                } )
                .catch( error => {
                    console.error( error );
                } );



                
                ClassicEditor
                .create( document.querySelector( '#fullDescriptionEditor' ),{
                    toolbar: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                }).then( editor => {
                    myFullEditor = editor;
                    myFullEditor.setData("{!! $service_details->full_description !!}");
                } )
                .catch( error => {
                    console.error( error );
                } );
        });


        
    </script>
    <script>

        $('#serviceImage').on('change', function(){
            let file = this.files[0];

            if(file){
                let reader = new FileReader();
                reader.onload = function(event){
                    $('#previewServiceImage').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });


        $('#editServiceForm').on('submit', function(e){
            e.preventDefault();

            $('#editServiceBtn').attr('disabled', true);
            $('#editServiceBtn').text('Please Wait...');

            let formData = new FormData(this);

            let serviceImage = $('#serviceImage').prop('files')[0];
            formData.append('serviceImage', serviceImage);
            formData.append('shortDescription', myShortEditor.getData());
            formData.append('longDescription', myFullEditor.getData());

            $.ajax({
                url:"{{route('admin.save.edit.service')}}",
                type:"POST",
                data:formData,
                processData:false,
                contentType:false,
                success: function(data){
                    if(data.status === 1){
                        Swal.fire({
                            icon:"success",
                            text:data.message,
                            confirmButtonText: 'Close',
                        })
                    }else{
                        Swal.fire({
                            icon:"error",
                            text: data.message,
                            confirmButtonText: 'Close',
                        });

                        $('#editServiceBtn').attr('disabled', false);
                        $('#editServiceBtn').text('Submit');
                    }
                },
                error: function(error){
                    Swal.fire({
                        icon:"error",
                        text:'Oops! Something Went Wrong.',
                        confirmButtonText: 'Close',
                    });

                    $('#editServiceBtn').attr('disabled', false);
                    $('#editServiceBtn').text('Submit');
                }

            });
        });
    </script>
@endsection