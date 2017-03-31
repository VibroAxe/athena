<!DOCTYPE html>
<html>
	@include('layouts.global.head')
<body style="overflow: hidden">
	@include('layouts.global.js')
	@include('layouts.default.nav')
	<iframe src="{{ $src }}" width="100%" height="100%" style="border: 0px" style="margin-top:50px; border:0px;" id=content>
    </iframe>
<script type="application/javascript">

$('#content').on('resize',resizeFrame);

function resizeFrame() {
	iFrame = $('#content');
	
	iFrame.height(window.innerHeight-$('.navbar').height());
	iFrame.css('margin-top',$('.navbar').height());
}

resizeFrame();

</script>
</body>
</html>


