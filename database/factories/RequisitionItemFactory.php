<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\PurchaseRequisition;
use App\Models\RequisitionItem;

class RequisitionItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RequisitionItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'observations' => $this->faker->text(),
            'product_id' => Product::factory(),
            'purchase_requisition_id' => PurchaseRequisition::factory(),
        ];
    }
}
