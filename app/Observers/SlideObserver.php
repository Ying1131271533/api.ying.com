<?php

namespace App\Observers;

use App\Models\Slide;

class SlideObserver
{
    /**
     * Handle the Slide "created" event.
     *
     * @param  \App\Models\Slide  $slide
     * @return void
     */
    public function created(Slide $slide)
    {
        // create方法能够生效
        // $slide->status = 1;
        // $slide->save();
    }

    /**
     * Handle the Slide "updated" event.
     *
     * @param  \App\Models\Slide  $slide
     * @return void
     */
    public function updated(Slide $slide)
    {
        //
    }

    /**
     * Handle the Slide "deleted" event.
     *
     * @param  \App\Models\Slide  $slide
     * @return void
     */
    public function deleted(Slide $slide)
    {
        //
    }

    /**
     * Handle the Slide "restored" event.
     *
     * @param  \App\Models\Slide  $slide
     * @return void
     */
    public function restored(Slide $slide)
    {
        //
    }

    /**
     * Handle the Slide "force deleted" event.
     *
     * @param  \App\Models\Slide  $slide
     * @return void
     */
    public function forceDeleted(Slide $slide)
    {
        //
    }
}
