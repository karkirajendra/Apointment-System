<?php

namespace App\Http\Controllers\Appointment;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\CancelAppointmentRequest;
use App\Http\Requests\Appointment\RescheduleAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentStatusRequest;
use App\Services\Appointment\AppointmentService;
use Illuminate\Http\RedirectResponse;

class AppointmentController extends Controller
{
    public function __construct(private readonly AppointmentService $service)
    {
    }

    public function cancelCustomer(CancelAppointmentRequest $request, Booking $booking): RedirectResponse
    {
        $this->service->cancelBooking($booking, $request->input('reason'));

        session()->flash('message', 'Appointment cancelled.');

        return redirect('/bookings');
    }

    public function rescheduleForm(Booking $booking)
    {
        $customerId = auth()->guard('web_user')->id();

        if ((int) $booking->customer_id !== (int) $customerId) {
            abort(403);
        }

        return view('customer.reschedule', compact('booking'));
    }

    public function rescheduleCustomer(RescheduleAppointmentRequest $request, Booking $booking): RedirectResponse
    {
        $this->service->rescheduleBooking(
            $booking,
            $request->validated()['date'],
            $request->validated()['start_time']
        );

        session()->flash('message', 'Appointment rescheduled.');

        return redirect('/bookings');
    }

    public function approveAdmin(UpdateAppointmentStatusRequest $request, Booking $booking): RedirectResponse
    {
        $this->service->approveBooking($booking);

        session()->flash('message', 'Appointment approved.');

        return redirect()->back();
    }

    public function completeAdmin(UpdateAppointmentStatusRequest $request, Booking $booking): RedirectResponse
    {
        $this->service->completeBooking($booking);

        session()->flash('message', 'Appointment completed.');

        return redirect()->back();
    }

    public function cancelAdmin(CancelAppointmentRequest $request, Booking $booking): RedirectResponse
    {
        $this->service->cancelBooking($booking, $request->input('reason'));

        session()->flash('message', 'Appointment cancelled.');

        return redirect()->back();
    }
}

