import { useState, useEffect } from 'react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Inertia } from '@inertiajs/inertia';
import { router } from '@inertiajs/react';

export default function ChatUser({ users, receiver }) {
  const [messages, setMessages] = useState([]);
  const [newMessage, setNewMessage] = useState('');

  useEffect(() => {
    // Fetch messages when the component is mounted (use the receiver's id)
    fetchMessages();
  }, [receiver]);

  const fetchMessages = async () => {
    // Fetch chat messages from the backend for the current conversation (receiver)
    const response = await fetch(`/api/messages/${users.receiver_id}`);
    const data = await response.json();
    setMessages(data.messages);
  };

  const handleSendMessage =  () => {
    if (!newMessage.trim()) return;

    try {
      // Send the message via API
      router.post('/chat', {
        message: newMessage,
        receiver_id: receiver.id,
      });

      // Update the messages state to reflect the new message
      setMessages([...messages, { message: newMessage, sender_id: receiver.id }]);
      setNewMessage('');
    } catch (error) {
      console.error('Error sending message:', error);
    }
  };

  return (
    <AuthenticatedLayout>
      <div className="min-h-screen flex flex-col bg-gray-100 p-4">
        <div className="bg-white shadow-lg rounded-lg max-w-3xl mx-auto flex flex-col h-full">
          {/* Chat Header */}
          <div className="bg-gray-800 text-white p-4 rounded-t-lg flex items-center">
           
            <span className="font-semibold text-lg">{users.name}</span>
          </div>

          {/* Messages List */}
          <div className="flex-1 p-4 overflow-y-auto">
            <div className="space-y-4">
              {/* {messages.map((msg, index) => (
                <div
                  key={index}
                  className={`flex ${msg.sender_id === receiver.id ? 'justify-start' : 'justify-end'}`}
                >
                  <div
                    className={`p-3 rounded-lg max-w-xs ${msg.sender_id === receiver.id ? 'bg-gray-200' : 'bg-blue-500 text-white'}`}
                  >
                    <p>{msg.message}</p>
                  </div>
                </div>
              ))} */}
            </div>
          </div>

          {/* Message Input & Send Button */}
          <div className="flex items-center p-4 bg-gray-200 rounded-b-lg">
            <input
              type="text"
              value={newMessage}
              onChange={(e) => setNewMessage(e.target.value)}
              placeholder="Type a message..."
              className="flex-1 p-2 rounded-lg border border-gray-300"
            />
            <button
              onClick={handleSendMessage}
              className="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg"
            >
              Send
            </button>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
