<?php

declare(strict_types=1);

namespace App\MessageHandler;


use App\Entity\Customer;
use App\Message\CustomersMessage;
use Symfony\Component\Uid\Uuid;
use App\Repository\CustomerRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'customers')]
class CustomersMessageHandler
{
    public function __construct(private CustomerRepository $repository)
    {}

    public function __invoke(CustomersMessage $message)
    {
        $receivedMessage = json_decode($message->getContent());

        $customer = new Customer();
        $customer
            ->setId(Uuid::fromString($receivedMessage->customer->id))
            ->setName($receivedMessage->customer->name)
            ->setEmail($receivedMessage->customer->email)
            ->setPhone($receivedMessage->customer->phone);

        $this->repository->save($customer, true);

    }
}
