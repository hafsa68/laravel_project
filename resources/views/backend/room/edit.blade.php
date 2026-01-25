@extends("backend.layouts.app")

@section("head")
<head>
    <meta charset="utf-8" />
    <title>Edit Room | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Myra Studio" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('')}}/assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{url('')}}/assets/css/style.min.css" rel="stylesheet" type="text/css">
    <link href="{{url('')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <script src="{{url('')}}/assets/js/config.js"></script>
</head>
@endsection

@section("content")
<div class="container-fluid">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="py-3 py-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="page-title mb-0">
                        <i class="fas fa-edit me-2"></i> Edit Room
                    </h4>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="{{ route('room.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <form method="post" action="{{ route('room.update', $room->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control"
                                       value="{{ old('name', $room->name) }}"
                                       placeholder="Enter room name"
                                       required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="fare" class="form-label">Fare (Price per night) *</label>
                                <input type="number"
                                       name="fare"
                                       id="fare"
                                       class="form-control"
                                       value="{{ old('fare', $room->fare) }}"
                                       step="0.01"
                                       min="0"
                                       placeholder="Enter room fare"
                                       required>
                                <small class="text-muted">Enter numeric value (e.g., 100.50)</small>
                                @error('fare')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="adults" class="form-label">Adults *</label>
                                <input type="number"
                                       name="adults"
                                       id="adults"
                                       class="form-control"
                                       value="{{ old('adults', $room->adults) }}"
                                       min="1"
                                       max="10"
                                       placeholder="Number of adults"
                                       required>
                                @error('adults')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="children" class="form-label">Children *</label>
                                <input type="number"
                                       name="children"
                                       id="children"
                                       class="form-control"
                                       value="{{ old('children', $room->children) }}"
                                       min="0"
                                       max="10"
                                       placeholder="Number of children"
                                       required>
                                @error('children')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="is_featured" class="form-label">Feature Status *</label>
                                <select class="form-select"
                                        id="is_featured"
                                        name="is_featured"
                                        required>
                                    <option value="">Select Feature Status</option>
                                    <option value="Featured" {{ old('is_featured', $room->is_featured) == 'Featured' ? 'selected' : '' }}>
                                        Featured
                                    </option>
                                    <option value="Unfeatured" {{ old('is_featured', $room->is_featured) == 'Unfeatured' ? 'selected' : '' }}>
                                        Unfeatured
                                    </option>
                                </select>
                                @error('is_featured')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="room_type" class="form-label">Room Type *</label>
                                <select class="form-select"
                                        id="room_type"
                                        name="room_type"
                                        required>
                                    <option value="">Select Room Type</option>
                                    <option value="Room" {{ old('room_type', $room->room_type) == 'Room' ? 'selected' : '' }}>
                                        Room
                                    </option>
                                    <option value="Suite" {{ old('room_type', $room->room_type) == 'Suite' ? 'selected' : '' }}>
                                        Suite
                                    </option>
                                </select>
                                @error('room_type')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="">Select Status</option>
                                    <option value="Enabled" {{ old('status', $room->status) == 'Enabled' ? 'selected' : '' }}>
                                        Enabled
                                    </option>
                                    <option value="Disabled" {{ old('status', $room->status) == 'Disabled' ? 'selected' : '' }}>
                                        Disabled
                                    </option>
                                </select>
                                @error('status')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update Room
                                </button>
                                <a href="{{ route('room.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script src="{{url('')}}/assets/js/vendor.min.js"></script>
<script src="{{url('')}}/assets/js/app.js"></script>
@endsection