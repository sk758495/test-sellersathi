<?php

namespace App\Http\Controllers\User\ContacUs;

use App\Http\Controllers\Controller;
use App\Models\BrandCategory;
use Illuminate\Http\Request;
use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function contact_us(){
        $brand_categories = BrandCategory::with('images')->latest()->take(6)->get();
        return view('user.contact-us.contact-us-view', compact('brand_categories'));
    }

    public function sendContactForm(Request $request)
{
    // Validate form data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    // Extract data
    $name = $validated['name'];
    $email = $validated['email'];
    $subject = $validated['subject'];
    $messageContent = $validated['message'];

    // Send email to admin
    $adminEmail = "arjuncableconverters@gmail.com";
    Mail::to($adminEmail)->send(new ContactFormSubmission($name, $email, $subject, $messageContent));

    // Send email to the user (confirmation email)
    Mail::to($email)->send(new ContactFormSubmission($name, $email, "Thank You for Contacting Us", "Thank you for reaching out to Gujjuemarket. We will respond to you shortly."));

    return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
}

}
