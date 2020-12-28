@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3" style="text-align: center;">
               
                        <div class="card-body" >
                          <h5 class="card-title">{{ $info_panel['customers'] }}</h5>
                          <p class="card-text ">{{ _('Total Customers') }}</p>
                        </div>
                      </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3" style="text-align: center;">
               
                        <div class="card-body">
                          <h5 class="card-title">{{ $info_panel['groups'] }}</h5>
                          <p class="card-text">{{ _('Total Groups') }}</p>
                        </div>
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3" style="text-align: center;">
               
                        <div class="card-body">
                          <h5 class="card-title">{{ $info_panel['offers'] }}</h5>
                          <p class="card-text">{{ _('Total Offers') }}</p>
                        </div>
                      </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action list-group-item-primary"
                        style="text-align: center;">Customers</li>
                        <li class="list-group-item ">Dapibus ac facilisis in</li>
                        <li class="list-group-item ">Morbi leo risus</li>
                        <li class="list-group-item ">Porta ac consectetur ac</li>
                        <li class="list-group-item ">Vestibulum at eros</li>
                      </ul>
                </div>
                <div class="col-md-4">
                  <ul class="list-group">
                    <li class="list-group-item list-group-item-action list-group-item-primary"
                    style="text-align: center;"
                    >Groups</li>
                    <li class="list-group-item ">Dapibus ac facilisis in</li>
                    <li class="list-group-item ">Morbi leo risus</li>
                    <li class="list-group-item ">Porta ac consectetur ac</li>
                    <li class="list-group-item ">Vestibulum at eros</li>
                    </ul>
              </div>
              <div class="col-md-4">
                <ul class="list-group">
                  <li class="list-group-item list-group-item-action list-group-item-primary"
                  style="text-align: center;"
                  >Offers</li>
                  <li class="list-group-item ">Dapibus ac facilisis in</li>
                  <li class="list-group-item ">Morbi leo risus</li>
                  <li class="list-group-item ">Porta ac consectetur ac</li>
                  <li class="list-group-item ">Vestibulum at eros</li>
                  </ul>
            </div>
            </div>
            
            
              
         
        </div>
    </div>
</div>
@endsection
