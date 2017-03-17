<body>
  @include('layouts.global.js')
<style>
html, body, form {
    height: 100%;
    margin: 0;         /* Reset default margin on the body element */
    background-color: #000000;
    background-image: url('/Images/ProjectorBackground.png');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: top;
    overflow: hidden;
}

html.image body.image form.image{
   background: url('images/ProjectorBackground.jpg') no-repeat center center fixed; 
   background-color: #000000;
  -webkit-background-size: 100%;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

body.fader {
    -webkit-transition: background 5s linear;
    -moz-transition: background 5s linear;
    -o-transition: background 5s linear;
    -ms-transition: background 5s linear;
    transition: background 5s linear;
}
iframe {
    display: block;       /* iframes are inline by default */

    border: none;         /* Reset default border */
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    overflow-y: hidden;
}

div.bgspacer {
    padding-top: 150px;
    padding-bottom: 150px;
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
    @yield('content')
</body>
