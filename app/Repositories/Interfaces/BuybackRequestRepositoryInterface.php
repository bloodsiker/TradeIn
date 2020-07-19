<?php

namespace App\Repositories\Interfaces;

interface BuybackRequestRepositoryInterface
{
    /**
     * @return mixed
     */
    public function baseQuery();

    /**
     * @param $query
     * @param $statusId
     *
     * @return mixed
     */
    public function filterStatus($query, $statusId);

    /**
     * @param $query
     * @param $userId
     *
     * @return mixed
     */
    public function byUser($query, $userId);

    /**
     * @param $query
     * @param $shopId
     *
     * @return mixed
     */
    public function filterShop($query, $shopId);


    /**
     * @param $query
     * @param $networkId
     *
     * @return mixed
     */
    public function filterNetwork($query, $networkId);

    /**
     * @param $query
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function filterByDate($query, $from, $to);
}
