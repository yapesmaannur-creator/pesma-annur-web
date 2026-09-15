<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleSubmission;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleSubmissionController extends Controller
{
    public function index()
    {
        $submissions = ArticleSubmission::latest()->paginate(15);
        return view('admin.submissions.index', compact('submissions'));
    }

    public function show(ArticleSubmission $submission)
    {
        return view('admin.submissions.show', compact('submission'));
    }

    public function update(Request $request, ArticleSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string',
            'category_id' => 'nullable|required_if:status,approved|exists:categories,id',
            'post_status' => 'nullable|required_if:status,approved|in:draft,publish',
        ]);

        $submission->status = $request->status;
        $submission->admin_notes = $request->admin_notes;
        $submission->save();

        $postLink = null;
        if ($request->status === 'approved') {
            $post = new Post();
            $post->title = $submission->title;
            $slug = Str::slug($submission->title);
            $count = Post::where('slug', 'LIKE', "{$slug}%")->count();
            $post->slug = $count > 0 ? "{$slug}-{$count}" : $slug;
            
            $post->body_content = $submission->content;
            $post->excerpt = Str::limit(strip_tags($submission->content), 150);
            $post->category_id = $request->category_id;
            $post->user_id = \Illuminate\Support\Facades\Auth::id();
            
            $authorNote = "<hr><p><em>Ditulis oleh: {$submission->author_name}</em></p>";
            $post->body_content .= $authorNote;

            $post->published_at = $request->post_status === 'publish' ? now() : null;

            // If submission has an image attachment, copy it to the Post as its thumbnail/cover image
            if ($submission->attachment_path) {
                $ext = strtolower(pathinfo($submission->attachment_path, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    $newPath = 'posts/' . basename($submission->attachment_path);
                    if (Storage::disk('public')->exists($submission->attachment_path)) {
                        Storage::disk('public')->copy($submission->attachment_path, $newPath);
                        $post->image_path = $newPath;
                    }
                }
            }

            $post->save();
            
            $postLink = url('/artikel/' . $post->slug);
        }

        // Kirim email pemberitahuan ke penulis (untuk SEMUA status: approved, rejected)
        $emailSent = false;
        try {
            \Illuminate\Support\Facades\Mail::to($submission->author_email)
                ->send(new \App\Mail\ArticleSubmissionStatusUpdated($submission, $request->post_status ?? null, $postLink));
            $emailSent = true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail status error: ' . $e->getMessage());
        }

        if ($request->status === 'approved') {
            $msg = $request->post_status === 'publish' 
                ? 'Tulisan disetujui dan berhasil dipublikasikan!' 
                : 'Tulisan disetujui dan masuk ke tahap Copy Editing (Draft). Silakan lengkapi gambar sampul & publish.';
            $msg .= $emailSent ? ' Email notifikasi telah dikirim ke penulis.' : ' (Catatan: Notifikasi email gagal terkirim).';
            
            // Jika disimpan sebagai Draft, langsung arahkan Admin ke halaman Edit Artikel agar bisa unggah gambar cover
            if ($request->post_status === 'draft') {
                return redirect()->route('admin.posts.edit', $post->id)->with('success', $msg);
            }

            return redirect()->route('admin.submissions.index')->with('success', $msg);
        }

        if ($request->status === 'rejected') {
            $msg = 'Tulisan berhasil ditolak.';
            $msg .= $emailSent ? ' Email pemberitahuan penolakan berhasil terkirim ke penulis.' : ' PERINGATAN: Email penolakan gagal terkirim!';
            return redirect()->route('admin.submissions.index')->with('success', $msg);
        }

        return redirect()->route('admin.submissions.index')->with('success', 'Status tulisan berhasil diperbarui.');
    }

    public function destroy(ArticleSubmission $submission)
    {
        if ($submission->attachment_path && Storage::disk('public')->exists($submission->attachment_path)) {
            Storage::disk('public')->delete($submission->attachment_path);
        }
        $submission->delete();
        return redirect()->route('admin.submissions.index')->with('success', 'Data kiriman tulisan berhasil dihapus.');
    }

    public function sendFollowUp(Request $request, ArticleSubmission $submission)
    {
        $request->validate([
            'followup_message' => 'required|string',
        ]);

        // Simpan histori pesannya ke admin notes agar terekam
        $pesanBaru = "[Follow Up / Email Revisi]:\n" . $request->followup_message;
        $submission->admin_notes = empty($submission->admin_notes) ? $pesanBaru : $submission->admin_notes . "\n\n" . $pesanBaru;
        $submission->save();

        try {
            \Illuminate\Support\Facades\Mail::to($submission->author_email)
                ->send(new \App\Mail\ArticleSubmissionFollowUp($submission, $request->followup_message));
            return redirect()->back()->with('success', 'Pesan / email lanjutan berhasil dikirimkan ke Penulis!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail followup error: ' . $e->getMessage());
            return redirect()->back()->with('success', 'Email gagal terkirim karena terjadi masalah SMTP. Kesalahan: ' . $e->getMessage());
        }
    }

    public function notifyLive(Request $request, ArticleSubmission $submission)
    {
        $request->validate([
            'post_link' => 'required|url',
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($submission->author_email)
                ->send(new \App\Mail\ArticleSubmissionLive($submission, $request->post_link));
            return redirect()->back()->with('success', 'Notifikasi pemuatan tayangan (Live) berhasil dikirim otomatis ke email Penulis!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail live notif error: ' . $e->getMessage());
            return redirect()->back()->with('success', 'Email gagal terkirim karena terjadi masalah SMTP. Kesalahan: ' . $e->getMessage());
        }
    }
}
