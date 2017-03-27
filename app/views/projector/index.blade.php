@extends('layouts.projector')
@section('content')
<style>
img.projector-logo-bg {
	width:128px;
	height:128px;
	position:absolute;
	top: 0px;
	left:0px;
	z-index: 97;
}

img.projector-logo-fg {
	width:108.75px;
	height:108.75px;
	position:absolute;
	top: 0px;
	left:10px;
	z-index: 98;
}
.spin {
	animation: 2.0s rotateRight 1 linear;
}

img.projector-logo-bot {
	width:128px;
	height:128px;
	position:absolute;
	top: 0px;
	left:128px;
	z-index: 99;
}

@keyframes rotateRight {
/*	0%{ transform:rotate(0deg); transform-origin:50% 50%; }
	100%{ transform:rotate(360deg); }*/
	0%{ transform:rotate(0deg); transform-origin:50% 50%; }
	10%{ transform:rotate(017deg); }
	20%{ transform:rotate(051deg); }
	30%{ transform:rotate(097deg); }
	40%{ transform:rotate(151deg); }
	50%{ transform:rotate(208deg); }
	60%{ transform:rotate(262deg); }
	70%{ transform:rotate(308deg); }
	80%{ transform:rotate(342deg); }
	90%{ transform:rotate(360deg); }
	100%{ transform:rotate(360deg); }
}
body {
    height: 100%;
    margin: 0;         /* Reset default margin on the body element */
    background-color: #000000;
    background-image: none;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: top;
    overflow: hidden;
}

</style>
		<script src="{{url()."/js/projector.js"}}"></script> 
		<script src="{{url()."/js/jquery.rotate.1-1.js"}}"></script>
		<div id="logo">
		<img src="/img/athenalogo_bg.png" class="projector-logo-bg">
		<img src="/img/athenalogo_fg.png" class="projector-logo-fg" id="projector-logo-fg">
		</div>
        <div id="slideDiv1" class="fader" style="display: block">
            <iframe id="slideFrame1" scrolling="no" onload="switchFrames()">
    
            </iframe>
        </div>
        <div id="slideDiv2" class="fader" style="display: none">
            <iframe id="slideFrame2" scrolling="no" onload="switchFrames()">
    
            </iframe>
		</div>
<script>
function rescaleFrames() {
	$height = $(window).height();
	$width = $(window).width();
	$scaleFactorY = $height/1080;
	$scaleFactorX = $width/1920;
	$frames = $("iframe");
	$logoimg = $("#logo img");
	if ($scaleFactorX < $scaleFactorY) {
		//scale x
		$scaleFactor = $scaleFactorX;
		$newheight = 1080 * $scaleFactor;
		$newwidth = 1920 * $scaleFactor;
		$offsetY = ($height - $newheight)/2
		$offsetX = 0;
	} else {
		$scaleFactor = $scaleFactorY;
		$newheight = 1080 * $scaleFactor;
		$newwidth = 1920 * $scaleFactor;
		$offsetY = 0;
		$offsetX = ($width - $newwidth)/2
	}
	$offsetTop = ($newheight - 1080) / 2 + ($offsetY);
	$offsetLeft = ($newwidth - 1920) / 2 + ($offsetX);;
	$frames.css("-webkit-transform","scale("+$scaleFactor+")");
	$frames.css("-o-transform","scale("+$scaleFactor+")");
	$frames.css("-moz-transform","scale("+$scaleFactor+")");
	$frames.css("transform","scale("+$scaleFactor+")");
	$frames.css("left",$offsetLeft+"px");
	$frames.css("top",$offsetTop+"px");
	$bgImgOffset = ((128 * $scaleFactor) - 128) /2;
	$fgImgOffset = ((108.75 * $scaleFactor) - 108.75) /2;;
	$logoimg.css("-webkit-transform","scale("+$scaleFactor+")");
	$logoimg.css("-o-transform","scale("+$scaleFactor+")");
	$logoimg.css("-moz-transform","scale("+$scaleFactor+")");
	$logoimg.css("transform","scale("+$scaleFactor+")");
	$('.projector-logo-fg').css("top",($fgImgOffset + $offsetY) + "px");
	$('.projector-logo-fg').css("left",($fgImgOffset + 10*$scaleFactor + $offsetX) + "px");
	$('.projector-logo-bg').css("top",($bgImgOffset + $offsetY) + "px");
	$('.projector-logo-bg').css("left",($bgImgOffset + $offsetX)+ "px");
}

function logo_rotate() {
	if ($('#projector-logo-fg').hasClass('spin')) {
		$('#projector-logo-fg').removeClass('spin');
	} else {
		$('#projector-logo-fg').addClass('spin');
	}
	//setTimeout(logo_rotate,30000);
}

$(document).ready(function () {
	rescaleFrames();
//	setTimeout(logo_rotate,1000);
	setTimeout(reloadPage, 3600000);
});

$(window).resize(rescaleFrames);

function reloadPage() {
	location.reload(true);
}
        </script>
@endsection
