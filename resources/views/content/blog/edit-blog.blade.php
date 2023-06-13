@extends('layout.layout')
@section('title', 'Edit Blog Details')
@section('custom-css')
    <style>
        #editBlogDetailsImage{
            border-radius:5px 5px 0px 0px;
            height:500px;
            object-fit:cover;
            object-position:top;
            width:100%;
            border:1px solid rgb(223, 223, 223);
            margin-bottom:10px;
        }

        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 300px;
        }
    </style>
@endsection
@section('content')
    <a href="{{route('admin.view.all.blog')}}" class="btn btn-icon btn-secondary mb-3">
        <span class="bx bx-home"></span>
    </a>
    <div class="card">
        <h5 class="card-header">Edit Blog</h5>
        <div class="card-body">
            <form id="editBlogForm" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{encrypt($blog_details->id)}}">
                <div class="mb-3">
                    <label for="blogTitle" class="form-label">Enter Title</label>
                    <input type="text" class="form-control" id="blogTitle" name="title" placeholder="e.g Benefits of Omega 3" maxlength="100" value="{{$blog_details->title}}">
                </div>
                <div class="mb-3">
                    <label for="blogImage" class="form-label">Select Blog Image</label>
                    <img src="{{asset($blog_details->image)}}" alt="blog Image" id="editBlogDetailsImage">
                    <input class="form-control" type="file" name="blogImage" id="blogImage" accept=".png, .jpg, .jpeg" placeholder="Select Image" required>
                </div>
                <div class="mb-3">
                    <label for="editor" class="form-label">Enter Content</label>
                    <div id="editor"></div>
                </div>
                <div class="mb-3">
                    <label for="blogTitle" class="form-label">Change Visibility</label>
                    <select name="status" id="status" class="form-control">
                        <option value="{{$blog_details->status}}" selected>
                            @if ($blog_details->status === 1)
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
                    <button type="submit" class="btn btn-md btn-primary" id="editBlogBtn" style="float:right;">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('custom-scripts')
    <script>
         let myEditor;
        $(document).ready( () => {
           
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
                    const content = "{!! $blog_details->content !!}";
                    const escaped_content = content.replace(/"/g, '\\"');

                    myEditor.setData(escaped_content);
                } )
                .catch( error => {
                    console.error( error );
                } );
        });

        $('#blogImage').on('change', function(){
            let file = this.files[0];

            if(file){
                let reader = new FileReader();
                reader.onload = function(event){
                    $('#editBlogDetailsImage').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
        
    </script>

    <script>
        $('#editBlogForm').on('submit', function(e){
            e.preventDefault();

            $('#editBlogBtn').attr('disabled', true);
            $('#editBlogBtn').text('Please Wait...');

            let formData = new FormData(this);

            let blogImage = $('#blogImage').prop('files')[0];
            formData.append('blogImage', blogImage);
            formData.append('blogContent', myEditor.getData());

            $.ajax({
                url:"{{route('admin.edit.blog')}}",
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

                                $('#editBlogForm').trigger("reset");

                                $('#editBlogBtn').attr('disabled', false);
                                $('#editBlogBtn').text('Submit');
                            }
                        
                        });
                    }else{
                        Swal.fire({
                            icon:"error",
                            text: data.message,
                            confirmButtonText: 'Close',
                        });

                        $('#editBlogBtn').attr('disabled', false);
                        $('#editBlogBtn').text('Submit');
                    }
                },
                error: function(error){
                    Swal.fire({
                        icon:"error",
                        text:'Oops! Something Went Wrong.',
                        confirmButtonText: 'Close',
                    });

                    $('#editBlogBtn').attr('disabled', false);
                    $('#editBlogBtn').text('Submit');
                }

            });
        });
    </script>
@endsection