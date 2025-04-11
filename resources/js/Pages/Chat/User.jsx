import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';

export default function User({ users }) {
    const handleUserClick = (receiverId) => {
        Inertia.get(`/chat/${receiverId}`);

    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100  px-4">
            <div className="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h1 className="text-2xl font-bold mb-6 text-center text-gray-900 dark:text-white">
                    Users List
                </h1>
                <ul role="list" className="divide-y divide-gray-200 dark:divide-gray-700">
                    {users.map((user, index) => (

                        <li
                            key={user.id}
                          
                            className="py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition rounded-md px-2 cursor-pointer"

                        >
                            <Link
                                href={`/chat/${user.id}`}
                                className="flex items-center space-x-4 rtl:space-x-reverse"
                            >
                                <div className="flex items-center space-x-4 rtl:space-x-reverse">
                                    <img
                                        className="w-10 h-10 rounded-full object-cover"
                                        src={user.avatar || '/default-avatar.png'}
                                        alt={`${user.name} image`}
                                    />
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
                            </Link>
                        </li>
                    ))}
                </ul>
            </div>
        </div >
    );
}
