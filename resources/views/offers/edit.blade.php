@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @yield('content', View::make('layouts.alert'))

            <div class="card">
                <div class="card-header">{{ __('Edit Offer') }}</div>
                <div class="card-body"> 
                    <form action="{{ route('offers.update', $offer_item -> id) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="offerName">{{ _('Name *')}}</label>
                              <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{$offer_item-> name}}" aria-describedby="" placeholder="Enter Offer Name" required>
                              {!! $errors->first('name', '<p class="invalid-feedback" role="alert">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="offerGroup" >{{ _('Group *')}}</label>
                            <select  class="form-control {{ $errors->has('offer_groups') ? ' is-invalid' : '' }}" name="offer_groups[]" id="offer_groups" multiple required>
                                @foreach($customer_group as $item)
                                   
                                        <option value="{{$item -> id}}" 
                                            @foreach($offer_item-> offer_groups as $map)
                                                @if($item->id == $map->group_id) 
                                                    selected 
                                                @endif  
                                            @endforeach>{{ $item -> name }}</option>
                                   
                                @endforeach
                            </select>
                            <small id="emailHelp" class="form-text text-muted">
                                {{ __('Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.') }}
                            </small>
                            {!! $errors->first('offer_groups', '<p class="invalid-feedback" role="alert">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="offerDescription">{{ _('Description')}}</label>
                              <input type="text"  class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" name="description" value="{{$offer_item-> description}}">
                              {!! $errors->first('description', '<p class="invalid-feedback" role="alert">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="offerStatus">{{ __('Status *') }}</label>
                            <select class="custom-select {{ $errors->has('offer_status') ? ' is-invalid' : '' }} " id="offer_status" name="offer_status">
                                <option value="">SELECT OFFER STATUS</option>
                                @foreach ($offer_item -> offer_status as $key => $value)
                                    <option @if($offer_item -> validity == $key) selected @endif value="{{$key}}">{{$value}}</option>
                                @endforeach
                              </select>
                              {!! $errors->first('offer_status', '<p class="invalid-feedback" role="alert">:message</p>') !!}
                          </div>
                        <div class="form-group ">
                            <label for="offerBanner"  class="">{{ _('Banner ')}}</label>
                            <div class="">
                                <a href="{{asset('storage/banner/'.$offer_item->banner_image)}}" target="_blank" rel="noopener noreferrer">{{ __('Click here | ' . $offer_item->banner_image)  }}</a>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" 
                                        class="custom-file-input {{ $errors->has('banner') ? ' is-invalid' : '' }}" 
                                        id="banner" name="banner" 
                                        >
                                <label class="custom-file-label" for="customFile">Change Banner </label>
                            </div>
                            <small id="emailHelp" class="form-text text-muted">
                                {{ __('(jpeg,jpg,png) allowed format only and (10 mb) maximum image size') }}
                            </small>
                            {!! $errors->first('banner', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                           
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        <a href="{{ route('offers.index') }}"  class="btn btn-outline-primary">{{ __('Back') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
