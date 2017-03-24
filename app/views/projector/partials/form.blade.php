{{ ControlGroup::generate(
	Form::label('title', 'Title'),
	Form::text('title',NULL,['placeholder' => 'The title of the slide', 'maxlength' => 255]),
	NULL,
	2,
	9
)->withAttributes( ['class' => 'required'] )
}}
<?php
	$contentactive="";
	$imgactive="";
	$urlactive="";
	if (isset($slide) && $slide != null && $slide->url != "") {
		if (substr($slide->url, 0, 1) === "/") 	{
			$length = strlen($slide->url);
			if (in_array(substr($slide->url, $length-4,$length) , [ ".png", ".jpg", ".gif", "jpeg", "gifv" ])) {
				$imgactive="active";
			} else {
				$urlactive = "active";
			}
		} else {
			$urlactive = "active";
		}
	} else {
		$contentactive="active";
	}
?>

<div class="form-group">
	<label class="control-label col-sm-2 required">
		Content
	</label>
	<div class="col-sm-9">
		<ul class="nav nav-tabs" role-"tablist">
			<li role="presentation" class="{{ $urlactive }}">
				<a href="#url" aria-controls="url" role="tab" data-toggle="tab">Web Site</a>
			</li>
			<li role="presentation" class="{{ $imgactive }}">
				<a href="#img" aria-controls="img" role="tab" data-toggle="tab">Image</a>
			</li>
			<li role="presentation" class="{{ $contentactive }}" id="pagetabli">
				<a href="#content" aria-controls="content" role="tab" data-toggle="tab" id="pagetablink">Page</a>
			</li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane {{ $contentactive }}" id="content">
				{{ ControlGroup::generate(
					Form::label('content', 'HTML'),
					Form::textarea('content',NULL,
					[
						'placeholder' => 'The slide content, markdown formatting enabled.',
						'rows' => 10
					]),
					Form::help('<a href="https://daringfireball.net/projects/markdown/basics" target="_blank">Markdown cheatsheet</a>'),
					1,
					11
				)
				}}
			</div>
			<div role="tabpanel" class="tab-pane {{ $imgactive }}" id="img">
				<div class="form-group">
				    <label for="image" class="control-label col-sm-1">
				        Image
				    </label>
					<div class="col-sm-11">
						<div id="imgbox">
						<?php
						if (isset($slide) && $slide != null && $slide->url != "") {
							if (substr($slide->url, 0, 1) === "/") 	{
								$length = strlen($slide->url);
								if (in_array(substr($slide->url, $length-4,$length) , [ ".png", ".jpg", ".gif", "jpeg", "gifv" ])) {
									echo '<img src="'.$slide->url.'" class="slidepreview img-rounded">';
								}
							}
						}
?>
							<div id="delete" style="position:absolute; top: 0px; right:0px;">
								<a id="clrurl" href="#"><span style="color:red">{{ Icon::remove() }}</span></a>
							</div>
						</div>
				        {{ Form::File("image_file") }}
				        <span class="help-block">Upload an image instead of the slide. Recommended Image Size: 1920x1080</span>
				    </div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane {{ $urlactive }}" id="url">
				<div class="form-group">
				    <label for="image" class="control-label col-sm-1">
				        URL
				    </label>
					<div class="col-sm-10">
						{{ Form::text('url',NULL,['placeholder' => 'Override content with an external url', 'maxlength' => 255, 'id' => 'urlfield']) }}
					</div>
					<div class="col-sm-1">
						<a id="clrurl" href="#"><span style="color:red">{{ Icon::remove() }}</span></a>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
	<script>
		$('#clrurl').click(function(e) { e.preventDefault();
			$('#urlfield').val('');
			$('#imgbox').hide('');
			updatePageContentStatus();
			return false;
		})

		function updatePageContentStatus() {

			if ($('#urlfield').val() == ''	) {
				$('#pagetabli').removeClass('disabled');
				$('#pagetablink').removeClass('disabled');
			} else {
				$('#pagetabli').addClass('disabled');
				$('#pagetablink').addClass('disabled');
			}
		}
		updatePageContentStatus();
		$('#urlfield').on('input',updatePageContentStatus);

		$(".nav-tabs a[data-toggle=tab]").on("click", function(e) {
			  if ($(this).hasClass("disabled")) {
				      e.preventDefault();
					      return false;
			  }
		});
	</script>




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
