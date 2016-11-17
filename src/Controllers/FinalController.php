<?php

namespace Appoets\LaravelSetup\Controllers;

use Illuminate\Routing\Controller;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param InstalledFileManager $fileManager
     * @return \Illuminate\View\View
     */
    public function finish()
    {
        return view('vendor.installer.finished');
    }
}
