<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

class Inbox extends Component
{
    public $activeTab = 'chat'; // chat or notification
    public $conversations = [];
    public $notifications = [];

    public function mount()
    {
        $this->loadConversations();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.user.inbox')->layout('layouts.app', ['title' => 'Kotak Masuk']);
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    private function loadConversations()
    {
        $this->conversations = Conversation::with(['store', 'lastMessage'])
                                          ->where('user_id', Auth::id())
                                          ->orderBy('last_message_at', 'desc')
                                          ->get()
                                          ->map(function($conv) {
                                              return [
                                                  'id' => $conv->id,
                                                  'store_name' => $conv->store->name,
                                                  'store_logo' => $conv->store->logo ?? null,
                                                  'last_message' => $conv->lastMessage->message ?? '',
                                                  'last_message_time' => $conv->last_message_at ? $conv->last_message_at->format('d/m/y') : '',
                                                  'unread_count' => $conv->unreadCount(),
                                              ];
                                          })
                                          ->toArray();
    }

    private function loadNotifications()
    {
        $this->notifications = UserNotification::where('user_id', Auth::id())
                                               ->orderBy('created_at', 'desc')
                                               ->get()
                                               ->map(function($notif) {
                                                   return [
                                                       'id' => $notif->id,
                                                       'type' => $notif->type,
                                                       'title' => $notif->title,
                                                       'message' => $notif->message,
                                                       'icon' => $notif->icon,
                                                       'time' => $notif->created_at->diffForHumans(),
                                                       'is_read' => $notif->is_read,
                                                   ];
                                               })
                                               ->toArray();
    }

    public function openChat($conversationId)
    {
        return redirect()->route('chat.show', $conversationId);
    }

    public function markNotificationAsRead($notificationId)
    {
        UserNotification::where('id', $notificationId)
                       ->where('user_id', Auth::id())
                       ->update(['is_read' => true]);
        
        $this->loadNotifications();
    }
}