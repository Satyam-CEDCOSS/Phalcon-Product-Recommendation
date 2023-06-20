<?php

declare(strict_types=1);

namespace MyApp\Tasks;
session_start();

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }
    public function productAction($name="", $price=0, $type="")
    {
        $arr = [
            'name' => $name,
            'price' => $price,
            'type' => $type,
        ];
        $success = $this->mongo->product->insertOne($arr);
        if ($success->getInsertedCount()) {
            echo "Product Update SuccessFully" . PHP_EOL;
        }
    }
    public function orderAction($name="")
    {
        $data = $this->mongo->product->findOne(['name'=>$name]);
        $arr = [
            'name' => $name,
            'price' => $data->price,
            'type' => $data->type,
            'status' => "In-Process"
        ];
        $_SESSION['type'] = $data->type;
        $success = $this->mongo->order->insertOne($arr);
        if ($success->getInsertedCount()) {
            echo "Order Update SuccessFully" . PHP_EOL;
        }
    }
    public function recommendAction()
    {
        $data = $this->mongo->product->find(['type'=>'smartphone']);
        foreach ($data as $value) {
            echo "[Name: $value[name], Price: $value[price], Type: $value[type]]" . PHP_EOL;
        }
    }
}
