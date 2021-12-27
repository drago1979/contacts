@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success " role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        @can('update-delete-store')
                            <h4 class="text-center my-5">And you are very, very welcome</br>
                                our MIGHTY administrator.</h4>

                            <a href='{{ route('contacts.edit_all') }}' class="btn btn-success rounded-pill mb-2">

                                Click to view or change contacts....
                            </a>
                            @else
                                <h4 class="text-center my-5">And you are just regulary welcome.</h4>
                                    <p>(Not as much as you would be if you were administrator.)</p>

                                <a href='{{ route('contacts.edit_all') }}' class="btn btn-success rounded-pill mb-2">

                                    Click to view contacts....
                                </a>

                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
