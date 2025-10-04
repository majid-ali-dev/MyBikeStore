<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatCustomerController extends Controller
{
        /**
    * Display Customer Live Chat Interface
    * Shows conversation with admin support
    *
    * @return \Illuminate\View\View
    */
    public function liveChat()
    {
        return view('customer.live-chat.index');
    }
}
