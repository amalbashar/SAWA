@extends('layouts.guest.master')

@section('title', 'booking')

@section('content')
<br><br><br><br><br>



<div class="contact-us section" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-6  align-self-center">
                <div class="section-heading">
                    <h6>Contact Us</h6>
                    <h2>Feel free to contact us anytime</h2>
                    <p>Thank you for choosing our templates. We provide you best CSS templates at absolutely 100% free of charge. You may support us by sharing our website to your friends.</p>
                    <div class="special-offer">
                        <span class="offer">off<br><em>50%</em></span>
                        <h6>Valide: <em>24 April 2036</em></h6>
                        <h4>Special Offer <em>50%</em> OFF!</h4>
                        <a href="#"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-us-content">
                    <!-- form submission to store booking -->
                    <form id="contact-form" action="{{ route('user.booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="care_provider_id" value="{{ $provider->id }}">

                                <fieldset>
                                    <label for="booking_date">Booking Date:</label>
                                    <input type="date" name="booking_date" value="{{ $request->booking_date }}" required>
                                </fieldset>
                            <div class="col-lg-12">
                                <fieldset>
                                    <label for="time_slot">Choose a Time Slot:</label>
                                    <select name="time_slot" required>
                                        @foreach($availableSlots as $slot)
                                            <option value="{{ $slot }}">{{ $slot }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <textarea name="notes" placeholder="Any notes (optional)"></textarea>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="orange-button">Complete Booking</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
