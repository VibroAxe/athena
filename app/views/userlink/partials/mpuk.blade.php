<p>
This form allows you to link to your old MPUKMan account in order to collect legacy account data. This account is seperate to your forum account  and is the one you would have used for ticketing / the seat picker.
</p>

{{ ControlGroup::generate(
	Form::label('username', 'MPUK Username'),
	Form::text('username',NULL,['placeholder' => 'Your MPUK account username', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}


{{ ControlGroup::generate(
	Form::label('email', 'Email'),
	Form::text('email',NULL,['placeholder' => 'The email address on file for your MPUK account', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

{{ ControlGroup::generate(
	Form::label('fullname', 'Full Name'),
	Form::text('fullname',NULL,['placeholder' => 'Your full name on file for your MPUK account', 'maxlength' => 255]),
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
