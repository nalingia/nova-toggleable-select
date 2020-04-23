<?php

namespace Nalingia\ToggleableSelect;

use Laravel\Nova\Fields\Select as NovaSelect;

class Select extends NovaSelect
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'toggleable-select';

    public function toggle(array $toggle): self {
        $this->withMeta([
            'toggle' => $toggle,
        ]);
        return $this;
    }
}
