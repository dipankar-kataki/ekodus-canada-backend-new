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
            <form id="addNewBlogForm">
                <div class="mb-3">
                    <label for="blogTitle" class="form-label">Enter Title</label>
                    <input type="text" class="form-control" id="blogTitle" name="title" placeholder="e.g Benefits of Omega 3" required>
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
            })
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection