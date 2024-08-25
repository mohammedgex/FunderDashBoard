@extends ('layout')
@section('content')
<h1>Receipt</h1>
<div class="container my-4">
  @if(session('error'))
  <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
    {{session('error')}}
  </div>
  @endif
  <h1>username: <a href="{{route('user.show', $receipt->user->id)}}">{{$receipt->user->name}} </a></h1>
  <h1>property:
    <a href="{{route('property.readMore', $receipt->property_id)}}">
      {{$receipt->property->name}}
    </a>
  </h1>
  <div class="image w-75 mx-auto my-5 border border-black">
    <img class="image w-100" src="{{url('uploads/'.$receipt->image)}}" alt="">
  </div>
  <h3>count share: {{$receipt->count_sheres}} share</h3>
  <h3>receipt number: {{$receipt->receipt_number}}</h3>
  <h3>property price: {{$receipt->property->property_price}}</h3>
  <h3>price: {{($receipt->property->property_price * 1 /10 ) * $receipt->count_sheres}}</h3>
  <h3>deposit date: {{\Carbon\Carbon::parse($receipt->deposit_date)->isoFormat('D MMMM YYYY')}}</h3>
  @if ($receipt->status === 'pending')
  <h3 style="color: rgba(236, 138, 35, 1);"><span class="text-black">status:</span> {{$receipt->status}}</h3>
  <div class="d-flex justify-content-around">
    <a href="{{route('receipts.rejected', $receipt->id)}}" class="btn btn-danger btn-sm fs-3 p-2">Reject</a>
    <a href="{{route('receipts.accepted', $receipt->id)}}" class="btn btn-success btn-sm fs-3 p-2">Accept</a>
  </div>
  @elseif($receipt->status === 'rejected')
  <h3 style="color: rgba(160, 27, 37, 1);"><span class="text-black">status:</span> {{$receipt->status}}</h3>
  @elseif($receipt->status === 'accepted')
  <h3 style="color: rgba(53, 169, 58, 1);"><span class="text-black">status:</span> {{$receipt->status}}</h3>
  @endif
</div>
@endsection