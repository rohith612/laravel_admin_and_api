@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @yield('content', View::make('layouts.alert'))

            <div class="card">
                <div class="card-header">{{ __('Customers') }}</div>

                <div class="card-body">
                   
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <form method="GET" action="{{route('customers.index')}}" accept-charset="UTF-8" class="navbar-form navbar-right" role="search">
                                <div class="input-group mb-3 pull-right">
                                    <input type="text" class="form-control" placeholder="Search offer" aria-label="Search offer" name="k"  value="{{Request::get('k')}}" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">{{ __('Search') }}</button>
                                    </div>
                                    @if (Request::get('k'))
                                        <a href="{{route('customers.index')}}" class="btn btn-link">X</a>
                                    @endif
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
                                    <th scope="col">{{ __('Mobile') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{$item -> number}}</td>
                                        <td>

                                            <a href="{{ route('customers.show', $item -> id) }}" type="button" class="btn btn-link">{{ __('View') }}</a>

                                            <a href="{{ route('customers.edit', $item -> id) }}" type="button" class="btn btn-link">{{ __('Edit') }}</a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>  
                            {{ $customers->withQueryString()->links() }}
                        </div>
                    </div>        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
