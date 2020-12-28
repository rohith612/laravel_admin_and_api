@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @yield('content', View::make('layouts.alert'))
            
            <div class="card">
                <div class="card-header">{{ __('Group Details') }}</div>

                <div class="card-body">
                    <form action="#" >
                        <div class="form-group row">
                            <label for="groupName" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                            <div class="col-sm-10">
                              <input type="text" readonly class="form-control-plaintext" id="name" value="{{$group_item-> name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="groupDescription" class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                            <div class="col-sm-10">
                              <input type="text" readonly class="form-control-plaintext" id="description" value="{{$group_item-> description}}">
                            </div>
                        </div>
                        
                        <a href="{{ route('groups.index') }}"  class="btn btn-outline-primary">Back</a>
                      </form>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
