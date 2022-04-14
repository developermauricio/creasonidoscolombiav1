@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <aspirant-profile-component :aspirant="{{\App\Models\Aspirant::getDataAspirant(auth()->user()->id)}}"></aspirant-profile-component>
@endsection

