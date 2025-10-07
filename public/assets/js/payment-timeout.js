// Payment Timeout Handler
class PaymentTimeoutHandler {
    constructor() {
        this.timeoutDuration = 300000; // 5 minutes
        this.warningDuration = 240000; // 4 minutes
        this.timeoutTimer = null;
        this.warningTimer = null;
        this.isPaymentInProgress = false;
    }

    startPaymentSession() {
        this.isPaymentInProgress = true;
        this.clearTimers();
        
        // Show warning at 4 minutes
        this.warningTimer = setTimeout(() => {
            this.showTimeoutWarning();
        }, this.warningDuration);
        
        // Timeout at 5 minutes
        this.timeoutTimer = setTimeout(() => {
            this.handleTimeout();
        }, this.timeoutDuration);
        
        console.log('Payment session started with timeout protection');
    }

    showTimeoutWarning() {
        if (this.isPaymentInProgress) {
            const warning = document.createElement('div');
            warning.id = 'payment-timeout-warning';
            warning.className = 'alert alert-warning fixed-top text-center';
            warning.style.zIndex = '9999';
            warning.innerHTML = `
                <strong>⚠️ Payment Session Expiring Soon!</strong><br>
                Please complete your payment within 1 minute to avoid timeout.
                <button onclick="paymentHandler.extendSession()" class="btn btn-sm btn-primary ml-2">Extend Session</button>
            `;
            document.body.appendChild(warning);
        }
    }

    extendSession() {
        // Make AJAX call to extend session
        fetch('/user/payment/extend-session', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.clearTimers();
                this.startPaymentSession();
                this.hideTimeoutWarning();
                this.showSuccessMessage('Session extended successfully!');
            }
        })
        .catch(error => {
            console.error('Failed to extend session:', error);
        });
    }

    handleTimeout() {
        if (this.isPaymentInProgress) {
            this.isPaymentInProgress = false;
            this.showTimeoutMessage();
            // Redirect to cart after 5 seconds
            setTimeout(() => {
                window.location.href = '/user/cart';
            }, 5000);
        }
    }

    showTimeoutMessage() {
        const message = document.createElement('div');
        message.className = 'alert alert-danger fixed-top text-center';
        message.style.zIndex = '9999';
        message.innerHTML = `
            <strong>⏰ Payment Session Expired!</strong><br>
            Your payment session has timed out. Redirecting to cart...
        `;
        document.body.appendChild(message);
    }

    hideTimeoutWarning() {
        const warning = document.getElementById('payment-timeout-warning');
        if (warning) {
            warning.remove();
        }
    }

    showSuccessMessage(message) {
        const success = document.createElement('div');
        success.className = 'alert alert-success fixed-top text-center';
        success.style.zIndex = '9999';
        success.innerHTML = message;
        document.body.appendChild(success);
        
        setTimeout(() => {
            success.remove();
        }, 3000);
    }

    clearTimers() {
        if (this.timeoutTimer) {
            clearTimeout(this.timeoutTimer);
        }
        if (this.warningTimer) {
            clearTimeout(this.warningTimer);
        }
    }

    endPaymentSession() {
        this.isPaymentInProgress = false;
        this.clearTimers();
        this.hideTimeoutWarning();
    }
}

// Initialize payment handler
const paymentHandler = new PaymentTimeoutHandler();

// Auto-start on payment pages
document.addEventListener('DOMContentLoaded', function() {
    if (window.location.pathname.includes('/payment/')) {
        paymentHandler.startPaymentSession();
    }
});

// Handle page visibility changes
document.addEventListener('visibilitychange', function() {
    if (document.hidden && paymentHandler.isPaymentInProgress) {
        // Page is hidden, extend timeout
        paymentHandler.timeoutDuration += 60000; // Add 1 minute
    }
});