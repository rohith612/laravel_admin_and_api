@extends('layouts.app')

@section('content')
<div class="container">
   

    <div class="row justify-content-center">
        <div class="col-md-12">

            @yield('content', View::make('layouts.alert'))
            
            <div class="card">
                <div class="card-header">{{ __('Create Offer') }}</div>
                <div class="card-body">
                    <form action="{{ route('offers.store') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="offerName">{{ __('Name *') }}</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{old('name')}}" aria-describedby="" placeholder="Enter Offer Name" required>
                            {!! $errors->first('name', '<p class="invalid-feedback" role="alert">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="offerBanner">{{ __('Group *') }}</label>
                            <select class="form-control {{ $errors->has('offer_groups') ? ' is-invalid' : '' }}" name="offer_groups[]" id="offer_groups" multiple >
                                @foreach($customer_group as $item)
                                    <option value="{{$item -> id}}">{{ $item -> name }}</option>
                                @endforeach
                            </select>
                            <small id="emailHelp" class="form-text text-muted">
                            {{ __('Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.') }}
                            </small>
                            {!! $errors->first('offer_groups', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="offerDescription">{{ __('Description') }}</label>
                            <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }} " id="description" name="description" aria-describedby="" value="{{old('description')}}"  placeholder="Enter Offer Description">

                            {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="offerStatus">{{ __('Status *') }}</label>
                            <select class="custom-select {{ $errors->has('offer_status') ? ' is-invalid' : '' }} " id="offer_status" name="offer_status" required>
                                <option value="">SELECT OFFER STATUS</option>
                                @foreach ($offer -> offer_status as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                              </select>
                              {!! $errors->first('offer_status', '<p class="invalid-feedback" role="alert">:message</p>') !!}
                          </div>
                        <div class="form-group">

                            <div class="custom-file">
                                <input type="file" 
                                        class="custom-file-input {{ $errors->has('banner') ? ' is-invalid' : '' }}" 
                                        id="banner" name="banner" required>
                                <label class="custom-file-label" for="customFile">Choose Banner *</label>
                            </div>

                            {!! $errors->first('banner', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            <small id="emailHelp" class="form-text text-muted">
                                {{ __('(jpeg,jpg,png) allowed format only and (10 mb) maximum image size') }}
                            </small>
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
