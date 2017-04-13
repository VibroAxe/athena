
<!DOCTYPE html>
<html>
	<head>
		<title>Athena :: Loading</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="shortcut icon" href="https://athena.gg/favicon.png" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	<body>


		  <script type="text/javascript">
var siteUrl = 'https://athena.gg';
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})
		  </script>
		  <style>
iframe {
	    display: block;       /* iframes are inline by default */
			position: absolute;
				    border: none;         /* Reset default border */
						width: 1920px;/* Render at 1920x1080, scale will happen later */
							    height: 1080px;
									    overflow-x: hidden;
											    overflow-y: hidden;
}

div.bgspacer {
	    padding-top: 125px;
			    padding-bottom: 125px;
}

div.sbPost {
	    padding: 5px;
}
div.message {
	    padding: 5px;
			    text-align: center;
					    background-color: #111111;
							    color: #FFFFFF;
}

div.fader {
	    position: absolute;
			    top: 0;
					    left: 0;

							    display: block;       /* iframes are inline by default */

									    border: none;         /* Reset default border */
											    width: 100%;
													height: 100%;
}
		  </style>
		      <style>
img.projector-logo-bg {
	width:128px;
		height:128px;
			position:absolute;
				top: 0px;
					left:0px;
						z-index: 97;
}rojector-logo-fg {
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

@keyframes  rotateRight {
	/*0%{ transform:rotate(0deg); transform-origin:50% 50%; }
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
			          <div id="slideDiv1" class="fader" style="display: block">
						              <iframe id="slideFrame1" scrolling="no" src="https://offline.athena.gg/content.html">
										      
										              </iframe>
						</div>
																	  <script>
function rescaleFrames() {
	$height = $(window).height();
	$width = $(window).width();
	$scaleFactorY = $height/1080;
	$scaleFactorX = $width/1920;
	$frames = $("iframe");
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
}


$(document).ready(function () {
	rescaleFrames();
});

$(window).resize(rescaleFrames);

function reloadPage() {
	location.reload(true);
}
        </script>
	</body>
</html>

