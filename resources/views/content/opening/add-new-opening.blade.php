@extends('layout.layout')
@section('title', 'Add New Opening')
@section('custom-css')
    <style>
        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 300px;
        }
    </style>
@endsection
@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Add New Opening</h5>
        <div class="card-body">
            <form id="addNewOpeningForm">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Enter Job Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="e.g Frontend Developer Required" maxlength="30">
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Enter Job Location</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="e.g Canada">
                </div>
                <div class="mb-3">
                    <label for="experience" class="form-label">Enter Job Experience In Years</label>
                    <input type="number" class="form-control" id="experience" name="experience" placeholder="e.g 12">
                </div>
                <div class="mb-3">
                    <label for="shift" class="form-label">Select Shift</label>
                    <select class="form-select" id="shift" name="shift">
                      <option selected="">- Select -</option>
                      <option value="Full Time">Full Time</option>
                      <option value="Part Time">Part Time</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="editor" class="form-label">Enter Job Description</label>
                    <div id="jobDescriptionEditor"></div>
                </div>
                <div>
                    <button type="submit" class="btn btn-md btn-primary" id="addNewOpeningBtn" style="float:right;">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('custom-scripts')
    <script>
        let myJobDescriptionEditor;
        ClassicEditor
            .create( document.querySelector( '#jobDescriptionEditor' ),{
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
                myJobDescriptionEditor = editor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
    <script>
        $('#addNewOpeningForm').on('submit', function(e){
            e.preventDefault();

            $('#addNewOpeningBtn').attr('disabled', true);
            $('#addNewOpeningBtn').text('Please Wait...');

            let formData = new FormData(this);

            formData.append('jobDescription', myJobDescriptionEditor.getData());

            $.ajax({
                url:"{{route('admin.create.openings')}}",
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

                                $('#addNewOpeningForm').trigger("reset");
                                myJobDescriptionEditor.setData('');

                                $('#addNewOpeningBtn').attr('disabled', false);
                                $('#addNewOpeningBtn').text('Submit');
                            }
                        
                        });
                    }else{
                        Swal.fire({
                            icon:"error",
                            text: data.message,
                            confirmButtonText: 'Close',
                        });

                        $('#addNewOpeningBtn').attr('disabled', false);
                        $('#addNewOpeningBtn').text('Submit');
                    }
                },
                error: function(error){
                    Swal.fire({
                        icon:"error",
                        text:'Oops! Something Went Wrong.',
                        confirmButtonText: 'Close',
                    });

                    $('#addNewOpeningBtn').attr('disabled', false);
                    $('#addNewOpeningBtn').text('Submit');
                }

            });
        });
    </script>
@endsection