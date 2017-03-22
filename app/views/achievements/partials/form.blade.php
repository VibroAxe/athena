{{ ControlGroup::generate(
	Form::label('name', 'Name'),
	Form::text('name',NULL,['placeholder' => 'The name of the achievement', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

<div class="form-group required">
	<label for="image" class="control-label col-sm-2">
		Image
	</label>
	<div class="col-sm-9">
		@if (isset($achievement->image))
		<img src="{{ $achievement->image }}" class="achievement-image">
		@endif
		{{ Form::File("image_file") }}
		<span class="help-block">Upload an image to act as the achievement icon. Image must be 128x128</span>
	</div>
</div>


{{ ControlGroup::generate(
	Form::label('description', 'Description'),
	Form::text('description',NULL,['placeholder' => 'A description of how to attain the achievement, or what the achievement is']),
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
