@extends('layouts.site', ['header' => 'partials.header', 'footer' => 'partials.footer'])

@section('title', 'Anasayfa')

@section('content')
	@include('templates.home.hero')
	@include('templates.home.services-cards')
	@include('templates.home.why-choose-us')
	@include('templates.home.carousel')
	
	@include('templates.home.solutions')
	@include('templates.home.services-grid')
	@include('templates.home.testimonials')
	@include('templates.home.contact')
@endsection
