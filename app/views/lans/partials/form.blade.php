{{ ControlGroup::generate(
	Form::label('name', 'Name'),
	Form::text('name',NULL,['placeholder' => 'The name of the LAN', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

{{ ControlGroup::generate(
	Form::label('start', 'Start'),
	View::make('datetimepicker', ['name' => 'start'] ),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] ) }}

{{ ControlGroup::generate(
	Form::label('end', 'End'),
	View::make('datetimepicker', ['name' => 'end'] ),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] ) }}

<div>
        <label for="published" class="control-label col-sm-2">Published</label>
        <div class="checkbox col-sm-9">
                <label>
                        {{ Form::hidden( 'published', '0' ) }}
                        {{ Form::checkbox( 'published', true, true ) }} Published
                </label>
                {{ Form::help('Sets whether this LAN is published and therefore visible to everyone') }}
        </div>
</div>


<div class="row">
	<div class="col-md-2 col-md-offset-2">
		{{ Button::normal('Submit')->submit() }}
	</div>
</div>
