@extends('layouts.default')
@section('content')
	@if ( Config::get('lanager/pages.showPageTitles',true) )
	@include('layouts.default.title')
	@endif
	@include('layouts.default.alerts')

	{{ Purifier::clean(Markdown::string($page->content), 'markdown') }}

	@if (!empty($page->children))
		<?php $children = $page->children()->orderBy(DB::raw('ISNULL(position)'))->get(); ?>
		<ul>
			@foreach($children as $child)
				<li>{{ link_to_route('pages.show',$child->title, ['id' => $child->id, 'prettyname' => str_replace([" "],["-"],$child->title)]) }}</li>
			@endforeach
		</ul>
	@endif
	
	@include('buttons.edit', ['resource' => 'pages', 'item' => $page] )
	@include('buttons.destroy', ['resource' => 'pages', 'item' => $page] )

@endsection				
