@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">{{$cmsPageDetails['title']}}</li>
    </ul>
	<h3>{{$cmsPageDetails['title']}}</h3>	
	<hr class="soft"/>
	<h5>{{$cmsPageDetails['meta_title']}}</h5><br/>
	<h5>{{$cmsPageDetails['meta_description']}}</h5><br/>
	<h5>{{$cmsPageDetails['meta_keywords']}}</h5><br/>
	<p> <?php echo nl2br($cmsPageDetails['description']); ?></p>
</div>
@endsection