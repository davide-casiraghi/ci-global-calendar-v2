<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\DonationOfferStoreRequest;
use App\Models\DonationOffer;
use App\Services\CountryService;
use App\Services\DonationOfferService;
use App\Traits\CheckPermission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

class DonationOfferController extends Controller
{
    use CheckPermission;

    private DonationOfferService $donationOfferService;
    private CountryService $countryService;

    public function __construct(
        DonationOfferService $donationOfferService,
        CountryService $countryService
    ) {
        $this->donationOfferService = $donationOfferService;
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $this->checkPermission('donation_offer.view');

        $countries = $this->countryService->getCountries();
        $offerKinds = Helper::getObjectsCollectionTranslated(DonationOffer::OFFER_KIND);

        $searchParameters = Helper::getSearchParameters($request, DonationOffer::SEARCH_PARAMETERS);
        $donationOffers = $this->donationOfferService->getDonationOffers(20, $searchParameters);

        return view('donationOffers.index', [
            'countries' => $countries,
            'offerKinds' => $offerKinds,
            'donationOffers' => $donationOffers,
            'searchParameters' => $searchParameters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->checkPermission('donation_offer.create');

        $countries = $this->countryService->getCountries();
        $donationKindItems =  $this->donationOfferService->getDonationKindMenuData();
        $giftKinds =  $this->donationOfferService->getGiftKinds();
        $volunteerKinds =  $this->donationOfferService->getVolunteerKinds();

        return view('donationOffers.create', [
            'countries' => $countries,
            'donationKindItems' => $donationKindItems,
            'giftKinds' => $giftKinds,
            'volunteerKinds' => $volunteerKinds,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DonationOfferStoreRequest  $request
     *
     * @return RedirectResponse
     * @throws InvalidStatus
     */
    public function store(DonationOfferStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('donation_offer.create');

        $this->donationOfferService->createDonationOffer($request);

        return redirect()->route('donationOffers.index')
            ->with('success', 'Donation Offer updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  DonationOffer  $donationOffer
     * @return Application|Factory|View
     */
    public function show(DonationOffer $donationOffer)
    {
        return view('donationOffers.show', compact('donationOffer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  DonationOffer  $donationOffer
     * @return Application|Factory|View
     */
    public function edit(DonationOffer $donationOffer): View|Factory|Application
    {
        $this->checkPermission('donation_offer.edit');

        $countries = $this->countryService->getCountries();
        $donationKindItems =  $this->donationOfferService->getDonationKindMenuData();
        $giftKinds =  $this->donationOfferService->getGiftKinds();
        $volunteerKinds =  $this->donationOfferService->getVolunteerKinds();

        return view('donationOffers.edit', [
            'donationOffer' => $donationOffer,
            'countries' => $countries,
            'donationKindItems' => $donationKindItems,
            'giftKinds' => $giftKinds,
            'volunteerKinds' => $volunteerKinds,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DonationOfferStoreRequest  $request
     * @param  DonationOffer  $donationOffer
     * @return RedirectResponse
     */
    public function update(DonationOfferStoreRequest $request, DonationOffer $donationOffer): RedirectResponse
    {
        $this->checkPermission('donation_offer.edit');

        $this->donationOfferService->updateDonationOffer($request, $donationOffer);

        return redirect()->route('donationOffers.index')
            ->with('success', 'Donation Offer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $donationOfferId
     *
     * @return RedirectResponse
     */
    public function destroy(int $donationOfferId): RedirectResponse
    {
        $this->checkPermission('donation_offer.delete');

        $this->donationOfferService->deleteDonationOffer($donationOfferId);

        return redirect()->route('donationOffers.index')
            ->with('success', 'Donation Offer deleted successfully');
    }

}
