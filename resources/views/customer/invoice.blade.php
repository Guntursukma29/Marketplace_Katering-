<!-- resources/views/customer/invoice.blade.php -->

@extends('layouts.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Invoice') }}</div>

                    <div class="card-body">
                        <h4>Invoice #{{ $invoice->invoice_number }}</h4>
                        <p>Date: {{ $invoice->invoice_date }}</p>
                        <p>Total Amount: ${{ $invoice->total_amount }}</p>

                        <h5>Order Details</h5>
                        <p>Menu: {{ $invoice->order->menu->name }}</p>
                        <p>Quantity: {{ $invoice->order->quantity }}</p>
                        <p>Delivery Date: {{ $invoice->order->delivery_date }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
