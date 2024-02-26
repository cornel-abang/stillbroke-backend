<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Newsletter;
use App\Events\ContactUsEvent;
use Illuminate\Database\Eloquent\Collection;

class GeneralService
{
    public function fetchAllOrders(): Collection
    {
        return auth()->user()->orders;
    }

    public function contactAdmin(array $info): void
    {
        Contact::create($info);

        event(new ContactUsEvent($info));
    }

    public function subToNewsletter(string $email): void
    {
        Newsletter::create(['email' => $email]);
    }

    public function unSubNewsletter(string $email): void
    {
        $email = Newsletter::where('email', $email)->first();
        $email->delete();
    }

    public function fetchAboutUs(): string
    {
        return Company::first()->about;
    }

    public function fetchPrivacy(): string
    {
        return Company::first()->privacy;
    }

    public function fetchTerms(): string
    {
        return Company::first()->terms;
    }

    public function saveAboutUs(string $txt)
    {
        $company = Company::first();

        if (! $company) {
            Company::create(['about' => $txt]);

            return true;
        }

        $company->about = $txt;
        $company->save();

        return true;
    }

    public function savePrivacyPolicy(string $txt)
    {
        $company = Company::first();

        if (! $company) {
            Company::create(['privacy' => $txt]);

            return true;
        }

        $company->privacy = $txt;
        $company->save();

        return true;
    }

    public function saveTerms(string $txt)
    {
        $company = Company::first();

        if (! $company) {
            Company::create(['terms' => $txt]);

            return true;
        }

        $company->terms = $txt;
        $company->save();

        return true;
    }

    public function updateGenCompanyData(array $data)
    {
        $company = Company::first();

        if (! $company) {
            Company::create($data);

            return true;
        }

        $company->update($data);

        return true;
    }

    public function saveMainVideo(string $url)
    {
        $company = Company::first();

        if (! $company) {
            Company::create(['video' => $url]);

            return true;
        }

        $company->video = $url;
        $company->save();

        return true;
    }

    public function fetchMainVideo(): string
    {
        return Company::first()->video;
    }
}
