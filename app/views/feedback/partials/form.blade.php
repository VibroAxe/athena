
{{ ControlGroup::generate(
	Form::label('feedback', 'Feedback'),
	Form::textarea('feedback',NULL,
	[
		'placeholder' => 'Any feedback you wish to give on Athena, good bad or ugly all is welcome',
		'rows' => 10
	]),
	NULL,
	2,
	9
	)
	}}

{{ ControlGroup::generate(
Form::label('priority', 'Priority'),
Form::select('priority', [ 'General Feedback', 'Feature Request', 'Bug' ] ),
Form::help('What priority is this feedback'),
2,
9
)
}}

<div class="row">
	<div class="col-md-2 col-md-offset-2">
		{{ Button::normal('Submit')->submit() }}
	</div>
</div>
