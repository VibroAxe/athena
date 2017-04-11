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

{{ ControlGroup::generate(
	Form::label('achievement_id', 'Attendance Achievement'),
	Form::select('achievement_id', $achievements),
	Form::help('Select and Achievement to auto grant attendance to users logging in during the event active period'),
	2,
	9
)
}}

{{ ControlGroup::generate(
	Form::label('iprange', 'IP Range'),
	Form::text('iprange',NULL,['placeholder' => 'Valid IP Subnets for the LAN (comma seperated)', 'maxlength' => 255]),
	Form::help('Add subnets here to limit the attendance achievement to only valid users eg: 10.10.8.0/22'),
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

<div class="row">
	<div class="col-md-2 col-md-offset-2">
		{{ Button::normal('Submit')->submit() }}
	</div>
</div>
