import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';

export default function User({ users }) {
    const handleUserClick = (receiverId) => {
        // Navigate to the chat page with the selected user ID
        Inertia.get(`/chat/${receiverId}`);
    }

    return (
        <div>
            <h1>Users List</h1>
            <ul>
                {users.map((user) => (
                    <li key={user.id}>
                        <Link href="#" onClick={() => handleUserClick(user.id)}>
                            {user.name}
                        </Link>
                    </li>
                ))}
            </ul>
        </div>
    );
}
