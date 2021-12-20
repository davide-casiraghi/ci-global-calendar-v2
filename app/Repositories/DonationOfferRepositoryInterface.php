<?php

namespace App\Repositories;

use App\Models\DonationOffer;

interface DonationOfferRepositoryInterface {

  /**
   * Get all DonationOffers.
   *
   * @param int|null $recordsPerPage
   * @param array|null $searchParameters
   *
   * @return \App\Models\DonationOffer[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
   */
  public function getAll(int $recordsPerPage = NULL, array $searchParameters = NULL);

  /**
   * Get DonationOffer by id
   *
   * @param int $id
   *
   * @return DonationOffer
   */
  public function getById(int $id): DonationOffer;

  /**
   * Store DonationOffer
   *
   * @param array $data
   *
   * @return DonationOffer
   */
  public function store(array $data): DonationOffer;

  /**
   * Update DonationOffer
   *
   * @param array $data
   * @param int $id
   *
   * @return DonationOffer
   */
  public function update(array $data, int $id): DonationOffer;

  /**
   * Delete DonationOffer
   *
   * @param int $id
   *
   * @return void
   */
  public function delete(int $id): void;

  /**
   * Assign the attributes of the data array to the object
   *
   * @param \App\Models\DonationOffer $donationOffer
   * @param array $data
   *
   * @return \App\Models\DonationOffer
   */
  public function assignDataAttributes(DonationOffer $donationOffer, array $data): DonationOffer;

}
