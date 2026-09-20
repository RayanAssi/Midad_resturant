@php
    $action = request('action', 'enable');
    $isEnable = $action === 'enable';
@endphp

<x-profile.confirm-password 
    :action="$isEnable ? route('admin.two-factor.enable') : route('admin.two-factor.disable')"
    :method="$isEnable ? 'POST' : 'DELETE'"
    title="Confirm Password"
    :description="$isEnable 
        ? 'Please confirm your password before enabling Two-Factor Authentication.' 
        : 'Please confirm your password before disabling Two-Factor Authentication.'"
    badge="Admin Secure"
    :logout-url="url('/admin/logout')"
/>