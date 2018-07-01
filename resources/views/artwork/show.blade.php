@extends('layouts.app')
@section('content')
<div class="d-flex flex-column h-low align-items-center justify-content-center text-light" style="background-image:url({{$contest->background_image}})">
	<div class="container text-center">
		<img src="/storage/{{$contest->logo_image}}" width="300" alt="Reinventando el Plástico">
	</div>
	<!--div class="container">
		<div class="artwork-title"><h1>{{$artwork->title}}</h1></div>
		<div class="artwork-author"><p>@lang('lang.by'): {{$contestant->name}} {{$contestant->last_name}} – {{$artwork->category->name}} {{$artwork->category->contest->year}}</p></div>
	</div-->
</div>
<div class="pt-4">
	<div class="container">
		<div class="row">
			<div class="col text-center">
				<p>{{$contestant->name}} {{$contestant->last_name}}, {{ Carbon\Carbon::parse($contestant->dob)->diffInYears($contest->year) }} @lang('lang.yearsOld'), @lang('lang.from') {{ $contestant->representant->countryData->name}} <img src="{{$contestant->representant->flag}}" alt="{{$contestant->representant->country}}"></p>
			</div>
		</div>
		<hr>

		<div class="row">
			<div class="col text-center pb-4">
				<h1 class="text-muted">{{$artwork->title}}</h1>
				<h2 >{!!$artwork->description!!}</h2>
			</div>
		</div>
		<div class="row">
			<div class="col text-center py-4">
				<img src="/storage/{{($artwork->url)}}" class="img-fluid">
			</div>
		</div>
		
		
		@if($artwork->state==='reviewing')
		<hr>
		<div class="row">
			<div class="container py-4">
				<a href="{{ $artwork->pathApprove }}" class="btn btn-wedcontest">@lang('lang.approve')</a>
				<a href="{{ $artwork->pathEdit }}" class="btn btn-wedcontest">@lang('lang.edit')</a>

			</div>
		</div>
		@endif
	</div>
</div>
@endsection
