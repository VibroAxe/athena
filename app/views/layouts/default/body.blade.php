<body style>
	@include('layouts.global.js')
	@include('layouts.default.nav')
	<div class="container content">
		<div class="panel">
			<div class="panel-body">
				@yield('content')
			</div>
		</div>
	</div>
	@include('layouts.default.footer')
</body>
