@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Offer Details') }}</div>
                <div class="card-body"> 
                    <form action="#" enctype="multipart/form-data" >
                        <div class="form-group row">
                            <label for="offerName" class="col-sm-2 col-form-label">{{ _('Name')}}</label>
                            <div class="col-sm-10">
                              <input type="text" readonly class="form-control-plaintext" id="name" value="{{$offer_item-> name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="offerGroup" class="col-sm-2 col-form-label">{{ _('Group')}}</label>
                            <div class="col-sm-10">
                                <select readonly class="form-control" name="offer_groups" id="offer_groups" multiple >
                                    @foreach($customer_group as $item)
                                        <option value="{{$item -> id}}" 
                                            @foreach($offer_item-> offer_groups as $map)
                                                @if($item->id == $map->group_id) 
                                                    selected 
                                                @endif  
                                            @endforeach
                                        >{{ $item -> name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="offerDescription" class="col-sm-2 col-form-label">{{ _('Description')}}</label>
                            <div class="col-sm-10">
                              <input type="text" readonly class="form-control-plaintext" id="name" value="{{$offer_item-> description}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="offerStatus" class="col-sm-2 col-form-label">{{ _('Status')}}</label>
                            <div class="col-sm-10">
                              <input type="text" readonly class="form-control-plaintext" id="name" value=" {{ $offer_item -> offer_status[$offer_item -> validity] }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="offerBanner" class="col-sm-2 col-form-label">{{ _('Banner')}}</label>
                            <div class="col-sm-10">
                                <a href="{{asset('storage/banner/'.$offer_item->banner_image)}}" target="_blank" rel="noopener noreferrer">{{ __('Click here | ' . $offer_item->banner_image)  }}</a>
                                {{-- <img src="{{asset('storage/banner/'.$offer_item->banner_image)}}" width="300"> --}}
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('offers.index') }}"  class="btn btn-outline-primary">{{ _('Back')}}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
