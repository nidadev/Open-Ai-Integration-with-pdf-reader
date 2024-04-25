<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    @livewireStyles
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-4.3.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5" style="max-width:500px">
    <div class="alert alert-warning mb-4 text">upload file</div>
   
<form id="Fileuploadform" method="post" action="{{url('upload-pdf')}}" enctype="multipart/form-data">
@csrf
<div class="form-group mb-3">
    <input type="file" name="file" class="form-controller">
    <div class="d-grid mb-3"><input type="submit" name="Submit" class="btn btn-primary"></div>
</div>
<div class="form-group mb-3">
<div class="progress" role="progressbar" aria-label="Danger example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
  <div class="progress-bar bg-danger" style="width:0%"></div>
</div>
</div>
</div>

</form>
<script>
     // wait for the DOM to be loaded
     $(function() {
       // bind 'myForm' and provide a simple callback function
       $('#Fileuploadform').ajaxForm(function() {
           //alert("Thank you for your comment!");
           beforeSend:function() {
            var percentage = 0;
           },
           uploadProgress:function(event,position,total,percentageComplete)
           {
            var percentage = percentageComplete;
            $('.progress .progress-bar').css("width" , percentage+'%',function(){
                return $(this).attr('aria-valuenow',percentage)+ '%';
            })
           },
           complete:function(xhr)
           {
            console.log('file uploaded');
           }
        })
       })
   </script>
    @livewireScripts
</body>
</html>