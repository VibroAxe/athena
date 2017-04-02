<dl class="dl-horizontal">
@foreach ($systemSpecs as $spec) 
	<dt>{{ $spec->element }}</dt>
	<dd>{{ $spec->content }}</dt>
@endforeach
</dl>
