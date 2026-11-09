<?php

namespace App\Http\Controllers;

use App\Models\RiwayatUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatUploadController extends Controller
{
    private function authorizeUploadHistory(): void
    {
        abort_unless(
            in_array(
                Auth::user()->role?->nama_role,
                ['superadmin', 'admin_tu'],
                true
            ),
            403
        );
    }

    public function index()
    {
        $this->authorizeUploadHistory();

        $riwayat = RiwayatUpload::with('user')
            ->latest('uploaded_at')
            ->paginate(15);

        return view('riwayat_upload.index', compact('riwayat'));
    }

    public function show(RiwayatUpload $riwayatUpload)
    {
        $this->authorizeUploadHistory();

        $riwayatUpload->load('user');

        return view('riwayat_upload.show', compact('riwayatUpload'));
    }
}
