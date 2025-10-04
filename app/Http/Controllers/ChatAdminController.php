<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatAdminController extends Controller
{
    /**
    * Display Admin Live Chat Interface
    * Shows all active customer conversations
    *
    * @return \Illuminate\View\View
    */
    public function liveChat()
    {
        return view('admin.live-chat.index');
    }
}
