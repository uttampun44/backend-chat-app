import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';

export default function User({ users }) {
    const handleUserClick = (receiverId) => {
        Inertia.get(`/chat/${receiverId}`);
    };

    return (
        <div className="max-w-sm divide-y divide-gray-200 dark:divide-gray-700">
            <h1 className="text-xl font-bold mb-4 text-gray-900 dark:text-white">Users List</h1>
            <ul role="list">
                {users.map((user) => (
                    <li key={user.id} className="py-3 sm:py-4">
                        <div className="flex items-center space-x-3 rtl:space-x-reverse cursor-pointer" onClick={() => handleUserClick(user.id)}>
                            <div className="shrink-0">
                                <img
                                    className="w-8 h-8 rounded-full"
                                    src={user.avatar || '/default-avatar.png'} // fallback if no avatar
                                    alt={`${user.name} image`}
                                />
                            </div>
                            <div className="flex-1 min-w-0">
                                <p className="text-sm font-semibold text-gray-900 truncate dark:text-white">
                                    {user.name}
                                </p>
                                <p className="text-sm text-gray-500 truncate dark:text-gray-400">
                                    {user.email}
                                </p>
                            </div>
                            <span
                                className={`inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full 
                                    ${user.is_online
                                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                        : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                    }`}
                            >
                                <span
                                    className={`w-2 h-2 me-1 rounded-full ${user.is_online ? 'bg-green-500' : 'bg-red-500'}`}
                                ></span>
                                {user.is_online ? 'Available' : 'Unavailable'}
                            </span>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
}
