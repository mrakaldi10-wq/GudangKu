<div wire:poll.3s="refresh">
    <div class="card">
        <div class="row g-0">
            {{-- Daftar kontak --}}
            <div class="col-12 col-md-3 border-end">
                <div class="card-header">
                    <h3 class="card-title">Kontak</h3>
                </div>
                <div class="list-group list-group-flush" style="max-height: 500px; overflow-y: auto;">
                    @forelse ($partners as $partner)
                        <button
                            type="button"
                            wire:click="selectPartner({{ $partner->id }})"
                            class="list-group-item list-group-item-action {{ $partnerId == $partner->id ? 'active' : '' }}"
                        >
                            <div class="d-flex align-items-center">
                                <span class="avatar avatar-sm me-2 bg-blue-lt">
                                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                                </span>
                                <div>
                                    <div class="fw-semibold">{{ $partner->name }}</div>
                                    <div class="text-secondary small text-capitalize">{{ $partner->role }}</div>
                                </div>
                            </div>
                        </button>
                    @empty
                        <div class="p-3 text-secondary small">
                            Belum ada kontak yang bisa dihubungi.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Jendela chat --}}
            <div class="col-12 col-md-9">
                <div class="card-body d-flex flex-column" style="height: 560px;">
                    @if ($partnerId)
                        <div class="flex-fill overflow-auto mb-3 px-2" id="chat-scroll-box">
                            @forelse ($messages as $msg)
                                @php $isMine = $msg->sender_id === auth()->id(); @endphp
                                <div class="d-flex mb-2 {{ $isMine ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div class="{{ $isMine ? 'bg-primary text-white' : 'bg-light' }} rounded-3 px-3 py-2" style="max-width: 70%;">
                                        <div style="white-space: pre-line;">{{ $msg->message }}</div>
                                        <div class="{{ $isMine ? 'text-white-50' : 'text-secondary' }}" style="font-size: 11px;">
                                            {{ $msg->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-secondary text-center mt-5">
                                    Belum ada percakapan. Mulai kirim pesan.
                                </div>
                            @endforelse
                        </div>

                        <form wire:submit.prevent="sendMessage" class="d-flex gap-2">
                            <input
                                type="text"
                                wire:model="newMessage"
                                class="form-control"
                                placeholder="Tulis pesan..."
                                autocomplete="off"
                            >
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-send"></i> Kirim
                            </button>
                        </form>
                        @error('newMessage')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                            Pilih kontak di sebelah kiri untuk mulai chat.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:navigated', scrollChatToBottom);
    document.addEventListener('livewire:init', () => {
        Livewire.hook('morph.updated', () => scrollChatToBottom());
    });

    function scrollChatToBottom() {
        const box = document.getElementById('chat-scroll-box');
        if (box) {
            box.scrollTop = box.scrollHeight;
        }
    }

    scrollChatToBottom();
</script>
