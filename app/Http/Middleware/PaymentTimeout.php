<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PaymentTimeout
{
    public function handle(Request $request, Closure $next)
    {
        // Extend session lifetime for payment routes
        if ($request->is('user/payment/*') || $request->is('*/hdfc/*')) {
            config(['session.lifetime' => 300]); // 5 hours for payment flows
            
            // Set longer PHP execution time for payment processing
            set_time_limit(300);
            ini_set('max_execution_time', 300);
        }
        
        return $next($request);
    }
}