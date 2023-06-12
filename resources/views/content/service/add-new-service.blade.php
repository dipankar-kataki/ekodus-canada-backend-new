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
        <h5 class="card-header">Add New Service</h5>
        <div class="card-body">
            <form id="addNewServiceForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="serviceTitle" class="form-label">Enter Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="e.g Manual Testing" maxlength="100" required>
                </div>
                <div class="mb-3">
                    <label for="serviceImage" class="form-label">Select Service Image</label>
                    <img src="{{asset('assets/img/placeholder.png')}}" alt="Service Image" id="previewServiceImage">
                    <input class="form-control" type="file" name="serviceImage" id="serviceImage" accept=".png, .jpg, .jpeg" placeholder="Select Image" required>
                </div>
                <div class="mb-3">
                    <label for="editor" class="form-label">Enter Short Description</label>
                    <div id="shortDescriptionEditor"></div>
                </div>

                <div class="mb-3">
                    <label for="editor" class="form-label">Enter Full Description</label>
                    <div id="fullDescriptionEditor"></div>
                </div>
                <div>
                    <button type="submit" class="btn btn-md btn-primary" id="addNewServiceBtn" style="float:right;">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('custom-scripts')
    <script>
        let myShortEditor;
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
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
    <script>
        let myFullEditor;
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
            } )
            .catch( error => {
                console.error( error );
            } );
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


        $('#addNewServiceForm').on('submit', function(e){
            e.preventDefault();

            $('#addNewServiceBtn').attr('disabled', true);
            $('#addNewServiceBtn').text('Please Wait...');

            let formData = new FormData(this);

            let serviceImage = $('#serviceImage').prop('files')[0];
            formData.append('serviceImage', serviceImage);
            formData.append('shortDescription', myShortEditor.getData());
            formData.append('longDescription', myFullEditor.getData());

            $.ajax({
                url:"{{route('admin.create.service')}}",
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
                        }).then( (res) => {
                            if (res.isConfirmed) {

                                $('#addNewServiceForm').trigger("reset");
                                myShortEditor.setData('');
                                myFullEditor.setData('');

                                $('#previewServiceImage').attr('src', "{{asset('assets/img/placeholder.png')}}");

                                $('#addNewServiceBtn').attr('disabled', false);
                                $('#addNewServiceBtn').text('Submit');
                            }
                        
                        });
                    }else{
                        Swal.fire({
                            icon:"error",
                            text: data.message,
                            confirmButtonText: 'Close',
                        });

                        $('#addNewServiceBtn').attr('disabled', false);
                        $('#addNewServiceBtn').text('Submit');
                    }
                },
                error: function(error){
                    Swal.fire({
                        icon:"error",
                        text:'Oops! Something Went Wrong.',
                        confirmButtonText: 'Close',
                    });

                    $('#addNewServiceBtn').attr('disabled', false);
                    $('#addNewServiceBtn').text('Submit');
                }

            });
        });
    </script>
@endsection