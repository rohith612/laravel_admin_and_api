@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @yield('content', View::make('layouts.alert'))

            <div class="card">
                <div class="card-header">{{ __('Edit Customer') }}</div>

                <div class="card-body"> 
                    <form action="{{ route('customers.update', $customer -> id) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                          <label for="number">{{ __('Number *') }}</label>
                        <input type="text" class="form-control {{ $errors->has('number') ? ' is-invalid' : '' }}" id="number" name="number" value="{{$customer-> number}}" aria-describedby="" placeholder="Enter Number" required>
                          {!! $errors->first('number', '<p class="invalid-feedback" role="alert">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="Group" >{{ _('Group *')}}</label>
                            <select  class="custom-select {{ $errors->has('group') ? ' is-invalid' : '' }}" name="group" id="group" required>
                                <option value="">SELECT GROUP</option>
                                @foreach($customer_group as $item)
                                    
                                    <option value="{{$item -> id}}"
                                        @if($customer -> group == $item -> id) selected @endif
                                        >{{ $item -> name }}</option>
                                   
                                @endforeach
                            </select>
                            
                            {!! $errors->first('group', '<p class="invalid-feedback" role="alert">:message</p>') !!}
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('customers.index') }}"  class="btn btn-outline-primary">Back</a>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
