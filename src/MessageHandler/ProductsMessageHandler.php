<?php

declare(strict_types=1);

namespace App\MessageHandler;


use App\Entity\Product;
use App\Message\ProductsMessage;
use Symfony\Component\Uid\Uuid;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'products')]
class ProductsMessageHandler
{
    public function __construct(private ProductRepository $repository)
    {}

    public function __invoke(ProductsMessage $message)
    {
        $receivedMessage = json_decode($message->getContent());

        $product = new Product();
        $product
            ->setId(Uuid::fromString($receivedMessage->product->id))
            ->setName($receivedMessage->product->name)
            ->setPrice($receivedMessage->product->price);

        $this->repository->save($product, true);

    }
}
