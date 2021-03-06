<?php
/**
 * Created by PhpStorm.
 * User: tran.duy.khanh
 * Date: 30/05/2017
 * Time: 13:02
 */

namespace DockerClient\Collections;


use DockerClient\Entities\ContainerEntity;
use GuzzleHttp\Psr7\Response;

class ContainerCollection extends Collection
{
    public static function makeFromResponse(Response $response)
    {
        $data = json_decode($response->getBody());
        $collection = parent::make($data);

        return $collection->map(function ($item) {
            return new ContainerEntity($item->Id);
        });
    }
}