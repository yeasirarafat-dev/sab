<?php

namespace App\View\Components;

use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LatestWorkSection extends Component
{
    public $project;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->project = Cache::remember('last-woerk-project', 60 * 60 *12, function () {
            return Project::orderBy('created_at','DESC')->limit(10)->get(['id','image']);
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.latest-work-section');
    }
}
