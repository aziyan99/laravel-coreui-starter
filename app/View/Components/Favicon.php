<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\Component;

class Favicon extends Component
{
    public $logo;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $setting = Setting::first();
        $this->logo = $setting->logo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.favicon');
    }
}
