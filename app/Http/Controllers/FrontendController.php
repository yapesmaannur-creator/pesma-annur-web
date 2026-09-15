<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function showPage($slug = '/')
    {
        if ($slug === '/') {
            $slug = 'beranda';
        }
        
        // Temukan halaman berdasarkan slug
        $page = Page::with(['sections' => function($query) {
            $query->where('is_active', true)->orderBy('order', 'asc')->with(['items' => function($q) {
                $q->where('is_active', true)->orderBy('order', 'asc');
            }]);
        }])->where('slug', $slug)->where('is_active', true)->first();

        // Jika halaman tidak ditemukan, kembalikan 404
        if (!$page) {
            abort(404);
        }

        $youtubeVideos = [];
        // YouTube: ambil channel ID dan API Key dari settings
        $youtubeChannelId = \App\Models\Setting::getByKey('youtube_channel_id', 'UCKZmhY77OUZBs30S_vKhK8A');
        $youtubeApiKey = \App\Models\Setting::getByKey('youtube_api_key', '');
        if ($page->slug === 'beranda' && !empty($youtubeChannelId)) {
            $youtubeVideos = \Illuminate\Support\Facades\Cache::remember('youtube_videos_' . $youtubeChannelId, 3600, function () use ($youtubeChannelId, $youtubeApiKey) {
                $videos = [];

                // === Metode 1: YouTube Data API v3 (Resmi & Stabil) ===
                if (!empty($youtubeApiKey)) {
                    try {
                        $apiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=' . $youtubeChannelId . '&maxResults=3&order=date&type=video&key=' . $youtubeApiKey;
                        $response = \Illuminate\Support\Facades\Http::timeout(10)->withoutVerifying()->get($apiUrl);
                        if ($response->successful()) {
                            $data = $response->json();
                            if (isset($data['items'])) {
                                foreach ($data['items'] as $item) {
                                    $videoId = $item['id']['videoId'] ?? null;
                                    if ($videoId) {
                                        $videos[] = [
                                            'id' => $videoId,
                                            'title' => $item['snippet']['title'] ?? 'Video',
                                            'thumbnail' => $item['snippet']['thumbnails']['high']['url'] ?? 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg',
                                            'link' => 'https://www.youtube.com/watch?v=' . $videoId
                                        ];
                                    }
                                }
                            }
                        } else {
                            \Illuminate\Support\Facades\Log::warning('YouTube API response error: ' . $response->status() . ' - ' . $response->body());
                        }
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::warning('YouTube API fetch failed: ' . $e->getMessage());
                    }
                }

                // === Metode 2: Fallback ke RSS Feed (jika API Key kosong atau API gagal) ===
                if (empty($videos)) {
                    try {
                        $url = 'https://www.youtube.com/feeds/videos.xml?channel_id=' . $youtubeChannelId;
                        $xmlStr = false;
                        try {
                            $response = \Illuminate\Support\Facades\Http::timeout(10)->withoutVerifying()
                                ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64)')
                                ->get($url);
                            if ($response->successful()) {
                                $xmlStr = $response->body();
                            }
                        } catch (\Exception $e) {
                            // silent
                        }
                        if (!$xmlStr) {
                            $ctx = stream_context_create([
                                'http' => ['timeout' => 10, 'ignore_errors' => true, 'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"],
                                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
                            ]);
                            $xmlStr = @file_get_contents($url, false, $ctx);
                        }
                        if ($xmlStr) {
                            $xml = @simplexml_load_string($xmlStr);
                            if ($xml !== false && isset($xml->entry)) {
                                $count = 0;
                                foreach ($xml->entry as $entry) {
                                    if ($count >= 3) break;
                                    $videoId = (string) str_replace('yt:video:', '', $entry->id);
                                    $videos[] = [
                                        'id' => $videoId,
                                        'title' => (string) $entry->title,
                                        'thumbnail' => 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg',
                                        'link' => (string) $entry->link['href']
                                    ];
                                    $count++;
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('YouTube RSS fallback failed: ' . $e->getMessage());
                    }
                }

                return $videos;
            });
        }

        return view('frontend.pages.dynamic', compact('page', 'youtubeVideos'));
    }

    public function activityDetail($slug)
    {
        $activity = \App\Models\Activity::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return view('frontend.pages.activity-detail', compact('activity'));
    }
}
