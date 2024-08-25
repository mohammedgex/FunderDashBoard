@extends ('layout')
@section('content')
<h1>Receipts</h1>
<div class="container">
  @foreach ($receipts as $receipt)
  @if ($receipt->status === 'pending')
  <div class="card mt-3" style="border:3px solid rgba(236, 138, 35, 1);">
    @elseif($receipt->status === 'rejected')
    <div class="card mt-3" style="border:3px solid rgba(160, 27, 37, 1);">
      @elseif($receipt->status === 'accepted')
      <div class="card mt-3" style="border:3px solid rgba(53, 169, 58, 1);">
        @endif
        <div class="card-body">
          <p>{{$receipt->created_at->formatLocalized('%d %B %Y')}}</p>
          <h3 class="card-title">username : {{$receipt->user->name}}</h3>
          <h5 class="card-text">property name : {{$receipt->property->name}}</h5>
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{route('receipts.show', $receipt->id)}}" class="btn btn-primary">read more</a>
            @if ($receipt->status === 'pending')
            <p style="color: rgba(236, 138, 35, 1);" class="my-auto">{{$receipt->status}}</p>
            @elseif($receipt->status === 'rejected')
            <p style="color: rgba(160, 27, 37, 1);" class="my-auto">{{$receipt->status}}</p>
            @elseif($receipt->status === 'accepted')
            <p style="color: rgba(53, 169, 58, 1);" class="my-auto">{{$receipt->status}}</p>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endsection