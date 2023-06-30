<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::orderBy("created_at", "asc")->paginate(10);

        return view("admin.pages.contact.index", compact("contacts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = decrypt($id);

        $result = Contact::where("id", "=", $id)->update([
            "status" => 1
        ]);

        $contact = $result ? Contact::where("id", "=", $id)->firstOrFail() : null;

        if ($contact == null)
            return redirect(route("contact.index"));

        return view("admin.pages.contact.read", compact("contact"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $error = null;
        $result = false;

        try {
            $id = decrypt($id);

            $result = Contact::where("id", $id)->firstOrFail()->delete();

        } catch (Exception $e) {

            $error = $e->getMessage();
        } finally {

            return response(["result" => (bool)$result, "error" => $error]);
        }
    }
}
