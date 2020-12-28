@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            @yield('content', View::make('layouts.alert'))

            <div class="card">
                <div class="card-header">{{ __('Edit Group') }}</div>

                <div class="card-body">
                    <form action="{{ route('groups.update', $group_item -> id) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                          <label for="groupName">{{ __('Name *') }}</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{$group_item-> name}}" aria-describedby="" placeholder="Enter Group Name" required>
                          {!! $errors->first('name', '<p class="invalid-feedback" role="alert">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="groupDescription">{{ __('Description') }}</label>
                            <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }} " id="description" name="description" aria-describedby="" value="{{$group_item -> description}}"  placeholder="Enter Group Description">

                            {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('groups.index') }}"  class="btn btn-outline-primary">Back</a>

                      </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
