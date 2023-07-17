import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import FlashMessage from '@/Components/FlashMessage';


export default function Guest({ children }) {
    return (
        <>
            <div className='fixed top-0 left-[40%] z-1 transition translate-y-4'>
                <FlashMessage />
            </div>
            <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#203956]">
                <div className="xl:w-full lg:w-full sm:max-w-md mt-6 px-6 mb-3 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {children}
                </div>
            </div>
        </>
    );
}
