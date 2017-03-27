{{ ControlGroup::generate(
	Form::label('title', 'Title'),
	Form::text('title',NULL,['placeholder' => 'The title of the link', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

{{ ControlGroup::generate(
	Form::label('shorttitle', 'Short Title'),
	Form::text('shorttitle',NULL,['placeholder' => 'The link to append after athena.gg/', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

{{ ControlGroup::generate(
	Form::label('url', 'URL'),
	Form::text('url',NULL,['placeholder' => 'The url to link to']),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

<div class="form-group">
	<label for="active" class="control-label col-sm-2">Active</label>
	<div class="checkbox col-sm-9">
		<label>
			{{ Form::hidden( 'published', '0' ) }}
			{{ Form::checkbox( 'published', true, true ) }} Active
		</label>
		{{ Form::help('Sets whether this page is currently active and therefore visible to everyone') }}
	</div>
</div>

<div class="row">
	<div class="col-md-2 col-md-offset-2">
		{{ Button::normal('Submit')->submit() }}
	</div>
</div>
