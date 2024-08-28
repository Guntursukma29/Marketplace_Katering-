@extends('layouts.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Menu Management') }}
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#createMenuModal">Add New Menu</button>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Photo</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $menu)
                                    <tr>
                                        <td>{{ $menu->name }}</td>
                                        <td>{{ $menu->description }}</td>
                                        <td>Rp{{ $menu->price }}</td>
                                        <td><img src="{{ asset('storage/' . $menu->photo) }}" alt="{{ $menu->name }}"
                                                style="width: 100px; height: auto;"></td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editMenuModal{{ $menu->id }}">Edit</button>

                                            <form action="{{ route('merchant.menu.destroy', $menu) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Menu Modal -->
                                    <div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1"
                                        aria-labelledby="editMenuModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('merchant.menu.update', $menu->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="{{ $menu->id }}">
                                                        <div class="mb-3">
                                                            <label for="editName" class="form-label">Name</label>
                                                            <input type="text" class="form-control" id="editName"
                                                                name="name" value="{{ $menu->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editDescription"
                                                                class="form-label">Description</label>
                                                            <textarea class="form-control" id="editDescription" name="description" required>{{ $menu->description }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editPrice" class="form-label">Price</label>
                                                            <input type="number" class="form-control" id="editPrice"
                                                                name="price" step="0.01" value="{{ $menu->price }}"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editPhoto" class="form-label">Photo</label>
                                                            <input type="file" class="form-control" id="editPhoto"
                                                                name="photo">
                                                            @if ($menu->photo)
                                                                <img src="{{ asset('storage/' . $menu->photo) }}"
                                                                    alt="Current Photo"
                                                                    style="width: 100px; height: auto; margin-top: 10px;">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update Menu</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Menu Modal -->
    <div class="modal fade" id="createMenuModal" tabindex="-1" aria-labelledby="createMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMenuModalLabel">Add New Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('merchant.menu.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
