<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Heart Spark | Find Your Perfect Match 💖</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    
    <style>
        .navbar-brand {
            color: #ff6b6b; /* Add your preferred brand color */
            font-size: 1.5rem;
        }

        .btn-primary {
            background-color: #ff6b6b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ff4a4a;
        }

        /* Adjustments for all views */
        .form-control {
            border-radius: 20px;
        }

        .navbar-nav .nav-link {
    transition: all 0.3s ease-in-out;
}

.navbar-nav .nav-link:hover {
    color: #ffeaa7 !important;
    transform: scale(1.1);
}

.navbar-toggler {
    font-size: 1.5rem;
}

.navbar-toggler:focus {
    outline: none;
    box-shadow: none;
}

    </style>
    
<!-- ✅ Smooth Animations -->
<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
    }

    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .btn-primary {
        background: linear-gradient(to right, #ff416c, #ff4b2b);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, #ff4b2b, #ff416c);
    }

    .chat-item {
    cursor: pointer !important;
    user-select: auto !important;
}
.chat-item.active {
    background-color: #90c4fc !important;
    color: white !important;
}

.chat-item.active h5 {
    color: white !important;
}

</style>
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Toastr JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module">
   import { initializeApp } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-app.js";
import { getFirestore, doc, setDoc, collection, addDoc, serverTimestamp } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-firestore.js";
import { getAuth } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-auth.js";

// Toastr setup
toastr.options = {
  "closeButton": true,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "timeOut": "3000" // 3 seconds
};

// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyBEX_fHfwQdQOX3IeL1CSznnIA67zga-ss",
  authDomain: "heart-spark-2af15.firebaseapp.com",
  projectId: "heart-spark-2af15",
  storageBucket: "heart-spark-2af15.appspot.com",
  messagingSenderId: "285799074278",
  appId: "1:285799074278:web:65191c043c1b382c36ae27",
  measurementId: "G-PTMKMXEC24"
};

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);
const auth = getAuth(app);

document.addEventListener('DOMContentLoaded', function () {
    const userIdLoggedIn = "{{ Auth::user() ? Auth::user()->id : '' }}";
    if (!userIdLoggedIn) {
        console.error('No user is logged in!');
        return;
    }

    document.querySelectorAll('.message-button').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');

            document.getElementById('chatUserName').textContent = userName;
            document.getElementById('sendMessageButton').setAttribute('data-user-id', userId);

            const chatId = userId < userIdLoggedIn ? `${userId}_${userIdLoggedIn}` : `${userIdLoggedIn}_${userId}`;
            const chatRef = doc(db, "chats", chatId);

            // Ensure chat document exists
            setDoc(chatRef, {
                users: [userIdLoggedIn, userId],
                updated_at: serverTimestamp()
            }, { merge: true })
            .catch(error => console.error("Error creating chat:", error));
        });
    });

    // Attach event listener to the send button only once
    document.getElementById('sendMessageButton').addEventListener('click', async function () {
        const userId = this.getAttribute('data-user-id');
        const message = document.getElementById('messageInput').value.trim();
        if (!message) {
            toastr.error("Please type a message before sending.");
            return;
        }

        const chatId = userId < userIdLoggedIn ? `${userId}_${userIdLoggedIn}` : `${userIdLoggedIn}_${userId}`;
        const messagesCollection = collection(db, "chats", chatId, "messages");

        try {
            await addDoc(messagesCollection, {
                sender_id: userIdLoggedIn,
                message: message,
                timestamp: serverTimestamp()
            });

            // Update 'updated_at' field in chat document to keep track of last message
            await setDoc(doc(db, "chats", chatId), { updated_at: serverTimestamp() }, { merge: true });

            document.getElementById('messageInput').value = ''; // Clear input
            toastr.success("Message sent successfully!");
        } catch (error) {
            console.error("Error sending message:", error);
            toastr.error("Error sending message: " + error.message);
        }
    });
});


      </script>
<script>
    $(document).ready(function () {
        $(".like-button").click(function () {
            var button = $(this); // Reference to the clicked button
            var likedUserId = button.data("user-id");

            // Send AJAX request
            $.ajax({
                url: "{{ route('like.user') }}", // Ensure this matches your route
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}", // CSRF Token for security
                    liked_user_id: likedUserId // Match request key in controller
                },
                success: function (response) {
                    if (response.upgrade_required) {
                        toastr.warning(response.message, "Upgrade Required");
                    } else {
                        button.removeClass("btn-primary").addClass("btn-success").text("❤️ Liked");
                        toastr.success("You will be matched if the user Like you back", "Success");
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 403) {
                        toastr.error(xhr.responseJSON.message, "Error");
                    } else {
                        toastr.error("An error occurred. Please try again.", "Error");
                    }
                }
            });
        });
    });
</script>

      
</body>
</html>
