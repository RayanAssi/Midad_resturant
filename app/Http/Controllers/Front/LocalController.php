<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocalController extends Controller
{
    public function switch(string $locale)
    {
        if(!LaravelLocalization::checkLocaleInSupportedLocales($locale)){
            abort(404);
        }
        session(['locale' => $locale]);
        $referer = url()->previous();
        if( $referer && !str_contains($referer , 'switch-language') && str_contains($referer,'/user'))
        {
            return redirect()->to($referer);
        }
        return redirect('/'.$locale);
    }
}
