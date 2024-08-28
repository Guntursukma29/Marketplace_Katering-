@extends('layouts.template')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Search Filters -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Filter Options') }}
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('catering.search') }}">
                            <!-- Location -->
                            <div class="mb-3">
                                <label for="location" class="form-label">{{ __('Location') }}</label>
                                <input id="location" type="text" class="form-control" name="location"
                                    value="{{ request('location') }}">
                            </div>

                            <!-- Food Type -->
                            <div class="mb-3">
                                <label for="food_type" class="form-label">{{ __('Food Type') }}</label>
                                <input id="food_type" type="text" class="form-control" name="food_type"
                                    value="{{ request('food_type') }}">
                            </div>

                            <!-- Search Button -->
                            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Catering Results -->
            <div class="col-md-8">
                <div class="row">
                    @forelse ($menus as $menu)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <!-- Centered Image -->
                                    <img src="{{ asset('storage/' . $menu->photo) }}" class="card-img-top"
                                        style="width: 100px; height: auto;" alt="{{ $menu->name }}">
                                    <h5 class="card-title mt-3">{{ $menu->name }}</h5>
                                    <p class="card-text">{{ $menu->description }}</p>
                                    <p class="card-text"><strong>Price:</strong> ${{ $menu->price }}</p>
                                    <a href="{{ route('customer.orders.create', ['menu_id' => $menu->id]) }}"
                                        class="btn btn-primary">{{ __('Order Now') }}</a>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="alert alert-info">{{ __('No catering options found.') }}</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
