{{ ControlGroup::generate(
	Form::label('username', 'Origin Username'),
	Form::text('username',NULL,['placeholder' => 'Your Origin username', 'maxlength' => 255]),
 	"Origin currently have no API we can hook into :(<br /> Please enter your origin username above to help others find you and play games",
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

<div class="row">
	<div class="col-md-2 col-md-offset-2">
		{{ Button::normal('Submit')->submit() }}
	</div>
</div>
