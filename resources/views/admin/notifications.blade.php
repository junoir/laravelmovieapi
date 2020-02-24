@extends('layouts.admin')

@section('content')
            <!-- Breadcrumb-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('admin')}}">Home</a>
                </li>
                <li class="breadcrumb-item active">Notifications</li>
            </ol>
            <div class="container-fluid">
                <notifications-component></notifications-component>
            </div>

@endsection
