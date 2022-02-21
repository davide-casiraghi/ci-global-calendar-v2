<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;

class CaptchaController extends Controller
{

    /**
     * Store a new captcha value in the session and generate a new image.
     * Called by the AJAX defined here: resources/js/forms/captcha.js
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function reloadCaptcha(): JsonResponse
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
