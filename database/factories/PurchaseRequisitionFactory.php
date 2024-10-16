<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;

class PurchaseRequisitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseRequisition::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'folio' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'request_user_id' => User::factory(),
            'date_delivery' => $this->faker->date(),
            'delivery_address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'type' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'approval_chain_id' => PurchaseRequisitionApprovalChain::factory(),
        ];
    }
}
