<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ArticleSubmission;
use Illuminate\Http\Request;

class ArticleSubmissionController extends Controller
{
    public function create()
    {
        return view('frontend.pages.kirim-tulisan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'author_phone' => 'nullable|string|max:20',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        $submission = new ArticleSubmission();
        $submission->fill($request->only([
            'author_name',
            'author_email',
            'author_phone',
            'title',
            'content'
        ]));

        if ($request->hasFile('attachment')) {
            $submission->attachment_path = $request->file('attachment')->store('submissions', 'public');
        }

        $submission->save();

        // Kirim email konfirmasi ke penulis (jika gagal, tidak memblokir notifikasi admin)
        try {
            \Illuminate\Support\Facades\Mail::to($submission->author_email)
                ->send(new \App\Mail\ArticleSubmissionReceived($submission));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail error (Author): ' . $e->getMessage());
        }
                
        // Kirim notifikasi ke email utama website & tim redaksi
        try {
            $adminEmail = \App\Models\Setting::where('key', 'contact_email')->value('value') ?? 'admin@pesantren.com';
            
            // Kumpulkan email tim redaksi yang valid (bukan null atau kosong)
            $redaksiEmails = \App\Models\User::whereIn('role', ['editor', 'admin'])
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->toArray();
                
            // Hindari duplikasi pengiriman email ke admin utama jika dia masuk role
            $redaksiEmails = array_diff($redaksiEmails, [$adminEmail]);
            
            $adminMail = \Illuminate\Support\Facades\Mail::to($adminEmail);
            
            if (!empty($redaksiEmails)) {
                $adminMail->bcc($redaksiEmails); // Tambahkan semua tim redaksi ke tembusan BCC
            }
            
            $adminMail->send(new \App\Mail\ArticleSubmissionAdminNotification($submission));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail error (Admin/Redaksi): ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Terima kasih! Tulisan Anda berhasil dikirim dan akan direview oleh admin kami.');
    }
}
