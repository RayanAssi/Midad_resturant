@php
    $action = route('password.confirm');
@endphp

<x-profile.confirm-password 
    :action="$action"
    method="POST"
    title="Confirm Password"
    description="Please confirm your password before continuing."
    badge="Cashier Secure"
    :logout-url="url('/cashier/logout')"
/>