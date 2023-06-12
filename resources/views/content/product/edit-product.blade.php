@extends('layout.layout')
@section('title', 'Edit Product')
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
        <h5 class="card-header">Edit Product</h5>
        <div class="card-body">
            <form id="editProductForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{encrypt($product_details->id)}}">
                <div class="mb-3">
                    <label for="productTitle" class="form-label">Enter Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="e.g H.R Management" maxlength="100" value="{{$product_details->title}}">
                </div>
                <div class="mb-3">
                    <label for="productImage" class="form-label">Select Product Image</label>
                    <img src="{{asset($product_details->image)}}" alt="product Image" id="previewProductImage">
                    <input class="form-control" type="file" name="productImage" id="productImage" accept=".png, .jpg, .jpeg" placeholder="Select Image">
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
                        <option value="{{$product_details->status}}" selected>
                            @if ($product_details->status === 1)
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
                    <button type="submit" class="btn btn-md btn-primary" id="editProductBtn" style="float:right;">Submit</button>
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
                    myShortEditor.setData("{!! $product_details->short_description !!}");
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
                    myFullEditor.setData("{!! $product_details->full_description !!}");
                } )
                .catch( error => {
                    console.error( error );
                } );
        });


        
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


        $('#editProductForm').on('submit', function(e){
            e.preventDefault();

            $('#editProductBtn').attr('disabled', true);
            $('#editProductBtn').text('Please Wait...');

            let formData = new FormData(this);

            let productImage = $('#productImage').prop('files')[0];
            formData.append('productImage', productImage);
            formData.append('shortDescription', myShortEditor.getData());
            formData.append('longDescription', myFullEditor.getData());

            $.ajax({
                url:"{{route('admin.save.edit.product')}}",
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

                        $('#editProductBtn').attr('disabled', false);
                        $('#editProductBtn').text('Submit');
                    }
                },
                error: function(error){
                    Swal.fire({
                        icon:"error",
                        text:'Oops! Something Went Wrong.',
                        confirmButtonText: 'Close',
                    });

                    $('#editProductBtn').attr('disabled', false);
                    $('#editProductBtn').text('Submit');
                }

            });
        });
    </script>
@endsection