@extends('layout.layout')
@section('title', 'Add New Product')
@section('custom-css')
    <style>
        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 300px;
        }

        #previewProductImage{
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
            <form id="addNewProductForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="productTitle" class="form-label">Enter Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="e.g H.R Management" maxlength="100" required>
                </div>
                <div class="mb-3">
                    <label for="productImage" class="form-label">Select Product Image</label>
                    <img src="{{asset('assets/img/placeholder.png')}}" alt="Product Image" id="previewProductImage">
                    <input class="form-control" type="file" name="productImage" id="productImage" accept=".png, .jpg, .jpeg" placeholder="Select Image" required>
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
                    <button type="submit" class="btn btn-md btn-primary" id="addNewProductBtn" style="float:right;">Submit</button>
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

        $('#productImage').on('change', function(){
            let file = this.files[0];

            if(file){
                let reader = new FileReader();
                reader.onload = function(event){
                    $('#previewProductImage').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });


        $('#addNewProductForm').on('submit', function(e){
            e.preventDefault();

            $('#addNewProductBtn').attr('disabled', true);
            $('#addNewProductBtn').text('Please Wait...');

            let formData = new FormData(this);

            let productImage = $('#productImage').prop('files')[0];
            formData.append('productImage', productImage);
            formData.append('shortDescription', myShortEditor.getData());
            formData.append('longDescription', myFullEditor.getData());

            $.ajax({
                url:"{{route('admin.create.product')}}",
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

                                $('#addNewProductForm').trigger("reset");
                                myShortEditor.setData('');
                                myFullEditor.setData('');

                                $('#previewProductImage').attr('src', "{{asset('assets/img/placeholder.png')}}");

                                $('#addNewProductBtn').attr('disabled', false);
                                $('#addNewProductBtn').text('Submit');
                            }
                        
                        });
                    }else{
                        Swal.fire({
                            icon:"error",
                            text: data.message,
                            confirmButtonText: 'Close',
                        });

                        $('#addNewProductBtn').attr('disabled', false);
                        $('#addNewProductBtn').text('Submit');
                    }
                },
                error: function(error){
                    Swal.fire({
                        icon:"error",
                        text:'Oops! Something Went Wrong.',
                        confirmButtonText: 'Close',
                    });

                    $('#addNewProductBtn').attr('disabled', false);
                    $('#addNewProductBtn').text('Submit');
                }

            });
        });
    </script>
@endsection