@extends('vendor.installer.layouts.master')

@section('title', trans('messages.environment.title'))
@section('container')
    @if (session('message'))
        <p class="alert">{{ session('message') }}</p>
    @endif
    <form method="post" action="{{ route('LaravelSetup::environmentSave') }}">
        {!! csrf_field() !!}
        <span style="font-size: 14px;">Database Host:</span>
        <input style="width: 100%" type="text" name="db_host" value="{{env('DB_HOST')}}">
        <span style="font-size: 14px;">Database Name:</span>
        <input style="width: 100%" type="text" name="db_name" placeholder="Enter Database Name" value="{{env('DB_DATABASE')}}">
        <span style="font-size: 14px;">Database Username:</span>
        <input style="width: 100%" type="text" name="db_user" placeholder="Enter Database User" value="{{env('DB_USERNAME')}}">
        <span style="font-size: 14px;">Database Password:</span>
        <input style="width: 100%" type="text" name="db_password" placeholder="Enter Database Password" value="{{env('DB_PASSWORD')}}">
        <div class="buttons buttons--right">
             <button class="button button--light" type="submit">{{ trans('messages.environment.save') }}</button>
        </div>
    </form>
    @if( ! isset($environment['errors']))
        <div class="buttons">
            <a class="button" href="{{ route('LaravelSetup::requirements') }}">
                {{ trans('messages.next') }}
            </a>
        </div>
    @endif
@stop
