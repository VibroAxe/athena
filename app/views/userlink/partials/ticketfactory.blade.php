
{{ ControlGroup::generate(
	Form::label('email', 'Email'),
	Form::text('email',NULL,['placeholder' => 'The email address on file for your TF account', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

{{ ControlGroup::generate(
	Form::label('fullname', 'Full Name'),
	Form::text('fullname',NULL,['placeholder' => 'Your full name on file for your TF account', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

<div class="row">
	<div class="col-md-2 col-md-offset-2">
		{{ Button::normal('Submit')->submit() }}
	</div>
</div>
