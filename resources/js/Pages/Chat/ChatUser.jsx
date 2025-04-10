import { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function ChatUser({ users, receiver }) {
    const [selectedUser, setSelectedUser] = useState(receiver);
    const [message, setMessage] = useState('');
    const [messages, setMessages] = useState([
        // Placeholder example of previous messages
        { sender_id: 1, text: 'Hello, how are you?' },
        { sender_id: 2, text: "I'm doing well, thanks! How about you?" },
    ]);

    // Handle user click to switch chats
    const handleUserClick = (user) => {
        setSelectedUser(user);
        Inertia.get(`/chat/${user.id}`);
    };

    // Handle message input change
    const handleMessageChange = (e) => {
        setMessage(e.target.value);
    };

    // Handle form submission
    const handleSubmit = (e) => {
        e.preventDefault();

        if (!message.trim()) return;  // Don't submit if message is empty

        const formData = {
            message,
            receiver_id: selectedUser.id,
        };

        // Send message via Inertia POST request
        Inertia.post('/chat/store', formData, {
            onSuccess: () => {
                // After successful submission, clear message input
                setMessage('');
            },
        });
    };

    return (
       <AuthenticatedLayout>
         <div className="flex h-screen">
            {/* Sidebar with the list of users */}
            <div className="w-64 bg-gray-100 p-4 shadow-md">
                <h2 className="text-xl font-semibold mb-4">Inbox</h2>
                <ul className="space-y-3">
                    {users.map((user) => (
                        <li
                            key={user.id}
                            className={`flex items-center p-3 rounded-lg cursor-pointer transition-all duration-200 ${
                                selectedUser.id === user.id ? 'bg-blue-100' : 'hover:bg-gray-200'
                            }`}
                            onClick={() => handleUserClick(user)}
                        >
                            <div className="w-10 h-10 rounded-full overflow-hidden mr-3">
                                {/* Avatar or profile picture */}
                                <img
                                    src={user.avatar || 'default-avatar.jpg'}
                                    alt={user.name}
                                    className="w-full h-full object-cover"
                                />
                            </div>
                            <span className="font-medium">{user.name}</span>
                        </li>
                    ))}
                </ul>
            </div>

            {/* Chat Box Area */}
            <div className="flex-grow bg-white p-6 flex flex-col">
                <h2 className="text-2xl font-semibold mb-4">Chat with {selectedUser.name}</h2>

                {/* Messages Display */}
                <div className="flex-grow overflow-y-auto space-y-4 mb-6">
                    {messages.map((msg, index) => (
                        <div
                            key={index}
                            className={`flex ${msg.sender_id === 1 ? 'justify-start' : 'justify-end'}`}
                        >
                            <div
                                className={`p-3 rounded-lg max-w-xs ${
                                    msg.sender_id === 1 ? 'bg-gray-100' : 'bg-blue-100'
                                }`}
                            >
                                <p className="text-gray-700">{msg.text}</p>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Message Input Form */}
                <form onSubmit={handleSubmit} className="flex items-center">
                    <textarea
                        value={message}
                        onChange={handleMessageChange}
                        placeholder="Type your message..."
                        className="w-full p-3 border border-gray-300 rounded-lg resize-none h-16 focus:outline-none focus:ring-2 focus:ring-blue-300"
                    />
                    <button
                        type="submit"
                        className="ml-3 p-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none"
                    >
                        Send
                    </button>
                </form>
            </div>
        </div>
       </AuthenticatedLayout>
    );
}
