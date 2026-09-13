<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div x-data="aiChat()" class="max-w-7xl mx-auto py-8 px-4 sm:px-6">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-2 font-outfit">
            Smart AI <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">Assistant</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Asisten cerdas bertenaga Gemini 2.5 & 3.1 yang bisa melihat gambar dan mengingat percakapan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start h-[95vh]">
        
        <div class="lg:col-span-3 space-y-6 flex flex-col h-full">
            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl">
                <div class="flex items-center gap-3 mb-4 text-amber-500">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h3 class="font-bold text-sm uppercase tracking-wider">Privacy Mode</h3>
                </div>
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                    API Key Anda disimpan di <strong>Local Storage</strong> browser. Kami tidak menyimpannya di database kami.
                </p>
                <div class="relative mb-6">
                    <input :type="showKey ? 'text' : 'password'" x-model="apiKey" @input="saveKey()" 
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 pr-12 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all" 
                           placeholder="Gemini API Key...">
                    <button @click="showKey = !showKey" class="absolute right-4 top-3.5 text-slate-400 hover:text-indigo-500">
                        <i class="fa-solid" :class="showKey ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                    <a href="https://aistudio.google.com/app/apikey" target="_blank" class="text-[10px] text-indigo-500 font-bold mt-2 inline-flex items-center gap-1 hover:underline">
                        Dapatkan API Key Gratis <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
                
                <div class="flex items-center gap-3 mb-4 text-indigo-500">
                    <i class="fa-solid fa-microchip"></i>
                    <h3 class="font-bold text-sm uppercase tracking-wider">AI Engine</h3>
                </div>
                <div class="relative mb-4">
                    <select x-model="aiModel" @change="saveToLocal()" class="w-full bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800/50 rounded-xl py-3 px-4 text-sm font-bold text-indigo-700 dark:text-indigo-400 outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                        <option value="gemini-2.5-flash">Gemini 2.5 Flash (Tercepat)</option>
                        <option value="gemini-3.1-flash-preview">Gemini 3.1 Flash (Next-Gen)</option>
                        <option value="gemini-3.1-pro-preview">Gemini 3.1 Pro (Advanced)</option>
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-indigo-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700 my-6">
                
                <button @click="confirmClear()" class="w-full bg-rose-50 dark:bg-rose-900/20 text-rose-500 hover:bg-rose-100 dark:hover:bg-rose-900/40 font-bold py-3 rounded-xl transition flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-broom"></i> Bersihkan Obrolan
                </button>
            </div>
        </div>

        <div class="lg:col-span-9 bg-white dark:bg-slate-900/80 rounded-[1.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl flex flex-col h-full overflow-hidden relative">
            
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-white/50 dark:bg-slate-900/50 backdrop-blur-md z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-white text-sm" x-text="aiModel === 'gemini-3.1-pro-preview' ? 'Gemini 3.1 Pro Assistant' : 'Gemini 2.5/3.1 Flash'"></h3>
                        <div class="flex items-center gap-1.5 text-[10px] text-emerald-500 font-bold tracking-wider uppercase">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Vision & Memory Active
                        </div>
                    </div>
                </div>
            </div>

            <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50/50 dark:bg-[#0f172a]/50">
                
                <div x-show="chatHistory.length === 0" class="flex flex-col items-center justify-center h-full opacity-50">
                    <i class="fa-regular fa-comments text-6xl text-slate-300 dark:text-slate-600 mb-4"></i>
                    <p class="text-sm font-medium text-slate-500 text-center">Mulai percakapan atau kirim gambar untuk dianalisis.</p>
                </div>

                <template x-for="(chat, index) in chatHistory" :key="index">
                    <div class="flex w-full" :class="chat.role === 'user' ? 'justify-end' : 'justify-start'">
                        <div class="max-w-[85%] sm:max-w-[80%] flex flex-col gap-1" :class="chat.role === 'user' ? 'items-end' : 'items-start'">
                            
                            <span class="text-[10px] font-bold text-slate-400 px-2" x-text="chat.role === 'user' ? 'Kamu' : 'AI Assistant'"></span>
                            
                            <div class="px-4 sm:px-5 py-3 rounded-2xl text-sm leading-relaxed shadow-sm" 
                                 :class="chat.role === 'user' ? 'bg-indigo-500 text-white rounded-tr-sm' : 'bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-tl-sm'">
                                
                                <template x-if="chat.imagePreview">
                                    <img :src="chat.imagePreview" class="max-w-[150px] sm:max-w-[200px] rounded-lg mb-2 border border-white/20 shadow-md">
                                </template>
                                
                                <div :class="chat.role === 'model' ? 'custom-prose prose-sm dark:prose-invert max-w-none' : ''" x-html="chat.role === 'model' ? formatText(chat.text) : chat.text"></div>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="loading" style="display: none;" class="flex w-full justify-start" x-transition>
                    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl rounded-tl-sm px-5 py-4 shadow-sm flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-slate-400 animate-bounce"></span>
                        <span class="w-2 h-2 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0.1s"></span>
                        <span class="w-2 h-2 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0.2s"></span>
                    </div>
                </div>

            </div>

            <div class="p-3 sm:p-4 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 z-10 relative">
                
                <div x-show="imagePreview" style="display: none;" class="absolute -top-24 left-4 sm:left-6 bg-white dark:bg-slate-800 p-2 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700" x-transition>
                    <button @click="removeImage()" class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center text-xs shadow-md hover:scale-110 transition"><i class="fa-solid fa-times"></i></button>
                    <img :src="imagePreview" class="h-16 w-auto rounded-lg object-cover">
                </div>

                <div class="flex items-end gap-2 sm:gap-3">
                    <label class="cursor-pointer flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 rounded-xl flex items-center justify-center text-slate-500 transition-colors">
                        <i class="fa-solid fa-image text-sm sm:text-base"></i>
                        <input type="file" @change="handleImage" accept="image/*" class="hidden">
                    </label>
                    
                    <textarea x-model="message" @keydown.enter.prevent="sendMessage()" rows="2" class="flex-1 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-2 sm:py-3 px-3 sm:px-4 text-sm text-slate-800 dark:text-white outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all resize-y min-h-[44px] sm:min-h-[52px] max-h-32" placeholder="Ketik pesan..."></textarea>
                    
                    <button @click="sendMessage()" :disabled="loading || (!message.trim() && !imageFile)" class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl flex items-center justify-center transition-colors disabled:opacity-50 shadow-lg shadow-indigo-500/30">
                        <i class="fa-solid fa-paper-plane text-sm sm:text-base"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <template x-teleport="body">
        <div x-show="errorModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6">
            <div x-show="errorModal" x-transition.opacity @click="errorModal = false" class="absolute inset-0 bg-slate-900/90 backdrop-blur-md"></div>
            <div x-show="errorModal" x-transition.scale.95 class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-white/10 overflow-hidden text-center p-8">
                <div class="w-20 h-20 bg-rose-500/10 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3">Peringatan</h3>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-8 text-sm leading-relaxed" x-text="errorMessage"></p>
                <button @click="errorModal = false" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-rose-500/30">
                    Mengerti
                </button>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="clearModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6">
            <div x-show="clearModal" x-transition.opacity @click="clearModal = false" class="absolute inset-0 bg-slate-900/90 backdrop-blur-md"></div>
            <div x-show="clearModal" x-transition.scale.95 class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-white/10 overflow-hidden text-center p-8">
                <div class="w-20 h-20 bg-rose-500/10 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3">Hapus Obrolan?</h3>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-8 text-sm leading-relaxed">
                    Apakah Anda yakin ingin menghapus semua memori percakapan ini? Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex gap-3">
                    <button @click="clearModal = false" class="flex-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold py-3.5 rounded-2xl transition">
                        Batal
                    </button>
                    <button @click="executeClearChat()" class="flex-1 bg-rose-500 hover:bg-rose-600 text-white font-bold py-3.5 rounded-2xl transition shadow-lg shadow-rose-500/30">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </template>

</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
function aiChat() {
    return {
        apiKey: localStorage.getItem('gemini_api_key') || '',
        aiModel: localStorage.getItem('gemini_chat_model') || 'gemini-2.5-flash',
        showKey: false,
        message: '',
        imageFile: null,
        imagePreview: null,
        chatHistory: JSON.parse(localStorage.getItem('gemini_chat_history')) || [],
        loading: false,
        errorModal: false,
        errorMessage: '',
        clearModal: false,

        saveKey() {
            localStorage.setItem('gemini_api_key', this.apiKey);
        },

        saveToLocal() {
            localStorage.setItem('gemini_chat_model', this.aiModel);
        },

        saveHistory() {
            localStorage.setItem('gemini_chat_history', JSON.stringify(this.chatHistory));
            this.scrollToBottom();
        },

        showError(msg) {
            this.errorMessage = msg;
            this.errorModal = true;
        },

        confirmClear() {
            this.clearModal = true;
        },

        executeClearChat() {
            this.chatHistory = [];
            this.imageFile = null;
            this.imagePreview = null;
            localStorage.removeItem('gemini_chat_history');
            this.clearModal = false;
        },

        handleImage(event) {
            const file = event.target.files[0];
            if (file) {
                this.imageFile = file;
                this.imagePreview = URL.createObjectURL(file);
            }
        },

        removeImage() {
            this.imageFile = null;
            this.imagePreview = null;
            document.querySelector('input[type="file"]').value = '';
        },

        scrollToBottom() {
            setTimeout(() => {
                const container = document.getElementById('chat-container');
                if (container) container.scrollTop = container.scrollHeight;
            }, 100);
        },

        formatText(text) {
            return marked.parse(text);
        },

        async sendMessage() {
            if (!this.apiKey) {
                this.showError("Masukkan API Key terlebih dahulu!");
                return;
            }
            if (!this.message.trim() && !this.imageFile) return;

            const userMsg = {
                role: 'user',
                text: this.message,
                imagePreview: this.imagePreview 
            };
            
            const msgToSend = this.message;
            const fileToSend = this.imageFile;
            
            this.chatHistory.push(userMsg);
            this.message = '';
            this.removeImage(); 
            this.scrollToBottom();
            this.loading = true;

            let formData = new FormData();
            formData.append('apiKey', this.apiKey);
            formData.append('aiModel', this.aiModel); 
            formData.append('message', msgToSend);
            
            const cleanHistory = this.chatHistory.slice(0, -1).map(chat => ({
                role: chat.role,
                text: chat.text
            }));
            formData.append('history', JSON.stringify(cleanHistory)); 
            
            if (fileToSend) {
                formData.append('image', fileToSend);
            }
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            try {
                const response = await fetch('<?= base_url('ailab/send-chat') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.content) {
                    this.chatHistory.push({
                        role: 'model',
                        text: data.content
                    });
                    this.saveHistory(); 
                } else {
                    this.showError(data.error || "Gagal mendapatkan balasan dari AI.");
                    this.chatHistory.pop(); 
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                this.showError("Terjadi kesalahan jaringan.");
                this.chatHistory.pop();
            } finally {
                this.loading = false;
                this.scrollToBottom();
            }
        }
    };
}

document.addEventListener('alpine:initialized', () => {
    setTimeout(() => {
        const container = document.getElementById('chat-container');
        if(container) container.scrollTop = container.scrollHeight;
    }, 300);
});
</script>
<?= $this->endSection() ?>