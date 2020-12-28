@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @yield('content', View::make('layouts.alert'))

            <div class="card">
                <div class="card-header">{{ __('Offers') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{ route('offers.create') }}" class="btn btn-outline-primary" type="button" id="button-addon2">Add New</a>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-4">
                                <form method="GET" action="{{route('offers.index')}}" accept-charset="UTF-8" class="navbar-form navbar-right" role="search">
                                    <div class="input-group mb-3 pull-right">
                                        <input type="text" class="form-control" placeholder="Search offer" aria-label="Search offer" name="k"  value="{{Request::get('k')}}" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">{{ __('Search') }}</button>
                                        </div>
                                        @if (Request::get('k'))
                                            <a href="{{route('offers.index')}}" class="btn btn-link">X</a>
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
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($offers_items as $item)
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
                                                
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{ $item-> id }}"
                                                    
                                                    @if(($res = $item -> validity - 1))
                                                        checked
                                                    @endif
                                                    onclick="changeStatus({{ $item-> id }})"
                                                    >
                                                    <label class="custom-control-label" for="customSwitch{{ $item-> id }}">{{ $item -> offer_status[$item -> validity] }}</label>
                                                  </div>
                                               
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('offers.send_notification') }}" accept-charset="UTF-8" style="display:inline">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item -> id }}">
                                                    <button type="submit" class="btn btn-outline-primary">{{ __('Send Notification') }}</button>
                                                </form>

                                                <a href="{{ route('offers.show', $item -> id) }}" type="button" class="btn btn-link">{{ __('View') }}</a>


                                                <a href="{{ route('offers.edit', $item -> id) }}" type="button" class="btn btn-link">{{ __('Edit') }}</a>

                                                <form method="POST" action="{{ route('offers.destroy', $item -> id) }}" accept-charset="UTF-8" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link" title="Delete" onclick="return confirm('Are you sure?')">{{ __('Delete') }} </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>  
                                {{ $offers_items->withQueryString()->links() }}
                            </div>
                        </div>      
                    </div>
            </div>
        </div>
    </div>
</div>


@section('scripts')
    <script>
        function changeStatus(id){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {   
                if (xhttp.readyState == 4 && xhttp.status==200){
                    var jsonParsedArray = JSON.parse(xhttp.responseText);
                    if (jsonParsedArray['success'])
                        location.reload();   
                    else if (jsonParsedArray['error'])
                        alert('Error on updating offer');
                }
            }
            xhttp.open("POST", "{{ route('offers.update_offer_status') }}", true);
      
            xhttp.setRequestHeader("Access-Control-Allow-Origin", '*');
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);
            xhttp.send("offer_id="+id);     
        }
        
    </script>
@stop


@endsection
