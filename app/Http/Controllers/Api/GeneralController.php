<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\GeneralService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Requests\GenUpdateRequest;
use App\Http\Requests\NewsletterRequest;
use App\Http\Requests\UnSubNewsletterRequest;

class GeneralController extends Controller
{
    public function __construct(private GeneralService $genService)
    {
    }

    public function sendContactNotify(ContactUsRequest $request): JsonResponse
    {
        $this->genService->contactAdmin($request->validated());

        return $this->response(true, 'Message sent', 201);
    }

    public function subscribeToNewsletter(NewsletterRequest $request): JsonResponse
    {
        $this->genService->subToNewsletter($request->email);

        return $this->response(true, 'Subscribed to newsletter', 201);
    }

    public function unsubscribeNewsletter(UnSubNewsletterRequest $request): JsonResponse
    {
        $this->genService->unSubNewsletter($request->email);

        return $this->response(true, 'Unsubscribed from newsletter', 201);
    }

    public function getAboutUsInfo(): JsonResponse
    {
        $aboutUs = $this->genService->fetchAboutUs();

        return $this->response(true, 'Found', 200, ['about-us' => $aboutUs]);
    }

    public function getPrivacyPolicy(): JsonResponse
    {
        $privacy = $this->genService->fetchPrivacy();

        return $this->response(true, 'Found', 200, ['privacy' => $privacy]);
    }

    public function getTermsConditions(): JsonResponse
    {
        $terms = $this->genService->fetchTerms();

        return $this->response(true, 'Found', 200, ['terms' => $terms]);
    }

    public function saveAboutUsInfo(Request $request): JsonResponse
    {
        if (! $request->about || $request->about == '') {
            return $this->response(false, 'The about us text is required', 401);
        }

        $this->genService->saveAboutUs($request->about);

        return $this->response(true, 'Info saved', 201);
    }

    public function savePrivacyPolicy(Request $request): JsonResponse
    {
        if (! $request->policy || $request->policy == '') {
            return $this->response(false, 'The privacy policy text is required', 401);
        }

        $this->genService->savePrivacyPolicy($request->policy);

        return $this->response(true, 'Info saved', 201);
    }

    public function saveTermsConditions(Request $request): JsonResponse
    {
        if (! $request->terms || $request->terms == '') {
            return $this->response(false, 'The Terms & Conditions text is required', 401);
        }

        $this->genService->saveTerms($request->terms);

        return $this->response(true, 'Info saved', 201);
    }

    public function updateGenData(GenUpdateRequest $request): JsonResponse
    {
        $this->genService->updateGenCompanyData($request->validated());

        return $this->response(true, 'Info updated', 200);
    }

    public function updateMainVideo(Request $request): JsonResponse
    {
        if (! $request->video_url || $request->video_url == '') {
            return $this->response(false, 'The main video is required', 401);
        }

        $this->genService->saveMainVideo($request->video_url);

        return $this->response(true, 'Info updated', 200);
    }

    public function getMainVideo(): JsonResponse
    {
        $video = $this->genService->fetchMainVideo();

        return $this->response(true, 'Found', 200, ['video' => $video]);
    }
}
