<?php

namespace App\Http\Controllers;

use App\Models\EditorialMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminEditorialMemberController extends Controller
{
    /**
     * Display a listing of editorial board members.
     */
    public function index()
    {
        $members = EditorialMember::orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(15);

        return view('admin.editorial.index', compact('members'));
    }

    /**
     * Show the form for creating a new editorial board member.
     */
    public function create()
    {
        return view('admin.editorial.create');
    }

    /**
     * Store a newly created editorial board member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'avatar_url' => 'nullable|string|max:1000',
            'bio' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $avatar = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80';

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            $filename = 'editorial_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            $uploadDir = public_path('uploads/editorial');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            
            $file->move($uploadDir, $filename);
            $avatar = '/uploads/editorial/' . $filename;
        } elseif ($request->filled('avatar_url')) {
            $avatar = $request->avatar_url;
        }

        EditorialMember::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'avatar' => $avatar,
            'bio' => $request->bio,
            'sort_order' => $request->input('sort_order', 0) ?? 0,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
        ]);

        return redirect()->route('admin.editorial-board.index')->with('success', 'Editorial Board member added successfully.');
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit($id)
    {
        $member = EditorialMember::findOrFail($id);
        return view('admin.editorial.edit', compact('member'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, $id)
    {
        $member = EditorialMember::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'avatar_url' => 'nullable|string|max:1000',
            'bio' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $avatar = $member->avatar;

        if ($request->hasFile('avatar_file')) {
            // Delete old file if local
            if ($member->avatar && str_starts_with($member->avatar, '/uploads/editorial/')) {
                $oldPath = public_path(ltrim($member->avatar, '/'));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('avatar_file');
            $filename = 'editorial_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            $uploadDir = public_path('uploads/editorial');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            
            $file->move($uploadDir, $filename);
            $avatar = '/uploads/editorial/' . $filename;
        } elseif ($request->filled('avatar_url')) {
            $avatar = $request->avatar_url;
        }

        $member->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'avatar' => $avatar,
            'bio' => $request->bio,
            'sort_order' => $request->input('sort_order', 0) ?? 0,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : false,
        ]);

        return redirect()->route('admin.editorial-board.index')->with('success', 'Editorial Board member updated successfully.');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy($id)
    {
        $member = EditorialMember::findOrFail($id);

        if ($member->avatar && str_starts_with($member->avatar, '/uploads/editorial/')) {
            $filePath = public_path(ltrim($member->avatar, '/'));
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $member->delete();

        return redirect()->route('admin.editorial-board.index')->with('success', 'Editorial Board member removed successfully.');
    }
}
