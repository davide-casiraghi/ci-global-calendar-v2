<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\DonationOfferStoreRequest;
use App\Models\DonationOffer;
use App\Services\DonationOfferService;
use App\Traits\CheckPermission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DonationOfferController extends Controller
{
    use CheckPermission;

    private DonationOfferService $donationOfferService;

    public function __construct(
        DonationOfferService $donationOfferService
    ) {
        $this->donationOfferService = $donationOfferService;
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

        $searchParameters = Helper::getSearchParameters($request, DonationOffer::SEARCH_PARAMETERS);
        $donationOffers = $this->donationOfferService->getDonationOffers(20, $searchParameters);

        return view('donationOffers.index', [
            'donationOffers' => $donationOffers,
            'searchParameters' => $searchParameters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $this->checkPermission('donation_offer.create');

        return view('donationOffers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DonationOfferStoreRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(DonationOfferStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('background_images.create');

        $this->donationOfferService->createDonationOffer($request);

        return redirect()->route('donationOffers.index')
            ->with('success', 'Donation Offer updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $donationOfferId
     *
     * @return Application|Factory|View
     */
    public function show(string $donationOfferSlug)
    {
        $donationOffer = $this->donationOfferService->getBySlug($donationOfferSlug);

        if (is_null($donationOffer)){
            return redirect()->route('home');
        }

        return view('donationOffers.show', compact('donationOffer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $donationOfferId
     *
     * @return Application|Factory|View
     */
    public function edit(int $donationOfferId): View|Factory|Application
    {
        $this->checkPermission('donation_offer.edit');

        $donationOffer = $this->donationOfferService->getById($donationOfferId);

        return view('donationOffers.edit', [
            'donationOffer' => $donationOffer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DonationOfferStoreRequest  $request
     * @param int $donationOfferId
     *
     * @return RedirectResponse
     */
    public function update(DonationOfferStoreRequest $request, int $donationOfferId): RedirectResponse
    {
        $this->checkPermission('donation_offer.edit');

        $this->donationOfferService->updateDonationOffer($request, $donationOfferId);

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
