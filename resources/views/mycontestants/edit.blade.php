@extends('layouts.app')
@section('content')
@include('layouts.assets.headerStandart')
<div class="pt-6">
   <div class="content">
   <contestant-edit-form put-to="{{ route('mycontestants.update',$contestant->id) }}" :contestant="{{ $contestant }}" :categories="{{$categories}}"></contestant-edit-form>
   </div>
</div>
@endsection