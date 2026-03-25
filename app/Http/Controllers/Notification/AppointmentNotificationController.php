<?php

namespace App\Http\Controllers\Notification;

use App\AppointmentNotification;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\MarkNotificationReadRequest;
use App\Services\Notification\NotificationService;
use Illuminate\Http\RedirectResponse;

class AppointmentNotificationController extends Controller
{
    public function __construct(private readonly NotificationService $service)
    {
    }

    public function indexCustomer()
    {
        $customerId = auth()->guard('web_user')->id();
        $notifications = $this->service->getForCustomer($customerId);

        return view('customer.notifications', compact('notifications'));
    }

    public function markRead(MarkNotificationReadRequest $request, AppointmentNotification $notification): RedirectResponse
    {
        $this->service->markRead($notification);

        session()->flash('message', 'Notification marked as read.');

        return redirect()->back();
    }

    public function indexAdmin()
    {
        $notifications = $this->service->getForAdmin();

        return view('admin.notifications.index', compact('notifications'));
    }
}

