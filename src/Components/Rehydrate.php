<?php

namespace ProtoneMedia\Splade\Components;

use Illuminate\View\Component;
use ProtoneMedia\Splade\SpladeCore;

class Rehydrate extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public SpladeCore $splade,
        public array|string $on = ''
    ) {
        if (is_string($on)) {
            $this->on = Form::splitByComma($on);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $key = $this->splade->newRehydrateComponentKey();

        return $this->splade->isRehydrateRequest()
            ? implode([
                '<!--START-SPLADE-REHYDRATE-' . $key . '-->',
                '{{ $slot }}',
                '<!--END-SPLADE-REHYDRATE-' . $key . '-->',
            ]) : view('splade::functional.rehydrate', [
                'name' => $key,
                'on'   => $this->on,
            ]);
    }
}
