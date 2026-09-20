{{-- @php
    $action = request('action', 'enable');
    $isEnable = $action === 'enable';
@endphp

<x-profile.confirm-password 
    :action="route('two-factor.enable')"
    :method="$isEnable ? 'POST' : 'DELETE'"
    title="Confirm Password"
    :description="$isEnable 
        ? 'Please confirm your password before enabling Two-Factor Authentication.' 
        : 'Please confirm your password before disabling Two-Factor Authentication.'"
    badge="Cashier Secure"
    :logout-url="url('/cashier/logout')"
/> --}}
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