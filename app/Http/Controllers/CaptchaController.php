<?php

namespace App\Http\Controllers;

use App\Services\CaptchaService;
use Exception;
use Illuminate\Http\JsonResponse;

class CaptchaController extends Controller
{
    private CaptchaService $captchaService;

    /**
     * Create a new controller instance.
     *
     * @param CaptchaService $captchaService
     */
    public function __construct(
        CaptchaService $captchaService,
    ) {
        $this->captchaService = $captchaService;
    }

    /**
     * Store a new captcha value in the session and generate a new image.
     * Called by the AJAX defined here: resources/js/forms/captcha.js
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function reloadCaptcha(): JsonResponse
    {
        $this->captchaService->prime();
        $captchaImage = $this->captchaService->draw();

        return response()->json(['captcha'=> $captchaImage]);
    }
}
