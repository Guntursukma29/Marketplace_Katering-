@extends('layouts.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Place Your Order') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('customer.orders.store') }}">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <input type="hidden" name="merchant_id" value="{{ $menu->merchant_id }}">

                            <!-- Menu Name -->
                            <div class="mb-3">
                                <label for="menu_name" class="form-label">{{ __('Menu Name') }}</label>
                                <input id="menu_name" type="text" class="form-control" name="menu_name"
                                    value="{{ $menu->name }}" disabled>
                            </div>

                            <!-- Quantity -->
                            <div class="mb-3">
                                <label for="quantity" class="form-label">{{ __('Quantity (Portions)') }}</label>
                                <input id="quantity" type="number" class="form-control" name="quantity" value="1"
                                    min="1" required>
                            </div>

                            <!-- Delivery Date -->
                            <div class="mb-3">
                                <label for="delivery_date" class="form-label">{{ __('Delivery Date') }}</label>
                                <input id="delivery_date" type="date" class="form-control" name="delivery_date" required>
                            </div>

                            <!-- Total Price -->
                            <div class="mb-3">
                                <label for="total_price" class="form-label">{{ __('Total Price') }}</label>
                                <input id="total_price" type="text" class="form-control" name="total_price"
                                    value="{{ $menu->price }}" readonly>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">{{ __('Place Order') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('quantity').addEventListener('input', function() {
            const pricePerPortion = {{ $menu->price }};
            const quantity = this.value;
            const totalPrice = pricePerPortion * quantity;
            document.getElementById('total_price').value = totalPrice.toFixed(2);
        });
    </script>
@endsection
