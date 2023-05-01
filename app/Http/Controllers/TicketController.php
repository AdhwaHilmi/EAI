<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Ambil semua data.
     */
    public function index()
    {
        $tickets = Ticket::all();
        return response()->json([
            'success' => true,
            "data" => $tickets
        ], 200);
    }

    /**
     * Input satu data.
     */
    public function store(Request $request)
    {
        Ticket::create([
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        return response()->json([
            'success' => true,
            "message" => "success add ticket"
        ], 200);
    }

    /**
     * Ambil satu data.
     */
    public function show(string $id)
    {
        $ticket = Ticket::where('id', '=',$id)->first();
        return response()->json([
            'success' => true,
            "data" => $ticket
        ], 200);
    }

    /**
     * Update satu data.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $ticket = Ticket::where('id', '=',$id)->first();

        $ticket["name"] = $input["name"] ?? $ticket["name"];
        $ticket["qty"] = $input["qty"] ?? $ticket["qty"];
        $ticket["price"] = $input["price"] ?? $ticket["price"];
        $ticket->save();


        return response()->json([
            'success' => true,
            "message" => "success update ticket"
        ], 200);
    }

    /**
     * Delete satu data.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::where('id', '=',$id)->first();
        $ticket->delete();

        return response()->json([
            'success' => true,
            "message" => "success delete ticket"
        ], 200);
    }
}
