@extends('layouts.projector')
@section('content')
        <script src="http://lanager.tnnt.co.uk/js/projector.js"></script> 
        <div id="slideDiv1" class="fader" style="display: block">
            <iframe id="slideFrame1" scrolling="no" onload="switchFrames()">
    
            </iframe>
        </div>
        <div id="slideDiv2" class="fader" style="display: none">
            <iframe id="slideFrame2" scrolling="no" onload="switchFrames()">
    
            </iframe>
        </div>
        <script>
            $(document).ready(function () {
              setTimeout(reloadPage, 3600000);
            });
            function reloadPage() {
              location.reload(true);
            }
        </script>
@endsection
