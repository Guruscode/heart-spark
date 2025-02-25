@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('layouts.nav')
    <!-- Chat Section -->
    <div class="row mt-5 pt-4">
        <div class="col-lg-9 mx-auto">
            <h1 class="mb-4">Inbox</h1>

            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">Messages</div>
                <div class="card-body d-flex flex-column flex-lg-row">
                    <!-- Chat List -->
                    <div class="list-group w-100 w-lg-25 mb-3 mb-lg-0" id="chat-list" style="max-height: 500px; overflow-y: auto;">
                        @forelse ($chats as $chat)
                        <div class="list-group-item list-group-item-action chat-item" 
                             data-user-id="{{ $chat['other_user_id'] }}" 
                             data-user-name="{{ $chat['other_user_name'] }}"
                             data-user-image="{{ $chat['other_user_image'] }}"> <!-- Add this line -->
                            <div class="d-flex align-items-center">
                                <!-- Profile Image -->
                              
                                <img src="  {{ asset('storage/' .$chat['other_user_image']) }}" alt="{{ $chat['other_user_name'] }}" class="rounded-circle mr-3" style="width: 40px; height: 40px;">
                                <div>
                                    <h5 class="mb-1">{{ $chat['other_user_name'] }}</h5>
                                    <p class="mb-1 text-muted">{{ Str::limit($chat['content'], 50) }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No messages found</p>
                    @endforelse
                    </div>

                    <!-- Message Display -->
                    <div class="w-100 w-lg-75 pl-lg-3">
                        <div id="chat-header" class="bg-light p-2 mb-2 text-center font-weight-bold">
                            Select a chat to start messaging
                        </div>
                        <div id="message-list" class="border p-3" style="height: 400px; overflow-y: auto;">
                            <p class="text-muted text-center">No chat selected</p>
                        </div>
                        <div class="input-group mt-2">
                            <input type="text" class="form-control" id="message-input" placeholder="Type a message..." disabled>
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="send-message" disabled>Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar */
    #chat-list::-webkit-scrollbar,
    #message-list::-webkit-scrollbar {
        width: 8px;
    }

    #chat-list::-webkit-scrollbar-track,
    #message-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #chat-list::-webkit-scrollbar-thumb,
    #message-list::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    #chat-list::-webkit-scrollbar-thumb:hover,
    #message-list::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Chat Item Hover Effect */
    .chat-item:hover {
        background-color: #f8f9fa;
        transform: scale(1.02);
        transition: transform 0.2s ease;
    }

    /* Message Bubbles */
    .message-bubble {
        max-width: 75%;
        padding: 10px 15px;
        border-radius: 15px;
        margin-bottom: 10px;
        position: relative;
    }

    .message-bubble.sender {
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        margin-left: auto;
    }

    .message-bubble.receiver {
        background: linear-gradient(135deg, #FFA500, #ff8c00);
        color: white;
        margin-right: auto;
    }
</style>

<script type="module">
    import { 
         initializeApp 
     } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-app.js";

     import { 
         getFirestore, 
         collection, 
         query, 
         orderBy, 
         onSnapshot, 
         addDoc, 
         serverTimestamp, 
         doc,         
         setDoc,  
         updateDoc,  
         arrayUnion  
     } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-firestore.js";
     
     const firebaseConfig = {
         apiKey: "AIzaSyBEX_fHfwQdQOX3IeL1CSznnIA67zga-ss",
         authDomain: "heart-spark-2af15.firebaseapp.com",
         projectId: "heart-spark-2af15",
         storageBucket: "heart-spark-2af15.appspot.com",
         messagingSenderId: "285799074278",
         appId: "1:285799074278:web:65191c043c1b382c36ae27",
         measurementId: "G-PTMKMXEC24"
     };

     // Initialize Firebase
     const app = initializeApp(firebaseConfig);
     const db = getFirestore(app);
     
     let currentChatUserId = null;
     let currentChatUserName = null;
     const loggedInUserId = "{{ Auth::id() }}";
     
     const messageList = document.getElementById("message-list");
     const messageInput = document.getElementById("message-input");
     const sendMessageButton = document.getElementById("send-message");

     // Function to fetch and display messages in real-time
     const listenForMessages = (userId) => {
         if (!userId) return;

         messageList.innerHTML = `<p class="text-muted text-center">Loading messages...</p>`;

         const chatId = [loggedInUserId, userId].sort().join("_"); // Ensure consistent chat ID
         const chatRef = collection(db, "chats", chatId, "messages");

         const messagesQuery = query(chatRef, orderBy("timestamp", "asc"));

         onSnapshot(messagesQuery, (querySnapshot) => {
             messageList.innerHTML = ""; // Clear previous messages

             if (querySnapshot.empty) {
                 messageList.innerHTML = `<p class="text-muted text-center">No messages yet. Start the conversation!</p>`;
                 return;
             }

             querySnapshot.forEach((doc) => {
                 const messageData = doc.data();

                 const messageElement = document.createElement("div");
                 messageElement.classList.add("message-bubble", messageData.sender_id === loggedInUserId ? "sender" : "receiver");

                 messageElement.innerHTML = `
                     <p class="mb-0">${messageData.message}</p>
                     <small class="d-block text-white-50">
                         ${messageData.timestamp?.seconds 
                             ? new Date(messageData.timestamp.seconds * 1000).toLocaleTimeString() 
                             : 'Time unavailable'}
                     </small>
                 `;

                 messageList.appendChild(messageElement);
             });

             messageList.scrollTop = messageList.scrollHeight;
         }, (error) => {
             console.error("Error fetching messages:", error);
         });
     };

     // Chat Selection
  // Chat Selection
document.addEventListener("DOMContentLoaded", function () {
    const chatItems = document.querySelectorAll(".chat-item");

    chatItems.forEach((item) => {
        item.addEventListener("click", function (event) {
            event.preventDefault();

            // Remove active class from all items
            chatItems.forEach((el) => {
                el.style.backgroundColor = ""; // Reset background color
                el.style.color = ""; // Reset text color
            });

            // Set active styles for the clicked item
            this.style.backgroundColor = "#90c4fc"; // Hex color for background
            this.style.color = "#FFFFFF"; // White text for better contrast
            this.style.transition = "background-color 0.3s ease"; // Smooth transition

            // Set selected user
            currentChatUserId = this.dataset.userId;
            currentChatUserName = this.dataset.userName;

            // Update chat header
            document.getElementById("chat-header").innerText = `Chat with ${currentChatUserName}`;
            messageInput.disabled = false;
            sendMessageButton.disabled = false;

            // Load messages
            listenForMessages(currentChatUserId);
        });
    });
});
     // Sending Messages
     sendMessageButton.addEventListener("click", async function () {
         const content = messageInput.value.trim();
         if (!content || !currentChatUserId) return;

         const chatId = [loggedInUserId, currentChatUserId].sort().join("_"); // Ensure consistent chat ID
         const chatDocRef = doc(db, "chats", chatId);
         const messagesCollectionRef = collection(chatDocRef, "messages");

         // Ensure the chat document exists
         await setDoc(chatDocRef, {
             users: arrayUnion(loggedInUserId, currentChatUserId),
             updated_at: serverTimestamp()
         }, { merge: true });

         // Add new message
         await addDoc(messagesCollectionRef, {
             sender_id: loggedInUserId,
             message: content,
             timestamp: serverTimestamp(),
         });

         messageInput.value = "";
     });
 </script>
 
@endsection