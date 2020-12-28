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
                <div class="card-header">{{ __('Customer Details') }}</div>

                <div class="card-body"> 
                    <form action="#" >
                        <div class="form-group row">
                            <label for="Number" class="col-sm-2 col-form-label">{{ __('Number') }}</label>
                            <div class="col-sm-10">
                              <input type="text" readonly class="form-control-plaintext" id="number" value="{{$customer-> number}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Group" class="col-sm-2 col-form-label">{{ __('Group') }}</label>
                            <div class="col-sm-10">
                                <select  class="form-control-plaintext" name="group" id="group" readonly>
                                    <option value="">SELECT GROUP</option>
                                    @foreach($customer_group as $item)
                                        
                                        <option value="{{$item -> id}}"
                                            @if($customer -> group == $item -> id) selected @endif
                                            >{{ $item -> name }}</option>
                                       
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <a href="{{ route('customers.index') }}"  class="btn btn-outline-primary">Back</a>
                      </form>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
