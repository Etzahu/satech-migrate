<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;

class PurchaseRequisitionApprovalChainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseRequisitionApprovalChain::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'requester_id' => User::factory(),
            'reviewer_id' => User::factory(),
            'approver_id' => User::factory(),
        ];
    }
}
