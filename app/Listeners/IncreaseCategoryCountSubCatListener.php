<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class IncreaseCategoryCountSubCatListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $category = $event->category;
        if ($category->parent)
            $category->parent->update(['count_subCat' => DB::raw('count_subCat+1')]);

        if ($category->showParent)
            $category->showParent->update(['count_showSubCat' => DB::raw('count_showSubCat+1')]);
    }
}
