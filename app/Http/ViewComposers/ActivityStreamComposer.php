<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Post;
use App\Models\Contact;
use App\Models\User;
use App\Models\ArticleSubmission;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class ActivityStreamComposer
{
    public function compose(View $view)
    {
        $activities = collect();

        // Get latest posts
        try {
            $posts = Post::with('user')->latest('published_at')->whereNotNull('published_at')->take(3)->get()->map(function($post) {
                return [
                    'type' => 'post',
                    'title' => 'Artikel Diterbitkan',
                    'description' => ($post->user->name ?? 'Admin') . ' menerbitkan: "' . \Illuminate\Support\Str::limit($post->title, 40) . '"',
                    'icon' => 'solar:document-text-bold-duotone',
                    'color' => 'primary',
                    'time' => $post->published_at ?? $post->created_at,
                    'link' => route('admin.posts.edit', $post->id)
                ];
            });
            $activities = $activities->concat($posts);
        } catch (\Exception $e) {}

        // Get latest contacts
        try {
            $contacts = Contact::latest()->take(3)->get()->map(function($contact) {
                return [
                    'type' => 'contact',
                    'title' => 'Pesan Masuk Baru',
                    'description' => $contact->name . ' mengirim: "' . \Illuminate\Support\Str::limit($contact->subject ?? $contact->message, 40) . '"',
                    'icon' => 'solar:letter-bold-duotone',
                    'color' => 'danger',
                    'time' => $contact->created_at,
                    'link' => route('admin.contacts.show', $contact->id)
                ];
            });
            $activities = $activities->concat($contacts);
        } catch (\Exception $e) {}

        // Get latest article submissions
        try {
            $submissions = ArticleSubmission::latest()->take(3)->get()->map(function($submission) {
                $statusMap = [
                    'pending' => ['title' => 'Tulisan Baru Masuk', 'color' => 'warning', 'icon' => 'solar:pen-new-square-bold-duotone'],
                    'approved' => ['title' => 'Tulisan Disetujui', 'color' => 'success', 'icon' => 'solar:check-circle-bold-duotone'],
                    'rejected' => ['title' => 'Tulisan Ditolak', 'color' => 'danger', 'icon' => 'solar:close-circle-bold-duotone'],
                ];
                $info = $statusMap[$submission->status] ?? $statusMap['pending'];
                return [
                    'type' => 'submission',
                    'title' => $info['title'],
                    'description' => $submission->author_name . ' mengirim tulisan: "' . \Illuminate\Support\Str::limit($submission->title, 35) . '"',
                    'icon' => $info['icon'],
                    'color' => $info['color'],
                    'time' => $submission->created_at,
                    'link' => route('admin.submissions.show', $submission->id)
                ];
            });
            $activities = $activities->concat($submissions);
        } catch (\Exception $e) {}

        // Get latest kegiatan (activities)
        try {
            $kegiatan = Activity::latest()->take(2)->get()->map(function($item) {
                return [
                    'type' => 'activity',
                    'title' => 'Kegiatan: ' . $item->status_label,
                    'description' => '"' . \Illuminate\Support\Str::limit($item->title, 40) . '"' . ($item->location ? ' di ' . $item->location : ''),
                    'icon' => 'solar:calendar-bold-duotone',
                    'color' => $item->status_color,
                    'time' => $item->created_at,
                    'link' => route('admin.activities.show', $item->id)
                ];
            });
            $activities = $activities->concat($kegiatan);
        } catch (\Exception $e) {}

        // Get latest active user login sessions from sessions table
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('sessions')) {
                $recentSessions = DB::table('sessions')
                    ->whereNotNull('user_id')
                    ->orderBy('last_activity', 'desc')
                    ->take(3)
                    ->get();

                $userIds = $recentSessions->pluck('user_id')->unique();
                $usersMap = User::whereIn('id', $userIds)->get()->keyBy('id');

                $sessionLogs = $recentSessions->map(function($session) use ($usersMap) {
                    $u = $usersMap[$session->user_id] ?? null;
                    $userName = $u ? $u->name : 'Pengguna';
                    $roleName = $u ? ucfirst($u->role ?? 'User') : 'Admin';
                    return [
                        'type' => 'user_session',
                        'title' => 'Aktivitas Sesi Login',
                        'description' => '<strong>' . e($userName) . '</strong> (' . e($roleName) . ') aktif dari IP: <code>' . e($session->ip_address) . '</code>',
                        'icon' => 'solar:shield-user-bold-duotone',
                        'color' => 'info',
                        'time' => \Carbon\Carbon::createFromTimestamp($session->last_activity),
                        'link' => '#'
                    ];
                });

                $activities = $activities->concat($sessionLogs);
            }
        } catch (\Exception $e) {}

        // Get latest users
        try {
            $users = User::latest()->take(2)->get()->map(function($user) {
                return [
                    'type' => 'user',
                    'title' => 'Pengguna Terdaftar',
                    'description' => $user->name . ' (' . $user->email . ') sebagai ' . ($user->role ?? 'user'),
                    'icon' => 'solar:user-rounded-bold-duotone',
                    'color' => 'success',
                    'time' => $user->created_at,
                    'link' => '#'
                ];
            });
            $activities = $activities->concat($users);
        } catch (\Exception $e) {}

        // Sort by time descending and take top 10
        $stream = $activities->sortByDesc('time')->take(10)->values();

        $view->with('activityStream', $stream);
    }
}
