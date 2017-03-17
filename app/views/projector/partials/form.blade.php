{{ ControlGroup::generate(
	Form::label('title', 'Title'),
	Form::text('title',NULL,['placeholder' => 'The title of the slide', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

{{ ControlGroup::generate(
	Form::label('url', 'URL'),
	Form::text('url',NULL,['placeholder' => 'Override content with an external url', 'maxlength' => 255]),
	NULL,
	2,
	9
)
}}


{{ ControlGroup::generate(
	Form::label('content', 'Content'),
	Form::textarea('content',NULL,
	[
		'placeholder' => 'The slide content, markdown formatting enabled.',
		'rows' => 10
	]),
	Form::help('<a href="https://daringfireball.net/projects/markdown/basics" target="_blank">Markdown cheatsheet</a>'),
	2,
	9
)
}}

{{ ControlGroup::generate(
	Form::label('timespan', 'Time Span'),
	Form::text('timespan',NULL,['placeholder' => 'The time in seconds to show the slide for', 'maxlength' => 10]),
	NULL,
	2,
	9
)
}}

{{ ControlGroup::generate(
	Form::label('position', 'Position'),
	Form::text('position',NULL,['placeholder' => 'The position of the page in the rotation', 'maxlength' => 10]),
	Form::help('This number determines the order of the slide in the proejction sequence'),
	2,
	9
)
}}

{{ ControlGroup::generate(
  Form::label('startdate', 'Start Date'),
  View::make('datetimepicker', ['name' => 'startdate'] ),
  Form::help('Leave blank to have no date/time restrictions'),
  2,
  9
) }}

{{ ControlGroup::generate(
  Form::label('enddate', 'End Date'),
  View::make('datetimepicker', ['name' => 'enddate'] ),
  Form::help('Leave blank to have no date/time restrictions'),
  2,
  9
) }}


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
