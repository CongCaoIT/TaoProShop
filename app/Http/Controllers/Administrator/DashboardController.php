<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $config = $this->config();

        $template = 'Administrator.dashboard.home.index';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config'
        ));
    }

    private function config()
    {
        return [
            'js' => [
                'Administrator/js/plugins/flot/jquery.flot.js',
                'Administrator/js/plugins/flot/jquery.flot.tooltip.min.js',
                'Administrator/js/plugins/flot/jquery.flot.spline.js',
                'Administrator/js/plugins/flot/jquery.flot.resize.js',
                'Administrator/js/plugins/flot/jquery.flot.pie.js',
                'Administrator/js/plugins/flot/jquery.flot.symbol.js',
                'Administrator/js/plugins/flot/jquery.flot.time.js',
                'Administrator/js/plugins/peity/jquery.peity.min.js',
                'Administrator/js/demo/peity-demo.js',
                'Administrator/js/inspinia.js',
                'Administrator/js/plugins/pace/pace.min.js',
                'Administrator/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js',
                'Administrator/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
                'Administrator/js/plugins/easypiechart/jquery.easypiechart.js',
                'Administrator/js/plugins/sparkline/jquery.sparkline.min.js',
                'Administrator/js/demo/sparkline-demo.js',
            ]
        ];
    }
}
