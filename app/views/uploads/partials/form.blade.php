{{ ControlGroup::generate(
	Form::label('title', 'Title'),
	Form::text('title',NULL,['placeholder' => 'The title of the link', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}

<div class="form-group required">
        <label for="image" class="control-label col-sm-2">
                Upload
        </label>
        <div class="col-sm-9">
                @if (isset($upload->url))
                	<img src="{{ $upload->image }}" class="achievement-giant">
                @endif
                {{ Form::File("upload_file") }}
                <span class="help-block">Upload a file for use on other pages</span>
        </div>
</div>
<div class="row">
	<div class="col-md-2 col-md-offset-2">
		{{ Button::normal('Submit')->submit() }}
	</div>
</div>

<script>
	$('input[name=upload_file]').on('change',function() {
		var title = $('input[name=title]');
		if (title.val() == "") {
			title.val($('input[name=upload_file]').val().split('\\').pop());
		}
	});
</script>
