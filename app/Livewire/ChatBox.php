<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\ChatMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ChatBox extends Component
{
    public $partnerId = null;
    public $newMessage = '';

    public function mount()
    {
        // otomatis pilih partner pertama kalau ada
        $partners = $this->partners;
        if ($partners->count() > 0) {
            $this->partnerId = $partners->first()->id;
        }
    }

    public function getPartnersProperty()
    {
        return Auth::user()->chatPartners();
    }

    public function getMessagesProperty()
    {
        if (!$this->partnerId) {
            return collect();
        }

        $userId = Auth::id();

        return ChatMessage::where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $this->partnerId);
            })
            ->orWhere(function ($q) use ($userId) {
                $q->where('sender_id', $this->partnerId)
                  ->where('receiver_id', $userId);
            })
            ->orderBy('created_at')
            ->get();
    }

    public function selectPartner($userId)
    {
        $this->partnerId = $userId;
        $this->markAsRead();
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:2000',
        ]);

        if (!$this->partnerId) {
            return;
        }

        ChatMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->partnerId,
            'message' => $this->newMessage,
        ]);

        $this->newMessage = '';
    }

    public function markAsRead()
    {
        if (!$this->partnerId) {
            return;
        }

        ChatMessage::where('sender_id', $this->partnerId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function getUnreadCountProperty()
    {
        return ChatMessage::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    // dipanggil otomatis tiap polling, sekaligus tandai pesan yang sedang dibuka sebagai terbaca
    public function refresh()
    {
        $this->markAsRead();
    }

    public function render()
    {
        return view('livewire.chat-box', [
            'partners' => $this->partners,
            'messages' => $this->messages,
            'unreadCount' => $this->unreadCount,
        ]);
    }
}
