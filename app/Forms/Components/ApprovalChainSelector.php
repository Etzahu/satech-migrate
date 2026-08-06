<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class ApprovalChainSelector extends Field
{
    protected string $view = 'forms.components.approval-chain-selector';

    protected Closure|Collection|SupportCollection|null $chains = null;

    public function chains(Closure|Collection|SupportCollection $chains): static
    {
        $this->chains = $chains;

        return $this;
    }

    public function getChains(): Collection|SupportCollection
    {
        return $this->evaluate($this->chains) ?? new Collection;
    }
}
