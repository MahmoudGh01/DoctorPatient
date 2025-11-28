<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileUpload extends Component
{
    /**
     * Create a new component instance.
     */
    public string $name;
    public ?string $label;
    public ?string $accept;

    public function __construct(string $name, string $label = null, string $accept = 'image/*')
    {
        $this->name = $name;
        $this->label = $label;
        $this->accept = $accept;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.file-upload');
    }
}
