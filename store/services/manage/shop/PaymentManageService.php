<?php

namespace store\services\manage\shop;


use store\entities\shop\order\PaymentMethod;
use store\forms\manage\order\PaymentForm;
use store\repositories\manage\shop\PaymentRepository;

class PaymentManageService
{
    private $methods;

    public function __construct(PaymentRepository $methods)
    {
        $this->methods = $methods;
    }

    public function create(PaymentForm $form): PaymentMethod
    {
        $method = PaymentMethod::create($form->name);
        $this->methods->save($method);

        return $method;
    }

    public function edit($id, PaymentForm $form): void
    {
        $method = $this->methods->get($id);
        $method->edit($form->name);
        $this->methods->save($method);
    }

    public function remove($id): void
    {
        $method = $this->methods->get($id);
        $this->methods->remove($method);
    }
}