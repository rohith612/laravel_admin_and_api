@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            @yield('content', View::make('layouts.alert'))

            <div class="card">
                <div class="card-header">{{ __('Groups') }}</div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{ route('groups.create') }}" class="btn btn-outline-primary" type="button" id="button-addon2">Add New</a>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-4">
                            <form method="GET" action="{{route('groups.index')}}" accept-charset="UTF-8" class="navbar-form navbar-right" role="search">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search group" aria-label="Search group" name="k" value="{{Request::get('k')}}" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">{{ __('Search') }}</button>
                                    @if (Request::get('k'))
                                        <a href="{{route('groups.index')}}" class="btn btn-link">X</a>
                                    @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('#') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($group_items as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $item -> name }}</td>
                                        <td>
                                            @if($item -> description)
                                                {{ $item -> description }}
                                            @else
                                                <span for="">{{ __('-NO DESCRIPTION-') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('groups.show', $item -> id) }}" type="button" class="btn btn-link">{{ __('View') }}</a>
                                            <a href="{{ route('groups.edit', $item -> id) }}" type="button" class="btn btn-link">{{ __('Edit') }}</a>

                                            <form method="POST" action="{{ route('groups.destroy', $item -> id) }}" accept-charset="UTF-8" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link" title="Delete" onclick="return confirm('Are you sure?')">{{ __('Delete') }} </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>  
                            {{ $group_items->withQueryString()->links() }}
                        </div>
                    </div>


                              
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
