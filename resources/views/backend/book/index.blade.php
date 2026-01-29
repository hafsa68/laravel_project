@extends('backend.layouts.app') 

@section("head")
<head>
    <meta charset="utf-8" />
    <title>Book Room | ViserHotel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{url('')}}/assets/css/style.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .room-selector:hover { transform: scale(1.05); transition: 0.2s; cursor: pointer; }
        .selected-room { border: 3px solid #000 !important; box-shadow: 0 0 10px rgba(0,0,0,0.2); }
    </style>
</head>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between">
            <h3 class="card-title">Book Room</h3>
            <a href="#" class="btn btn-primary btn-sm ml-auto"><i class="fa fa-list"></i> All Bookings</a>
        </div>
        <div class="card-body">
            <form action="{{ route('book.search') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="font-weight-bold">Check In - Check Out Date</label>
                        <input type="text" name="dates" id="booking_dates" class="form-control" value="{{ request('dates') }}" required autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold">Room Type <span class="text-danger">*</span></label>
                        {{-- ID যোগ করা হয়েছে: room_type_select --}}
                        <select name="rooms_id" id="room_type_select" class="form-control" required>
                            <option value="">Select One</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}" {{ request('rooms_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold">Room <span class="text-info">* Available Rooms: <span id="available_count">0</span></span></label>
                        <input type="number" name="quantity" class="form-control" placeholder="How many room?" value="{{ request('quantity') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-block" style="background-color: #5e3fc9; border: none;">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>

            @if(isset($allRoomNumbers))
            <hr>
            <div class="row mt-4">
                <div class="col-md-8">
                    <h5 class="mb-3">Select Rooms ({{ $selectedRoomType->name }})</h5>
                    <div class="d-flex flex-wrap">
                        @foreach($allRoomNumbers as $room)
                            @php $isBooked = in_array($room->id, $bookedRoomIds); @endphp
                            <div class="room-selector m-1 p-3 text-center text-white {{ $isBooked ? 'bg-danger' : 'bg-primary' }}"
                                 style="width: 75px; border-radius: 5px; cursor: {{ $isBooked ? 'not-allowed' : 'pointer' }};"
                                 data-id="{{ $room->id }}" data-no="{{ $room->room_no }}">
                                {{ $room->room_no }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border">
                        <div class="card-header bg-info text-white font-weight-bold">Guest Information</div>
                        <div class="card-body">
                            <form action="{{ route('bookings.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="rooms_id" value="{{ request('rooms_id') }}">
                                <input type="hidden" name="room_nos_id" id="room_nos_id" required>
                                <input type="hidden" name="check_in" value="{{ $checkIn }}">
                                <input type="hidden" name="check_out" value="{{ $checkOut }}">

                                <p><strong>Selected Room:</strong> <span id="display_room" class="badge badge-warning">None</span></p>
                                
                                <div class="form-group mb-2">
                                    <label>Guest Name *</label>
                                    <input type="text" name="guest_name" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Email</label>
                                    <input type="email" name="guest_email" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-success btn-block shadow-sm">Confirm Booking</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(document).ready(function() {
    // ১. ডাইনামিক এভেইল্যাবিলিটি কাউন্টার (AJAX)
    $('#room_type_select').on('change', function() {
        let roomId = $(this).val();
        if(roomId) {
            $.ajax({
                url: "{{ url('/admin/get-room-count') }}/" + roomId, // আপনার রাউট অনুযায়ী
                type: "GET",
                success: function(data) {
                    $('#available_count').text(data.count);
                },
                error: function() { $('#available_count').text('0'); }
            });
        }
    });

    // ২. রুম সিলেক্টর লজিক
    $('.room-selector').click(function() {
        if($(this).hasClass('bg-danger')) return;
        $('.room-selector').removeClass('selected-room');
        $(this).addClass('selected-room');
        
        $('#room_nos_id').val($(this).data('id'));
        $('#display_room').text($(this).data('no'));
    });

    // ৩. ডেট রেঞ্জ পিকার
    $('#booking_dates').daterangepicker({
        autoUpdateInput: true,
        locale: { format: 'MM/DD/YYYY' }
    });
});
</script>
@endpush