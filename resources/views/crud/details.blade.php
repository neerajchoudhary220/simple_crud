@extends('crud_master.master')
@push('custom-css')
<style>
    .profile-card {
      /* max-width: 400px; */
      margin: 2rem auto;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }
    .profile-card img {
      border-radius: 50%;
      width: 100px;
      height: 100px;
      object-fit: cover;
    }
    .profile-card .card-body {
      text-align: center;
    }
  </style>
@endpush
@section('contents')
@php $image =  $student->image? Storage::url($student->image):asset('assets/images/placeholder.webp'); @endphp
<div class="card profile-card">
    <div class="card-header">
        <a href="{{ route('crud') }}" class="btn btn-warning text-white">Back</a>
    </div>
    <div class="card-body">
      <img src="{{ $image }}" alt="Profile Image" class="img-fluid">
      <h4 class="card-title mt-3">{{ $student->name }}</h4>
      <p class="card-text"><strong>Email:</strong> {{ $student->email }}</p>
    </div>
  </div>
@endsection

