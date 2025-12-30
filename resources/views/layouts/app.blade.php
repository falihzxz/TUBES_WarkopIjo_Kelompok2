<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Warkop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <style>
        .font-bodoni {
            font-family: 'Playfair Display', 'Bodoni MT', serif;
            font-weight: 900;
            letter-spacing: -0.5px;
        }
        .custom-green {
            background-color: #499587;
        }
        .custom-green-hover:hover {
            background-color: #3a7a6f;
        }
        .text-custom-green {
            color: #499587;
        }
        .border-custom-green {
            border-color: #499587;
        }
        .bg-custom-green-gradient {
            background: linear-gradient(to right, #499587, #5aa897);
        }
        .from-custom-green {
            --tw-gradient-from: #499587;
            --tw-gradient-to: rgb(73 149 135 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .to-custom-green {
            --tw-gradient-to: #5aa897;
        }
    </style>
</head>
<body class="bg-white min-h-screen">
    <!-- Kontainer untuk content -->
    <div class="w-full p-4">
        @yield('content')
    </div>

    <!-- Modal Konfirmasi -->
    <div id="confirmModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        
        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-sm w-full">
                <!-- Close Button -->
                <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Modal Body -->
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-yellow-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 text-center mb-2">
                        Konfirmasi
                    </h3>
                    <p id="confirmMessage" class="text-gray-500 text-center mb-6">
                        Apakah Anda yakin?
                    </p>

                    <!-- Buttons -->
                    <div class="flex gap-3">
                        <button onclick="closeModal()" class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium transition">
                            Batal
                        </button>
                        <button onclick="confirmAction()" class="flex-1 px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 font-medium transition">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let pendingAction = null;

        function openModal(message, action) {
            document.getElementById('confirmMessage').textContent = message;
            document.getElementById('confirmModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            pendingAction = action;
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            pendingAction = null;
        }

        function confirmAction() {
            if (pendingAction) {
                if (typeof pendingAction === 'function') {
                    pendingAction();
                } else if (pendingAction.form) {
                    pendingAction.form.submit();
                } else if (pendingAction.url) {
                    window.location.href = pendingAction.url;
                }
            }
            closeModal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Handle form submissions with data-confirm-action
            document.querySelectorAll('[data-confirm-action]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    const message = this.getAttribute('data-confirm-action');
                    
                    if (form) {
                        openModal(message, { form: form });
                    }
                });
            });

            // Handle links with data-confirm-link
            document.querySelectorAll('[data-confirm-link]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const message = this.getAttribute('data-confirm-link');
                    const url = this.getAttribute('href');
                    
                    openModal(message, { url: url });
                });
            });

            // Close modal when clicking backdrop
            document.getElementById('confirmModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>
