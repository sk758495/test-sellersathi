<?php

use App\Http\Controllers\User\About_Us\AboutUsController;
use App\Http\Controllers\User\ContacUs\ContactUsController;
use App\Http\Controllers\User\Disclaimer\DisclaimerController;
use App\Http\Controllers\User\PrivacyPolicy\PrivacyPolicyController;
use App\Http\Controllers\User\TermAndCondition\TermConditionController;
use Illuminate\Support\Facades\Route;


Route::get('/about-us', [AboutUsController::class, 'about_us'])->name('about-us');


Route::get('/term-condition', [TermConditionController::class, 'term_condition'])->name('term-condition');


Route::get('/privacy-policy', [PrivacyPolicyController::class, 'privacy_policy'])->name('privacy-policy');


Route::get('/disclaimer', [DisclaimerController::class, 'disclaimer'])->name('disclaimer');


Route::get('/contac-us', [ContactUsController::class, 'contact_us'])->name('contact-us');


Route::post('/contact', [ContactUsController::class, 'sendContactForm'])->name('contact.form.submit');

