@extends('layout.layout')
@section('title', 'Add New Blog')
@section('custom-css')
    <style>
        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 300px;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <h5 class="card-header">Add New Blog</h5>
        <div class="card-body">
            <form id="addNewBlogForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="blogTitle" class="form-label">Enter Title</label>
                    <input type="text" class="form-control" id="blogTitle" name="title" placeholder="e.g Benefits of Omega 3" maxlength="80" required>
                </div>
                <div class="mb-3">
                    <label for="blogImage" class="form-label">Select Blog Image</label>
                    <input class="form-control" type="file" name="blogImage" id="blogImage" placeholder="Select Image" required>
                </div>
                <div class="mb-3">
                    <label for="editor" class="form-label">Enter Content</label>
                    <div id="editor"></div>
                </div>
                <div>
                    <button type="submit" class="btn btn-md btn-primary" id="addNewBlogBtn" style="float:right;">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('custom-scripts')
    <script>
        let myEditor;
        ClassicEditor
            .create( document.querySelector( '#editor' ),{
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
                myEditor = editor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
    <script>
        $('#addNewBlogForm').on('submit', function(e){
            e.preventDefault();

            $('#addNewBlogBtn').attr('disabled', true);
            $('#addNewBlogBtn').text('Please Wait...');

            let formData = new FormData(this);

            let blogImage = $('#blogImage').prop('files')[0];
            formData.append('blogImage', blogImage);
            formData.append('blogContent', myEditor.getData());

            $.ajax({
                url:"{{route('admin.create.blog')}}",
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

                                $('#addNewBlogForm').trigger("reset");
                                myEditor.setData('');

                                $('#addNewBlogBtn').attr('disabled', false);
                                $('#addNewBlogBtn').text('Submit');
                            }
                        
                        });
                    }else{
                        Swal.fire({
                            icon:"error",
                            text: data.message,
                            confirmButtonText: 'Close',
                        });

                        $('#addNewBlogBtn').attr('disabled', false);
                        $('#addNewBlogBtn').text('Submit');
                    }
                },
                error: function(error){
                    Swal.fire({
                        icon:"error",
                        text:'Oops! Something Went Wrong.',
                        confirmButtonText: 'Close',
                    });

                    $('#addNewBlogBtn').attr('disabled', false);
                    $('#addNewBlogBtn').text('Submit');
                }

            });
        });
    </script>
@endsection