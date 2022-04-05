@extends('layouts.app')

@section('title', 'Registro')

@section('content')
{{--    @dd(\App\Models\Aspirant::getDataAspirant(auth()->user()->id))--}}
    <aspirant-profile-component :aspirant="{{\App\Models\Aspirant::getDataAspirant(auth()->user()->id)}}"></aspirant-profile-component>
@endsection

