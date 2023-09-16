<?php
namespace Services;

use SDPMlab\Anser\Service\SimpleService;
use SDPMlab\Anser\Service\ActionInterface;
use Filters\FailHandlerFilter;
use Filters\JsonDoneHandlerFilter;

class ProductionService extends SimpleService
{
    protected $serviceName = "ProductionService";
    protected $filters = [
        "before" => [
            JsonDoneHandlerFilter::class,
            FailHandlerFilter::class
        ],
        "after" => [],
    ];
    protected $retry = 1;
    protected $retryDelay = 0.2;
    protected $timeout = 2.0;
    protected $options = [];

    /**
     * 取得商品清單
     *
     * @param integer $limit
     * @param integer $offest
     * @param string $orderBy DESC or ASC
     * @param string $search
     * @return ActionInterface
     */
    public function productListAction(
        int $limit=10,
        int $offest=0,
        string $orderBy = "DESC",
        string $search = ""
    ): ActionInterface {
        return $this->getAction(
            method: "GET",
            path: "/api/v1/products"
        )->setOptions([
            "query" => [
                "limit" => $limit,
                "offset" => $offest,
                "isDesc" => $orderBy,
                "query" => $search
            ]
        ]);
    }

    /**
     * 取得商品資訊
     *
     * @param integer $productId
     * @return ActionInterface
     */
    public function productInfoAction(int $productId): ActionInterface
    {
        return $this->getAction(
            method: "GET",
            path: "/api/v1/products/{$productId}"
        );
    }

    /**
     * 新增商品
     *
     * @param string $name
     * @param string $description
     * @param integer $price
     * @param integer $amount
     * @return ActionInterface
     */
    public function createProductAction(
        string $name,
        string $description,
        int $price,
        int $amount
    ): ActionInterface {
        return $this->getAction(
            method: "POST",
            path: "/api/v1/products"
        )->setOptions([
            "form_params" => [
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "amount" => $amount
            ]
        ]);
    }

    /**
     * 更新商品資訊
     *
     * @param integer $productId
     * @param string|null $name
     * @param string|null $description
     * @param integer|null $price
     * @return ActionInterface
     */
    public function updateProductAction(
        int $productId,
        ?string $name = null,
        ?string $description = null,
        ?int $price = null
    ): ActionInterface {
        $jsonBody = [];
        if (!is_null($name)) {
            $jsonBody["name"] = $name;
        }
        if (!is_null($description)) {
            $jsonBody["description"] = $description;
        }
        if (!is_null($price)) {
            $jsonBody["price"] = $price;
        }

        return $this->getAction(
            method: "PUT",
            path: "/api/v1/products/{$productId}"
        )->setOptions([
            "json" => $jsonBody
        ]);
    }

    /**
     * 減少庫存
     *
     * @param integer $productId
     * @param string $orderId
     * @param integer $amount
     * @return ActionInterface
     */
    public function reduceInventory(
        int $productId,
        string $orderId,
        int $amount,
    ): ActionInterface {
        $formParams = [
            "p_key" => $productId,
            "o_key" => $orderId,
            "reduceAmount" => $amount,
        ];
        return $this->getAction(
            method: "POST",
            path: "/api/v1/inventory/reduceInventory"
        )->setOptions([
            "form_params" => $formParams
        ]);
    }

    /**
     * 新增庫存（此為減少庫存的補償 Action）
     *
     * @param integer $productId
     * @param string $orderId
     * @param integer $amount
     * @return ActionInterface
     */
    public function addInventoryCompensateAction(
        int $productId,
        string $orderId,
        int $amount
    ): ActionInterface {
        $formParams = [
            "p_key" => $productId,
            "o_key" => $orderId,
            "addAmount" => $amount,
            "type" => "compensate"
        ];
        return $this->getAction(
            method: "POST",
            path: "/api/v1/inventory/addInventory"
        )->setOptions([
            "form_params" => $formParams
        ]);
    }

}
