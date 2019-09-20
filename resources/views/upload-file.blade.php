@extends('layouts.app')
@section('content')
<div class="px-2 py-4 upload">
    <h4 class="font-weight-bold text-blue pb-2">Upload File</h4>
    <p class="text-grey">Please download the below template and upload the filled template to add any new firm details to the application.</p>
    <button class="btn btn-outline-secondary btn-sm br-40 mr-2 px-3 fs-12 mb-4">Download Template</button>
    <div class="row">
        <div class="col-md-12">
            <form action="upload.php" method="POST">
                <input type="file" multiple accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                <div class="dropzone mt-3 d-flex flex-column align-items-center justify-content-center">
                    <img src="img/file-upload.png" alt="Recdirec" width="150" class="mb-4">
                    <h3 class="text-grey font-weight-bold mb-3">Drag and drop or click here</h3>
                    <h4 class="text-grey mb-4">to upload data (max 2MB)</h4>
                </div>
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
  $('form input').change(function () {
    $('form div').text(this.files[0].name + " uploaded successfully");
  });
});
</script>
@endsection